<?php

namespace Jeffgreco13\FilamentBlogger\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Jeffgreco13\FilamentBlogger\Models\Author;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Awcodes\Curator\Components\Tables\CuratorColumn;
use Jeffgreco13\FilamentBlogger\Facades\FilamentBlogger;
use Jeffgreco13\FilamentBlogger\Resources\AuthorResource\Pages;

class AuthorResource extends Resource
{
    protected static ?string $model = Author::class;
    protected static ?string $navigationGroup = 'Blog';
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?int $navigationSort = 2;
    public static function getSlug(): string
    {
        return FilamentBlogger::getSlugPath() . '/authors';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make([
                    Forms\Components\TextInput::make('name')
                        ->required(),
                    Forms\Components\TextInput::make('email')
                        ->required()
                        ->email()
                        ->unique(Author::class, 'email', fn ($record) => $record),
                ])->columnSpan(['default'=>1,'sm'=>2]),
                CuratorPicker::make('photo_id')
                    ->label('Profile photo')
                    ->relationship('photo','id'),
                Forms\Components\RichEditor::make('bio')->columnSpanFull(),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                CuratorColumn::make('photo')->size(40),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->date()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->modalWidth(FilamentBlogger::getModalWidth()),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAuthors::route('/'),
        ];
    }
}
