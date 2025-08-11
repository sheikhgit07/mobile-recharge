<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuItemResource\Pages;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class MenuItemResource extends Resource
{
    protected static ?string $model = MenuItem::class;
    protected static ?string $navigationIcon = 'heroicon-o-link';
    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('menu_id')
                    ->label('Menu')
                    ->options(fn () => Menu::query()->pluck('name', 'id')->toArray())
                    ->required()
                    ->searchable(),
                Forms\Components\Select::make('parent_id')
                    ->label('Parent Item')
                    ->options(fn () => MenuItem::query()->pluck('label', 'id')->toArray())
                    ->searchable(),
                Forms\Components\TextInput::make('label')->required(),
                Forms\Components\TextInput::make('url')->placeholder('https:// or /slug'),
                Forms\Components\Select::make('page_id')
                    ->label('Linked Page')
                    ->options(fn () => Page::query()->pluck('title', 'id')->toArray())
                    ->searchable(),
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('menu.name')->label('Menu')->sortable(),
                Tables\Columns\TextColumn::make('label')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('url')->toggleable(),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit' => Pages\EditMenuItem::route('/{record}/edit'),
        ];
    }
}