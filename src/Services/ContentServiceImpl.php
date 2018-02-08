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

}