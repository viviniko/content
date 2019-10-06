<?php

namespace Viviniko\Content;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Config;

trait HasDataTrait
{
    private $data;

    private $originalData;

    public function withData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        if ($this->withData($data)->exists()) {
            static::persistModelData($this);
        }
    }

    public function mergeData($data)
    {
        $data = array_merge((array)$this->data, $this->getOriginalData(), $data);
        $this->setData($data);
    }

    /**
     * Boot the HasDataTrait trait for a model.
     *
     * @return void
     */
    public static function bootHasDataTrait()
    {
        static::created(function ($model) {
            static::persistModelData($model);
        });

        static::saved(function ($model) {
            $model->refreshOriginalData();
        });

        static::deleted(function ($model) {
            try {
                $model->data()->delete();
            } catch (QueryException $e) {
                // ignored
            }
        });
    }

    public function data()
    {
        return $this->hasOne(Config::get('content.data'), 'id');
    }

    public function getDataAttribute()
    {
        $data = array_merge($this->toArray(), $this->getOriginalData(), ['url' => $this->url]);

        return (object)$data;
    }

    public function __get($name)
    {
        if (($result = parent::__get($name)) !== null) {
            return $result;
        }

        return ($data = $this->getDataAttribute()) && property_exists($data, $name) ? data_get($data, $name) : $result;
    }

    public function getOriginalData()
    {
        if (!$this->originalData) {
            $this->originalData = (array)data_get($this->data()->first(['data']), 'data', []);
        }
        return $this->originalData;
    }

    public function refreshOriginalData()
    {
        $this->originalData = null;
    }

    protected static function persistModelData($model)
    {
        $model->data()->updateOrCreate(['id' => $model->getKey()], [
            'data' => $model->getData()
        ]);
    }
}