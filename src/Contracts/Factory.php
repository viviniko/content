<?php

namespace Viviniko\Content\Contracts;

use Illuminate\Support\Collection;

interface Factory
{
    /**
     * Make Content.
     *
     * @param $name
     * @return Viewer
     */
    public function make($name);

    /**
     * @param  $categoryId
     * @return  mixed
     */
    public function getDataByCategoryId($categoryId);

    /**
     * @param $items
     * @param null $parentId
     * @param string $parentKey
     * @return mixed
     */
    public function buildTree(Collection $items, $parentId = null, $parentKey = 'parent_id');
}