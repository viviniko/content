<?php

namespace Viviniko\Content;

use Illuminate\Support\Facades\Log;
use Viviniko\Content\Contracts\Factory;
use Viviniko\Content\Enums\Types;
use Viviniko\Content\Models\Category;

class Viewer
{
    protected $factory;

    protected $category;

    public function __construct(Factory $factory, Category $category)
    {
        $this->factory = $factory;
        $this->category = $category;
    }

    public function items()
    {
        $items = $this->factory->getDataByCategoryId($this->category->id);

        try {
            if ($this->category->type == Types::MENU) {
                return $this->factory->buildTree($this->category->items);
            } else if ($this->category->type == Types::SINGLE) {
                return $items->sortBy('position')->first();
            } else if ($this->category->type == Types::LIST) {
                return $items->sortBy('position');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage() . var_export($items));
        }

        return $items;
    }

    /**
     * @param null $template
     * @return string
     */
    public function render($template)
    {
        return view($template, array_merge($this->category->getAttributes(), [
            ($this->category->type == 'Single' ? 'item' : 'items') => $this->items()
        ]))->render();
    }

    public function __get($name)
    {
        if (method_exists($this, $name)) {
            return $this->$name();
        }
        return $this->category->$name;
    }
}