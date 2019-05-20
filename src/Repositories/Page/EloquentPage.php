<?php

namespace Viviniko\Content\Repositories\Page;

use Illuminate\Support\Facades\Config;
use Viviniko\Repository\EloquentRepository;

class EloquentPage extends EloquentRepository implements PageRepository
{
    public function __construct()
    {
        parent::__construct(Config::get('content.page'));
    }
}