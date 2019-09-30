<?php

namespace Viviniko\Content\Repositories\Item;

use Illuminate\Support\Facades\Config;
use Viviniko\Repository\EloquentRepository;

class EloquentItem extends EloquentRepository implements ItemRepository
{
    public function __construct()
    {
        parent::__construct(Config::get('content.item'));
    }
}