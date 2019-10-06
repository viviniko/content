<?php
namespace Viviniko\Content;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Viviniko\Content\Contracts\Factory as FactoryContract;
use Viviniko\Content\Enums\CategoryTypes;
use Viviniko\Content\Repositories\Category\CategoryRepository;

class Factory implements FactoryContract
{
    /**
     * @var \Viviniko\Content\Repositories\Category\CategoryRepository
     */
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function make($name)
    {
        $widget = $this->categoryRepository->findBy('name', $name);

        return $widget ? new Viewer($this, $widget) : null;
    }

    public function render($name, $view, $ttl = null)
    {
        return Cache::tags(['content.' . $name])->remember("content/categories/{$name}/{$view}", $ttl ?: Config::get('cache.ttl'), function () use ($name, $view) {
            $viewer = $this->make($name);
            return $viewer ? $viewer->render($view) : "";
        });
    }

    public function flush($name)
    {
        return Cache::tags(['content.' . $name])->flush();
    }

    public function getDataByCategoryId($categoryId)
    {
        if ($category = $this->categoryRepository->find($categoryId)) {
            return $category->items->map(function ($item) use ($category) {
                return self::getDataByCategoryAndItem($category, $item);
            });
        }

        return false;
    }

    public function buildTree(Collection $items, $parentId = null, $parentKey = 'parent_id') {
        $collection = $items->map(function ($item) {
            return self::getDataByCategoryAndItem($item->category, $item);
        })->sortBy('position');

        $groupNodes = $collection->groupBy($parentKey);

        return $collection
            ->map(function($item) use ($groupNodes) {
                $item->children = Collection::make($groupNodes->get($item->id, []));
                return $item;
            })->filter(function($item) use ($parentId, $parentKey) {
                return data_get($item, $parentKey) == $parentId;
            })->values();
    }

    protected static function getDataByCategoryAndItem($category, $item)
    {
        $data = $item->data;

        $data->url = self::try_data_get($data, 'slug', 'url', 'link', 'href');

        if ($category->type === CategoryTypes::MENU) {
            $data->parent_id = data_get($data, 'parent_id', 0);
            $data->text = self::try_data_get($data, 'text', 'title', 'name');
            if ($data->text && !empty($data->url)) {
                $data->text .= "({$data->url})";
            }

            $data->icon = self::try_data_get($data, 'icon', 'image', 'picture');
        }

        $data->url = url($data->url);

        return $data;
    }

    public static function try_data_get($data, ...$keys)
    {
        foreach ($keys as $key) {
            if (($item = data_get($data, $key)) && !empty($item)) {
                return $item;
            }
        }

        return null;
    }
}