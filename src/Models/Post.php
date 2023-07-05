<?php

namespace Jeffgreco13\FilamentBlogger\Models;

use Spatie\Tags\HasTags;
use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Jeffgreco13\FilamentBlogger\Data\PostStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasTags, HasSEO;

    /**
     * @var string
     */
    protected $table = 'blogger_posts';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'status',
        'excerpt',
        'content',
        'published_at',
        'featured_image_id'
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'date',
        'status' => PostStatus::class
    ];

    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            $post->status = is_null($post->status) ? PostStatus::DRAFT : $post->status;
            $post->published_at = is_null($post->published_at) && $post->status == PostStatus::DRAFT ? now() : $post->published_at;
        });
    }

    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->title,
            description: $this->excerpt,
            author: $this->author->name,
            published_time: $this->published_at,
            image: $this->featuredImage->url
        );
    }

    public function wordCount(): Attribute
    {
        return Attribute::get(fn () => str(strip_tags($this->content))->wordCount());
    }
    public function readTime(): Attribute
    {
        return Attribute::get(function(){
            $count = $this->word_count / 200;
            $minutesPart = floor($count);
            $secondsPart = round(($count - $minutesPart) * 0.6 * 100);
            $minutes = strlen($minutesPart) < 2 ? str($minutesPart)->prepend('0') : $minutesPart;
            $seconds = strlen($secondsPart) < 2 ? str($secondsPart)->prepend('0') : $secondsPart;
            return "{$minutes}:{$seconds}";
        });
    }

    public function scopePublished(Builder $query)
    {
        return $query->whereStatus(PostStatus::PUBLISHED)->whereDate('published_at','>=',now()->startOfDay());
    }

    // public function scopeDraft(Builder $query)
    // {
    //     return $query->whereNull('published_at');
    // }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class, 'blogger_author_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'blogger_category_id');
    }

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(Media::class,'featured_image_id');
    }
}
