<?php

namespace Jeffgreco13\FilamentBlogger\Resources\CategoryResource\Pages;

use Closure;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Jeffgreco13\FilamentBlogger\Facades\FilamentBlogger;
use Jeffgreco13\FilamentBlogger\Resources\CategoryResource;

class ManageCategories extends ManageRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getTableRecordActionUsing(): ?Closure
    {
        return null;
    }
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->modalWidth(FilamentBlogger::getModalWidth()),
        ];
    }
}
