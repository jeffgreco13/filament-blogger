<?php

namespace Jeffgreco13\FilamentBlogger\Resources\PostResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Jeffgreco13\FilamentBlogger\Resources\PostResource;
use Jeffgreco13\FilamentBlogger\Facades\FilamentBlogger;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getActions(): array
    {
        return [
            Actions\Action::make('newDraft')
                ->icon('heroicon-s-pencil-alt')
                ->color('primary')
                ->modalWidth(FilamentBlogger::getModalWidth())
                ->form([
                    FilamentBlogger::getTitleWithSlugInput()
                ])
                ->action(function($data,$livewire){
                    $post = $livewire->getModel()::create([
                        'title' => $data['title'],
                        'slug' => $data['slug'],
                    ]);
                    return redirect()->to($livewire->getResource()::getUrl('edit',['record'=>$post]));
                })
        ];
    }
}
