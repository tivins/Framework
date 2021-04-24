<?php

namespace Tivins\Framework;

use Tivins\Database\Database;
use Tivins\Database\Connectors\Connector;
use Parsedown;

class App
{
    private static Database     $db;
    private static Router       $router;
    private static Logger       $logger;
    private static Parsedown    $parsedown;
    private static Msg          $msg;
    private static HTMLDocument $doc;

    public static function init()
    {
        Session::init();
        self::$msg      = new Msg();
        self::$router   = new Router();
        self::$doc      = new HTMLDocument();
    }

    public static function initDB(Connector $connector) { self::$db = new Database($connector); }
    public static function initMarkdown() { self::$parsedown = new Parsedown(); }

    public static function markdown($str) : string
    {
        Hooks::run('pre-markdown', $str);
        $str = self::$parsedown->text($str);
        Hooks::run('post-markdown', $str);
        return $str;
    }

    public static function router() : Router { return self::$router; }
    public static function db() : Database { return self::$db; }
    public static function msg() : Msg { return self::$msg; }
    public static function doc() : HTMLDocument { return self::$doc; }
    public static function logger() : Logger { return self::$logger; }
    public static function setLogger(Logger $logger) : void { self::$logger = $logger; }
    public static function setHTMLDocument(HTMLDocument $doc) : void { self::$doc = $doc; }
    public static function setMessenger(Msg $msg) : void { self::$msg = $msg; }
}