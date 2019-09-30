<?php

namespace Viviniko\Content\Contracts;

interface Viewer
{
    /**
     * @return string
     */
    public function render();
}