<?php

namespace Jeffgreco13\FilamentBlogger\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use RalphJSmit\Filament\SEO\SEO;
use Jeffgreco13\FilamentBlogger\Models\Post;
use Jeffgreco13\FilamentBlogger\Data\PostStatus;
use Jeffgreco13\FilamentBlogger\Facades\FilamentBlogger;
use Jeffgreco13\FilamentBlogger\Resources\PostResource\Pages;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationGroup = 'Blog';
    protected static ?string $recordTitleAttribute = 'title';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 0;
    public static function getSlug(): string
    {
        return FilamentBlogger::getSlugPath() . '/posts';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make([
                    Forms\Components\Card::make([
                        FilamentBlogger::getTitleWithSlugInput(),
                        Forms\Components\Textarea::make('excerpt')
                            ->rows(2)
                            ->minLength(50)
                            ->maxLength(1000),
                        FilamentBlogger::getTiptapInput(),
                    ]),

                ])->columns(1)->columnSpan(['default'=>1,'sm'=>2]),
                Forms\Components\Group::make([
                    Forms\Components\Card::make([
                        Forms\Components\Select::make('status')
                            ->options(PostStatus::getArray())
                            ->default(PostStatus::DRAFT->value)
                            ->reactive()
                            ->required(),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Publish date')
                            ->required()
                            ->visible(fn($get)=>$get('status') != PostStatus::DRAFT->value),
                        Forms\Components\Select::make('blogger_author_id')
                            ->required()
                            ->relationship('author','name')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')->required()
                                    ->default(auth()->user()->name),
                                Forms\Components\TextInput::make('email')
                                    ->required()
                                    ->email()
                                    ->default(auth()->user()->email),
                            ])
                            ->createOptionAction(fn($action) => $action->modalWidth('sm')),
                        Forms\Components\Select::make('blogger_category_id')
                            ->placeholder('Uncategorized')
                            ->relationship('category', 'name')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->reactive()
                                    ->afterStateUpdated(fn($set,$state)=>$set('slug',str($state)->slug()))
                                    ->required(),
                                Forms\Components\TextInput::make('slug')
                                    ->required(),
                            ])
                            ->createOptionAction(fn ($action) => $action->modalWidth('sm')),
                        FilamentBlogger::getTagsInput()
                    ]),
                    Forms\Components\Card::make([
                        FilamentBlogger::getCuratorFeaturedImageInput()
                    ]),
                    Forms\Components\Section::make('SEO')
                        ->collapsible()
                        // ->description('')
                        ->schema([
                            SEO::make()
                        ]),
                    // Forms\Components\Card::make([
                    //     Forms\Components\Placeholder::make('created_at')
                    //         ->content(fn (
                    //             ?Post $record
                    //         ): string => $record ? $record->created_at->diffForHumans() : '-'),
                    //     Forms\Components\Placeholder::make('updated_at')
                    //         ->content(fn (
                    //             ?Post $record
                    //         ): string => $record ? $record->updated_at->diffForHumans() : '-'),
                    // ])
                ])->columnSpan(1)

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Post title')
                    ->description(function($record){
                        return "Created " . $record->created_at->format('M j, Y');
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('author.name'),
                Tables\Columns\BadgeColumn::make('status')
                    ->enum(PostStatus::getArray()),
                Tables\Columns\BadgeColumn::make('category.name'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->multiple()
                    ->relationship('category','name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            // 'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
