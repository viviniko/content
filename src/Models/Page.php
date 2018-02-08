<?php

namespace Viviniko\Content\Models;

use Illuminate\Support\Facades\Config;
use Viviniko\Support\Database\Eloquent\Model;
use Viviniko\Urlrewrite\UrlrewriteTrait;

class Page extends Model
{
    use UrlrewriteTrait;

    protected $tableConfigKey = 'content.pages_table';

    protected $fillable = ['title', 'type', 'content', 'category_id', 'url_rewrite', 'meta_title', 'meta_keywords', 'meta_description', 'is_active'];

    public function category()
    {
        return $this->belongsTo(Config::get('content.category'), 'category_id');
    }

    public function getUrlAttribute()
    {
        return url($this->url_rewrite);
    }
}
