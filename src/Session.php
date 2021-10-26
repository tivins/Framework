<?php

namespace Tivins\Framework;

class Session
{
    /**
     * Initialize the session with necessary components.
     */
    public static function init(Request $request) : void
    {
        session_start();
        if (!isset($_SESSION['uid']))   $_SESSION['uid']    = 0;
        if (empty($_SESSION['token']))  $_SESSION['token']  = bin2hex(random_bytes(32));
        if (empty($_SESSION['token2'])) $_SESSION['token2'] = random_bytes(32);
        if (empty($_SESSION['lang']))   self::setLang($request->getPreferedLanguage());
    }

    /**
     * Returns if the current user is authenticated or not.
     */
    public static function auth() : bool
    {
        return !empty($_SESSION['uid']);
    }

    /**
     * @return The shortCode of the current language.
     */
    public static function getLang(): string
    {
        return $_SESSION['lang'];
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    public static function get($key)
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * Set the current lang.
     *
     * @return
     *      True If $shortCode is a valid, accepted language, false otherwise.
     */
    public static function setLang(string $shortCode): bool
    {
        if (! Langs::exists($shortCode)) {
            return false;
        }
        $_SESSION['lang'] = Lang::getValidated($shortCode);
        return true;
    }

    /**
     *
     */
    public static function getFormToken(string $formId) : string
    {
        return hash_hmac('sha256', $formId, $_SESSION['token2']);
    }

    /**
     *
     */
    public static function encodeSecurityToken(string $formId) : string
    {
        return base64_encode(
            join('.', [
                $formId,
                $_SESSION['token'],
                self::getFormToken($formId)
            ])
        );
    }

    /**
     *
     */
    public static function checkFormToken(string $formId, string $postedToken) : bool
    {
        $decoded = array_filter(explode('.', base64_decode($postedToken)));
        return count($decoded) == 3         // we need our 3 values
            && $decoded[0] === $formId      // check the form id
            && hash_equals($_SESSION['token'], $decoded[1])  // check the main token
            && hash_equals(Session::getFormToken($formId), $decoded[2]) // check the form token
            ;
    }

    public static function destroy()
    {
        session_destroy();
        redirect('/');
    }
}
