<?php

namespace Tivins\Framework;

/**
 * Simple Template Engine
 *
 * Basics replacements :
 *
 * * {{ variable }} : HTML entities.
 * * {$ variable $} : Translated and HTML entities.
 * * {! variable !} : No process.
 * * {^ file.html ^} : Include file.
 *
 * ## Usage
 *
 * ```php
 * use Tivins\Framework\Tpl;
 * $tpl = new Tpl("<p>{{greetings}}</p>");
 * $tpl->setVar("greetings", "Hello & world");
 * echo $tpl; // `<p>Hello &amp; world</p>`
 * ```
 *
 * ## Blocks
 *
 * ```html
 * <!-- BEGIN blockname -->
 * <p>A block that contains a {{ variable }}.</p>
 * <!-- END blockname -->
 * ```
 *
 * ```php
 * $tpl->block('blockname', ['variable' => 'lorem']);
 * $tpl->block('blockname', ['variable' => 'ipsum']);
 * ```
 *
 * Will render :
 *
 * ```html
 * <p>A block that contains a lorem.</p>
 * <p>A block that contains a ipsum.</p>
 * ```
 *
 * NB: if there is no $tpl->block('blockname', $args), the block will not be
 * rendered.
 *
 * ## Nested blocks
 *
 * ```html
 * <!-- BEGIN blockname -->
 * <p>A block that contains a {{ variable }}.</p>
 *   <!-- BEGIN subblockname -->
 *   <p>A subblock that contains {{  anotherVariable }}.</p>
 *   <!-- END subblockname -->
 * <!-- END blockname -->
 * ```
 *
 * ...todo
 *
 */
class Tpl
{
    public string $html     = '';
    public array  $vars     = [];
    private array $storage  = []; /*blocks*/

    /**
     *
     */
    public function __construct(string $fileOrContent)
    {
        if (file_exists($fileOrContent)) {
            $this->load($fileOrContent);
        } else {
            $this->setBody($fileOrContent);
        }
    }

    /**
     *
     */
    public function concat(string $html): self
    {
        $this->html .= $html;
        return $this;
    }

    /**
     *
     */
    public function setBody(string $body): self
    {
        $this->html = $body;
        $this->html = $this->parseBlocks($this->html);
        return $this;
    }

    /**
     *
     */
    public function load(string $filename): bool
    {
        $data = IO::download($filename);
        if (is_null($data)) {
            return false;
        }
        $this->setBody($data);
        return true;
    }

    /**
     *
     */
    public function setVar(string $key, string $value): self
    {
        $this->vars[$key] = $value;
        return $this;
    }

    /**
     *
     */
    public function setVars(array $keys_values): self
    {
        $this->vars += $keys_values;
        return $this;
    }

    /**
     *
     */
    public function process(string $str, array $vars): string
    {
        $str = preg_replace_callback('~\{\^\s?([a-zA-Z0-9\-\.]*)\s?\^\}~',
            function($matches) use ($vars) {

                return IO::download(FRAMEWORK_ROOT_PATH.'/templates/'.$matches[1]);
            },
            $str);

        $str = $this->replaceBlocks($str);

        $str = preg_replace_callback('~\{\{\s?([a-zA-Z0-9]*)\s?\|?\s?([a-zA-Z0-9_,]+)?\s?\}\}~',
            function($matches) use ($vars) {
                $base = $vars[$matches[1]] ?? $matches[1];
                if (isset($matches[2]) && in_array($matches[2], ['ucfirst','number_format','time_short'])) {
                    $base = call_user_func($matches[2], $base);
                }
                return html($base);
            },
            $str);

        $str = preg_replace_callback('~{!\s?(.*)\s?!}~U',
            fn($matches) => ($vars[$matches[1]] ?? $matches[1]),
            $str);

        $str = preg_replace_callback('~{\$\s?(.*)\s?\$}~U',
            fn($matches) => html(I18n::get($vars[$matches[1]] ?? $matches[1])),
            $str);

        return $str;
    }

    /**
     *
     */
    public function parseBlocks(string $str)
    {
        //$this->storage = [];
        while(preg_match('~<\!-- BEGIN ([a-zA-Z0-9]+) -->~', $str, $matches, PREG_OFFSET_CAPTURE))
        {
            [$name, $pos] = $matches[1];

            /** find END block */
            $endTag     = '<!-- END '.$name.' -->';
            $endTagPos  = strpos($str, $endTag, $pos);

            $startTagPos = $pos + strlen($name) + strlen(' -->');
            $blockStartPos = $pos - strlen('<!-- BEGIN ');
            $blockEndPos = $endTagPos + strlen($endTag);

            /** get content strings */
            $inside = substr($str, $startTagPos, $endTagPos - $startTagPos);
            $block = substr($str, $blockStartPos, $blockEndPos - $blockStartPos);

            $str = substr($str, 0, $blockStartPos)
                . '<!-- tpl('.sha1($name).') -->'
                . substr($str, $blockEndPos);

            /** store block */
            $this->storage[$name] = [
                'data' => $inside,
                'processed' => '',
            ];
        }
        return $str;
    }

    /**
     *
     */
    public function block(string $name, array $data)
    {
        if (! isset($this->storage[$name])) {
            //$this->storage[$name]['processed'] .= '*miss*';
            var_dump("miss");
            return;
        }
        $tpl = new Tpl($this->storage[$name]['data']);
        $tpl->setVars($data);
        $this->storage[$name]['processed'] .= $tpl;
    }

    /**
     *
     */
    public function replaceBlocks(string $str)
    {
        foreach ($this->storage as $name => $data) {
            $str = str_replace('<!-- tpl('.sha1($name).') -->', $data['processed'], $str);
        }
        return $str;
    }

    /**
     *
     */
    public function __toString(): string
    {
        return $this->process($this->html, $this->vars);
    }
}
