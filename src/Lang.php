<?php

namespace Tivins\Framework;

/**
 * ex:
 * $lang->addLanguages('fr','de','pt-br');
 */

class Lang
{
    private static array $acceptedLanguages = [ 'en' ];

    public static function setAccepted(string ...$shortCodes): void
    {
        self::$acceptedLanguages = array_filter(
            array:      $shortCodes,
            callback:   fn($shortCode) => Langs::exists($shortCode)
        );
    }

    public static function getValidated(string $wantedLanguage): string
    {
        $wantedLanguage = trim(strtolower($wantedLanguage));
        if (in_array($wantedLanguage, self::$acceptedLanguages))
        {
            return $wantedLanguage;
        }
        // Return default
        return reset(self::$acceptedLanguages);
    }
}