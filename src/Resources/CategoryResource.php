<?php

namespace Jeffgreco13\FilamentBlogger\Resources;

use Camya\Filament\Forms\Components\TitleWithSlugInput;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Jeffgreco13\FilamentBlogger\Facades\FilamentBlogger;
use Jeffgreco13\FilamentBlogger\Models\Category;
use Jeffgreco13\FilamentBlogger\Resources\CategoryResource\Pages;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $navigationGroup = 'Blog';
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?int $navigationSort = 1;
    public static function getSlug(): string
    {
        return FilamentBlogger::getSlugPath() . '/categories';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TitleWithSlugInput::make(
                    fieldTitle: 'name',
                    fieldSlug: 'slug',
                    urlPath: "/".static::getSlug()."/",
                    urlVisitLinkVisible: false,
                    titleRules: [
                        'required',
                        'string',
                        'min:3',
                    ],
                ),
                Forms\Components\RichEditor::make('description'),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->description(fn($record)=>str($record->description)->limit(50))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->date(),
                Tables\Columns\BadgeColumn::make('posts_count')
                    ->label('Posts')
                    ->counts('posts')
                    ->color(static function($state): string {
                        return match(true){
                            $state >= 0 => 'success',
                            default => 'secondary'
                        };
                    })
                    ->url(fn($record) => PostResource::getUrl('index',[
                        'tableFilters'=> [
                            'category'=> [
                                'values' => [$record->id]
                            ]
                        ]
                    ])),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth(FilamentBlogger::getModalWidth()),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCategories::route('/'),
        ];
    }
}
