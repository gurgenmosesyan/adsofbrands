<?php

namespace App\Core\Util;

define('MW_CHAR_REFS_REGEX',
'/&([A-Za-z0-9\x80-\xff]+);
 |&\#([0-9]+);
 |&\#x([0-9A-Za-z]+);
 |&\#X([0-9A-Za-z]+);
 |(&)/x');

class MakeAlias
{
    protected $aliasMaxLength = 100;
    protected $fromText = null;

    protected function setMaxLength($length)
    {
        $this->aliasMaxLength = intval($length);
    }

    protected function setFromText($text)
    {
        $this->fromText = $text;
    }

    public static function makeAliasStr($text, $maxLength = 100)
    {
        $text = strtolower(strval($text));

        # Convert things like &eacute; &#257; or &#x3017; into real text...
        $filteredText = self::decodeCharReferences($text);

        $alias = new MakeAlias;
        $alias->setMaxLength($maxLength);
        $alias->setFromText(str_replace(' ', '-', $filteredText));

        $newAlias = $alias->filterAlias();

        if (self::strLen($newAlias) > $alias->aliasMaxLength) {
            $newAlias = mb_substr($newAlias, 0, ($alias->aliasMaxLength-1), 'UTF-8');
        }
        return $newAlias;
    }

    public static function decodeCharReferences($text)
    {
        return preg_replace_callback(
            MW_CHAR_REFS_REGEX,
            array('self', 'decodeCharReferencesCallback'),
            $text);
    }

    public static function decodeCharReferencesCallback($matches)
    {
        if ($matches[1] != '') {
            return '' ; //UIS_Filter::decodeEntity( $matches[1] );
        } else if ($matches[2] != '') {
            return self::decodeChar(intval($matches[2]));
        } else if ($matches[3] != '') {
            return self::decodeChar(hexdec($matches[3]));
        } else if ($matches[4] != '') {
            return self::decodeChar(hexdec($matches[4]));
        }
        # Last case should be an ampersand by itself
        return $matches[0];
    }

    public static function decodeChar($codepoint)
    {
        if (self::validateCodepoint($codepoint)) {
            return codepointToUtf8($codepoint);
        } else {
            return UTF8_REPLACEMENT;
        }
    }

    public static function validateCodepoint($codepoint)
    {
        return ($codepoint ==    0x09)
        || ($codepoint ==    0x0a)
        || ($codepoint ==    0x0d)
        || ($codepoint >=    0x20 && $codepoint <=   0xd7ff)
        || ($codepoint >=  0xe000 && $codepoint <=   0xfffd)
        || ($codepoint >= 0x10000 && $codepoint <= 0x10ffff);
    }

    protected function filterAlias()
    {
        $fromText = $this->fromText;
        # Matching alias will be held as illegal.
        $rxTc = '/' .
            # Any character not allowed is forbidden...
            '[^' . self::legalChars() . ']' .
            # URL percent encoding sequences interfere with the ability
            # to round-trip alias -- you can't link to them consistently.
            '|%[0-9A-Fa-f]{2}' .
            # XML/HTML character references produce similar issues.
            '|&[A-Za-z0-9\x80-\xff]+;' .
            '|&#[0-9]+;' .
            '|&#x[0-9A-Fa-f]+;' .
            '/S';
        # Strip Unicode bidi override characters.
        $fromText = preg_replace( '/\xE2\x80[\x8E\x8F\xAA-\xAE]/S'   , '' , $fromText );
        # Strip  illegal UTF-8 sequences or forbidden Unicode chars.
        $fromText = preg_replace( '/\xef\xbf\xbd/S'					 , '' , $fromText );

        # replace all not allowed chars
        $fromText = preg_replace(  $rxTc , '-' , $fromText);

        # Clean up whitespace
        $fromText = preg_replace(  "/(-_|_-){1,}/S" , '-' , $fromText);
        $fromText = preg_replace( '/[-]+/', '-', $fromText );
        $fromText = trim( $fromText, '-' );
        $fromText = preg_replace( '/[ _]+/', '_', $fromText );
        $fromText = trim( $fromText, '_' );

        return $fromText;
    }

    public static function legalChars()
    {
        return "-0-9A-Z\_a-z\\x80-\\xFF";
    }

    public static function strLen($str, $encoding = 'UTF-8')
    {
        if ($encoding === null) {
            return mb_strlen($str);
        }
        return mb_strlen($str, $encoding);
    }
}