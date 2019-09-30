<?php

namespace Viviniko\Content\Enums;

class Types
{
    const MENU = 'Menu';
    const LIST = 'List';
    const SINGLE = 'Single';

    public static function values()
    {
        return [
            static::MENU => 'Menu',
            static::LIST => 'List',
            static::SINGLE => 'Single',
        ];
    }
}