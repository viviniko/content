<?php

namespace Viviniko\Content\Repositories\Model;

use Illuminate\Support\Facades\Config;
use Viviniko\Repository\EloquentRepository;

class EloquentModel extends EloquentRepository implements ModelRepository
{
    public function __construct()
    {
        parent::__construct(Config::get('content.model'));
    }
}