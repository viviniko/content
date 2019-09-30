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
            static::MENU => 'Menu',
            static::LIST => 'List',
            static::SINGLE => 'Single',
        ];
    }
}