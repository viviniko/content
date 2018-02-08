<?php

namespace Viviniko\Content\Services;

use Viviniko\Content\Contracts\ContentService;
use Viviniko\Content\Repositories\Category\CategoryRepository;
use Viviniko\Content\Repositories\Page\PageRepository;

class ContentServiceImpl implements ContentService
{
    protected $categoryRepository;

    protected $pageRepository;

    public function __construct(CategoryRepository $categoryRepository, PageRepository $pageRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->pageRepository = $pageRepository;
    }

    public function categories()
    {
        return $this->categoryRepository->all();
    }

    /**
     * {@inheritdoc}
     */
    public function pages($categoryName)
    {
        $categories = $this->categories();
        $lowerCategoryName = strtolower($categoryName);
        $category = $categories->filter(function ($item) use ($lowerCategoryName) { strtolower($item->name) == $lowerCategoryName; })->first();
        $pages = collect([]);
        if ($category) {
            $pages = $this->pageRepository->findByCategoryId($category->id);
        }

        return $pages;
    }
}