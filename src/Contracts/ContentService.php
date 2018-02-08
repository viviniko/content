<?php

namespace Viviniko\Content\Contracts;

interface ContentService
{
    /**
     * Get pages by given category name.
     *
     * @param $categoryName
     * @return mixed
     */
    public function pages($categoryName);
}