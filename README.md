# Filament Blogger

A blogging package that includes the best community Filament packages.

## Installation

You can install the package via composer:

```bash
composer require jeffgreco13/filament-blogger
```

Run the install script BEFORE migrations:

```bash
php artisan blogger:install
```

<!-- You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-blogger-config"
``` -->

<!-- This is the contents of the published config file:

```php
return [
];
``` -->

<!-- Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-blogger-views"
``` -->

## Usage

### Configure Filament Tiptap/Curator Integration

You can configure Tiptap to use the Curator media picker and choose media from your library to embed in the body of your post. To do this, you will need to publish the Tiptap config and update the Actions section:

```php
// 'media_action' => FilamentTiptapEditor\Actions\MediaAction::class,
    'media_action' => Awcodes\Curator\Actions\MediaAction::class,
    'link_action' => FilamentTiptapEditor\Actions\LinkAction::class,
```

### Routing

This package does not configure any routes for your frontend, to allow for full customization. Here are some route examples:
```php
use Jeffgreco13\FilamentBlogger\Models\Post;
use Jeffgreco13\FilamentBlogger\Models\Category;
use Jeffgreco13\FilamentBlogger\Models\Author;

Route::get("/blog",function(){
    return view('blog-index',['posts'=>Post::all()]);
})->name('blog.index')

Route::get("/blog/{post:slug}",function(Post $post){
    return view("blog-article",['post'=>$post]);
})->name('blog.article');

Route::get("/blog/category/{category:slug}",function(Category $category){
    return view('blog-index',[
        'posts'=>$category->posts
    ]);
})->name('blog.category');

Route::get("/blog/author/{author:slug}",function(Author $author){
    return view('blog-index',[
        'posts' => $author->posts
    ]);
})->name('blog.author');

Route::get("/blog/tag/{tag}",function(string $tag){
    return view('blog-index',[
        'posts' => Post::withAllTags([$tag],'blog')
    ]);
})->name('blog.tag');
```

### Frontend
You will need to style your own frontend to display your posts and content. Review the following available attributes by model. You can, of course, refer to the Spatie Tags docs to learn how to use tags as well.

```php
$post->title
$post->slug
$post->category?->title ?? 'Uncategorized'
$post->excerpt
$post->content // Tiptap generated content
$post->status // PostStatus enum cast
$post->published_at->format('M j, Y')
$post->read_time // mm:ss, ex. 13:46 = 13 minutes and 46 seconds
$post->featuredImage // Curator Media::class relationship

$category->name
$category->slug
$category->description // RichEditor HTML content
$category->posts // Post::class relationship

$author->name
$author->email
$author->bio // RichEditor HTML content
$author->links // json
$author->posts // Post::class relationship
$author->photo // Curator Media::class relationship
```

To properly display your Tiptap content, you can use the following converter utility. For more information about the Filament Tiptap Editor and other available converter utilities, review the package docs below.
```
{!! tiptap_converter()->asHTML($post->content) !!}
```
To use SEO, you will need to add the following snippet to your website's head or layout file. The `$model` object can be any class with the `HasSEO` trait. Laravel SEO does a fantastic job generating meta data for any content/pages that do not have data. Learn more about how Laravel SEO works in their docs.

```php
@props([
    'model' => null,
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {!! seo()->for($model) !!}

</head>
```

### Integrating With Spatie Tags



```
php artisan make:filament-resource TagsResource --simple --generate
```

### Package Documentation
Blogger aggregates and pre-configures the following packages. See their respective repos for additional configuration options:
- [Filament Tiptap Editor by Awcodes](https://github.com/awcodes/filament-tiptap-editor)
- [Filament Curator by Awcodes](https://github.com/awcodes/filament-curator)
- [Filament Title with slug by Camya](https://github.com/camya/filament-title-with-slug)
- [Laravel SEO by Ralphjsmit](https://github.com/ralphjsmit/laravel-seo)
- [Spatie Tags](https://spatie.be/docs/laravel-tags/v4/introduction)
- [Filament Spatie Tags Input](https://filamentphp.com/docs/2.x/spatie-laravel-tags-plugin/form-components)

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jeff Greco](https://github.com/jeffgreco13)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
