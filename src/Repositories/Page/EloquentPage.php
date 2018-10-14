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

    protected $fieldSearchable = ['id', 'title' => 'like', 'category_id', 'is_active', 'type'];

    /**
     * {@inheritdoc}
     */
    public function findByCategoryId($categoryId)
    {
        return $this->findBy('category_id', $categoryId);
    }
}