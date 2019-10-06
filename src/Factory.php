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
        $widget = $this->categoryRepository->findBy('slug', $name);

        return $widget ? new Viewer($this, $widget) : null;
    }

    public function render($name, $ttl = null)
    {
        if (is_array($name)) {
            $view = $name[1];
            $name = $name[0];
        } else {
            $view = $name;
        }
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

        if (!property_exists($data, 'url')) {
            $data->url = data_get($data, 'link') ?? data_get($data, 'href') ?? data_get($data, 'slug');
        }
        if ($category->type === CategoryTypes::MENU) {
            if (!property_exists($data, 'parent_id')) {
                $data->parent_id = 0;
            }
            if (!property_exists($data, 'text')) {
                $data->text = data_get($data, 'title') ?? data_get($data, 'name');
            }
            if ($data->text && property_exists($data, 'slug') && $data->slug) {
                $data->text .= "({$data->slug})";
            }
            if (!property_exists($data, 'icon')) {
                if ($icon = data_get($data, 'image') ?? data_get($data, 'picture')) {
                    $data->icon = $icon;
                }
            }
        }

        return $data;
    }
}