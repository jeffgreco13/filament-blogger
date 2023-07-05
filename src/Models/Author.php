<?php

namespace Jeffgreco13\FilamentBlogger\Models;

use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Author extends Model
{
    //use HasSEO;
    /**
     * @var string
     */
    protected $table = 'blogger_authors';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'photo_id',
        'bio',
        'links',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'links' => 'json',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class,'blogger_post_id');
    }
    public function photo(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'photo_id');
    }
}
