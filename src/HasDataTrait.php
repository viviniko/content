<?php

namespace Viviniko\Content;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Config;

trait HasDataTrait
{
    private $data;

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
            $this->persistData();
        }
    }

    public function persistData()
    {
        $this->data()->save([
            'data' => $this->getData()
        ]);
    }

    /**
     * Boot the HasDataTrait trait for a model.
     *
     * @return void
     */
    public static function bootHasDataTrait()
    {
        static::saved(function ($model) {
            $model->persistData();
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
}