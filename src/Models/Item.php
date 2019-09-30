<?php

namespace Viviniko\Content\Models;

use Illuminate\Support\Facades\Config;
use Viviniko\Support\Database\Eloquent\Model;
use Viviniko\Urlrewrite\UrlrewriteTrait;

class Item extends Model
{
    use UrlrewriteTrait;

    protected $tableConfigKey = 'content.items_table';

    protected $fillable = [
        'category_id', 'title', 'description', 'position', 'image', 'url_rewrite', 'is_active'
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
