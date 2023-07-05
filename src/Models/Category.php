<?php

namespace Jeffgreco13\FilamentBlogger\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use RalphJSmit\Laravel\SEO\Support\HasSEO;

class Category extends Model
{
    //use HasSEO;
    /**
     * @var string
     */
    protected $table = 'blogger_categories';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
    ];

    /**
     * @var array<string, string>
     */
    // protected $casts = [
    //     //
    // ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class,'blogger_category_id');
    }
}
