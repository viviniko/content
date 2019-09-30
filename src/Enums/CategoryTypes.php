<?php

namespace Viviniko\Content\Enums;

class CategoryTypes
{
    const MENU = 'Menu';
    const LIST = 'List';
    const SINGLE = 'Single';

    public static function values()
    {
        return [
            static::LIST => 'List',
            static::MENU => 'Menu',
            static::SINGLE => 'Single',
        ];
    }
}