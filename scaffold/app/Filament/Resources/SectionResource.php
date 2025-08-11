<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SectionResource\Pages;
use App\Models\Page;
use App\Models\Section;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class SectionResource extends Resource
{
    protected static ?string $model = Section::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('page_id')
                    ->label('Page')
                    ->options(fn () => Page::query()->pluck('title', 'id')->toArray())
                    ->searchable(),
                Forms\Components\TextInput::make('key')->maxLength(255),
                Forms\Components\TextInput::make('type')->required()->maxLength(255),
                Forms\Components\Textarea::make('content')
                    ->rows(10)
                    ->afterStateHydrated(function ($component, $state) {
                        $component->state(json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                    })
                    ->dehydrateStateUsing(function ($state) {
                        $decoded = json_decode($state, true);
                        return is_array($decoded) ? $decoded : [];
                    })
                    ->helperText('JSON payload for this section.'),
                Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('page.title')->label('Page')->sortable(),
                Tables\Columns\TextColumn::make('type')->sortable(),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->filters([])
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
            'index' => Pages\ListSections::route('/'),
            'create' => Pages\CreateSection::route('/create'),
            'edit' => Pages\EditSection::route('/{record}/edit'),
        ];
    }
}