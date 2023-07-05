<?php

namespace Jeffgreco13\FilamentBlogger\Resources\PostResource\Pages;

use Jeffgreco13\FilamentBlogger\Resources\PostResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
