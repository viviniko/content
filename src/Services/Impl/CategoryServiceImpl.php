<?php

namespace Viviniko\Content\Services\Impl;

use Viviniko\Content\Repositories\Category\CategoryRepository;
use Viviniko\Content\Services\CategoryService;

class CategoryServiceImpl implements CategoryService
{
    /**
     * @var \Viviniko\Content\Repositories\Category\CategoryRepository
     */
    protected $categoryRepository;

    /**
     * EloquentCategory constructor.
     * @param \Viviniko\Content\Repositories\Category\CategoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function categories()
    {
        return $this->categoryRepository->all();
    }

    /**
     * {@inheritdoc}
     */
    public function getCategory($id)
    {
        return $this->categoryRepository->find($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getCategoriesByIdIn(array $id)
    {
        return $this->categoryRepository->findAllBy('id', $id);
    }

    /**
     * {@inheritdoc}
     */
    public function getCategoryChildren($categoryId, $recursive = true)
    {
        $children = collect([]);

        foreach ($this->categoryRepository->findAllBy('parent_id', $categoryId) as $category) {
            $children->push($category);
            if ($recursive) {
                $children = $children->merge($this->getCategoryChildren($category->id, $recursive));
            }
        }

        return $children;
    }

    /**
     * {@inheritdoc}
     */
    public function createCategory(array $data)
    {
        return $this->categoryRepository->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function updateCategory($id, array $data)
    {
        return $this->categoryRepository->update($id, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteCategory($id)
    {
        return $this->categoryRepository->delete($id);
    }
}