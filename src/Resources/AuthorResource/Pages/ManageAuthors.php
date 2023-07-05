<?php

namespace Jeffgreco13\FilamentBlogger\Resources\AuthorResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Jeffgreco13\FilamentBlogger\Facades\FilamentBlogger;
use Jeffgreco13\FilamentBlogger\Resources\AuthorResource;

class ManageAuthors extends ManageRecords
{
    protected static string $resource = AuthorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->modalWidth(FilamentBlogger::getModalWidth()),
        ];
    }
}
