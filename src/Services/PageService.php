<?php

namespace Viviniko\Content\Services;

interface PageService
{
    /**
     * Paginate the given query into a simple paginator.
     *
     * @param null $perPage
     * @param array $wheres
     * @param array $orders
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage, $wheres = [], $orders = []);
}