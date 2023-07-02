<?php

namespace Jeffgreco13\FilamentBlogger\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jeffgreco13\FilamentBlogger\FilamentBlogger
 */
class FilamentBlogger extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Jeffgreco13\FilamentBlogger\FilamentBlogger::class;
    }
}
