<?php

namespace Viviniko\Content\Services;

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