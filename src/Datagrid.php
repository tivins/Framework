<?php

namespace Tivins\Framework;

class Datagrid
{
    protected $name = '';
    protected $context = '';

    public function getPreparedItem($item): object
    {
        return $item;
    }

    public function getKeysTranslation(): array
    {
        return [];
    }

    public function render($data): string
    {
        $translations = $this->getKeysTranslation();

        $html = '';
        $html .= '<table class="tlist">';

        // -- header
        $firstPrepared = $this->getPreparedItem(clone reset($data));

        $html .= '<tr>';
        foreach ($firstPrepared as $key => $_unused_)
        {
            if (substr($key, 0, 1) == '_') {
                continue;
            }
            $html .= '<th>' . ($translations[$key]??$key) . '</th>';
        }
        $html .= '</tr>';

        // -- rows

        foreach ($data as $item)
        {
            $prepared = $this->getPreparedItem($item);

            $html .= '<tr class="' . ($prepared->_uiClassName ?? '') . '">';
            foreach ($prepared as $key => $value)
            {
                if (substr($key, 0, 1) == '_') {
                    continue;
                }
                $html .= '<td>' . $value . '</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</table>';

        /*
        return render_box([
            'title' => $this->name,
            'context' => $this->context,
            'icon'  => 'key',
            'label' => null,
            'body' => '<div class="p-md">' . $html . '</div>',
            'class' => 'flex-grow m-md',
        ]);
        */
        return $html;
    }
}
