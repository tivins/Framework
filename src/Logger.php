<?php

namespace Tivins\Framework;

abstract class Logger
{
    public const DEBUG   = 1;
    public const INFO    = 2;
    public const WARNING = 3;
    public const ERROR   = 4;

    public function debug($msg) : void { $this->trace(self::DEBUG, $msg); }
    public function info($msg) : void { $this->trace(self::INFO, $msg); }
    public function error($msg) : void { $this->trace(self::ERROR, $msg); }
    public function warn($msg) : void { $this->trace(self::WARNING, $msg); }

    public function trace(string $type, $msg) : void
    {
        if (!is_null($this->allowedTypes) && !in_array($type, $this->allowedTypes)) {
            return;
        }

        $args = array_slice(func_get_args(), 2);
        $args_s = empty($args) ? '' : json_encode($args);

        $this->render($type, is_string($msg) ? $msg : json_encode($msg), $args_s);
    }

    public function setAllowedTypes(array $types) {
        $this->allowedTypes = $types;
    }

    public function typeToString(int $type) : string {
        switch ($type) {
            case self::DEBUG:   return 'debug';
            case self::INFO:    return 'info';
            case self::WARNING: return 'warning';
            case self::ERROR:   return 'error';
        }
        return (string) $type;
    }

    abstract protected function render(string $type, string $msg, string $data = '') : void;

    private ?array $allowedTypes = null; // null = all
}