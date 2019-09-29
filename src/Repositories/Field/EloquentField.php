<?php

namespace Viviniko\Content\Repositories\Field;

use Illuminate\Support\Facades\Config;
use Viviniko\Repository\EloquentRepository;

class EloquentField extends EloquentRepository implements FieldRepository
{
    public function __construct()
    {
        parent::__construct(Config::get('content.field'));
    }
}