<?php

namespace Viviniko\Content\Repositories\Page;

use Viviniko\Repository\SimpleRepository;

class EloquentPage extends SimpleRepository implements PageRepository
{
    protected $modelConfigKey = 'content.page';

    protected $fieldSearchable = ['id', 'title' => 'like', 'category_id', 'is_active', 'type'];

    /**
     * {@inheritdoc}
     */
    public function findByCategoryId($categoryId)
    {
        return $this->findBy('category_id', $categoryId);
    }
}