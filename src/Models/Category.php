<?php

namespace Viviniko\Content\Models;

use Illuminate\Support\Facades\Config;
use Viviniko\Support\Database\Eloquent\Model;
use Viviniko\Urlrewrite\UrlrewriteTrait;

class Category extends Model
{
    use UrlrewriteTrait;

    protected $tableConfigKey = 'content.categories_table';

    protected $fillable = [
        'name', 'slug', 'description', 'is_active', 'parent_id', 'position', 'model_id', 'type', 'image',
        'meta_title', 'meta_keywords', 'meta_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    public function model()
    {
        return $this->belongsTo(Config::get('content.model'), 'model_id');
    }

    public function items()
    {
        return $this->hasMany(Config::get('content.item'), 'category_id');
    }

    public function getUrlrewriteKeyName()
    {
        return 'slug';
    }
}