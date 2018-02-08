<?php

namespace Viviniko\Content\Enums;

class PageType
{
    const HTML = 'Html';
    const LINK = 'Link';

    public static function values()
    {
        return [
            static::HTML => static::HTML,
            static::LINK => static::LINK,
        ];
    }
}