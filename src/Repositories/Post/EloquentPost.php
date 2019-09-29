<?php

namespace Viviniko\Content\Repositories\Post;

use Illuminate\Support\Facades\Config;
use Viviniko\Repository\EloquentRepository;

class EloquentPost extends EloquentRepository implements PostRepository
{
    public function __construct()
    {
        parent::__construct(Config::get('content.post'));
    }
}