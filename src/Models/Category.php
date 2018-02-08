<?php

namespace Viviniko\Content\Models;

use Viviniko\Support\Database\Eloquent\Model;
use Viviniko\Urlrewrite\UrlrewriteTrait;

class Category extends Model
{
    use UrlrewriteTrait;

    protected $tableConfigKey = 'content.categories_table';

    protected $fillable = [
        'name', 'description', 'is_active', 'parent_id', 'sort',
        'url_rewrite', 'meta_title', 'meta_keywords', 'meta_description',
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
}