<?php

namespace Viviniko\Content\Models;

use Illuminate\Support\Facades\Config;
use Viviniko\Support\Database\Eloquent\Model;
use Viviniko\Urlrewrite\UrlrewriteTrait;

class Post extends Model
{
    use UrlrewriteTrait;

    protected $tableConfigKey = 'content.posts_table';

    protected $fillable = [
        'category_id', 'title', 'description', 'position',
        'url_rewrite', 'meta_title', 'meta_keywords', 'meta_description', 'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Config::get('content.category'), 'category_id');
    }

    public function data()
    {
        return $this->hasOne(Config::get('content.data'), 'id');
    }
}
