<?php

namespace Viviniko\Content\Services\Impl;

use Illuminate\Http\Request;
use Viviniko\Content\Repositories\Page\PageRepository;
use Viviniko\Content\Services\PageService;
use Viviniko\Support\AbstractRequestRepositoryService;

class PageServiceImpl extends AbstractRequestRepositoryService implements PageService
{
    protected $repository;

    public function __construct(PageRepository $repository, Request $request)
    {
        parent::__construct($request);
        $this->repository = $repository;
    }

    public function getRepository()
    {
        return $this->repository;
    }
}