<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ['pivot'];
    public $timestamps = false;

        
    /**
     * Отношения по типу Many-To-Many; Возврщает всех тегов статьи;
     */
    public function tags() 
    {
        return $this->belongsToMany(Tag::class, 'tags_articles', 'article_id', 'tag_id');
    }
}
