<?php

namespace Jeffgreco13\FilamentBlogger\Data;

enum PostStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case PRIVATE = 'private';

    public function label(): string
    {
        return static::getLabel($this);
    }
    public static function getLabel(self $value): string
    {
        return ucfirst($value->value);
        // return match ($value) {
        //     // PostStatus::DRAFT => 'Draft',
        // };
    }

    // public function description(): string
    // {
    //     return static::getDescription($this);
    // }

    // public static function getDescription(self $value): string
    // {
    //     return match ($value) {
    //         //
    //     };
    // }

    public static function getArray(): array
    {
        return collect(self::cases())->mapWithKeys(function ($item) {
            return [$item->value => self::getLabel($item)];
        })->toArray();
    }
}
