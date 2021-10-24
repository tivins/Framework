<?php

namespace Tivins\Framework;

use Tivins\Database\Database;
use Tivins\Database\Connectors\Connector;
use Parsedown;
use Exception;

class App
{
    private static Database     $db;
    private static Router       $router;
    private static Logger       $logger;
    private static Parsedown    $parsedown;
    private static Msg          $msg;
    private static HTMLDocument $doc;
    private static HTTPResponse $response;

    public static function init()
    {
        Session::init();
        self::boot();
        self::$msg      = new Msg();
        self::$router   = new Router();
        self::$doc      = new HTMLDocument();
        self::$response = new HTTPResponse();
    }

    public static function boot()
    {
        if (!isset($_SERVER['HTTP_HOST'])) { throw new Exception('HTTP_HOST missing'); }
        if (!defined('FRAMEWORK_ROOT_PATH')) { throw new Exception('FRAMEWORK_ROOT_PATH not defined'); }

        $settingsFile = FRAMEWORK_ROOT_PATH . '/settings/' . str_replace(':','-',$_SERVER['HTTP_HOST']) . '.settings.php';
        if (!is_readable($settingsFile)) { throw new Exception("settings file ($settingsFile) not readable"); }
        include $settingsFile;
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
    public static function response() : HTTPResponse { return self::$response; }
    public static function setLogger(Logger $logger) : void { self::$logger = $logger; }
    public static function setHTMLDocument(HTMLDocument $doc) : void { self::$doc = $doc; }
    public static function setMessenger(Msg $msg) : void { self::$msg = $msg; }
}