<?php

namespace App\Filament\Store\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informações da categoria')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label('Nome')
                        ->required()
                        ->maxLength(255),

                    Select::make('parent_id')
                        ->label('Categoria principal')
                        ->options(fn (): array => Category::query()
                            ->where('store_id', Filament::getTenant()->getKey())
                            ->whereNull('parent_id')
                            ->orderBy('name')
                            ->pluck('name', 'id')
                            ->all())
                        ->searchable()
                        ->nullable(),

                    Textarea::make('description')
                        ->label('Descrição')
                        ->rows(4)
                        ->columnSpanFull(),

                    Toggle::make('status')
                        ->label('Categoria ativa')
                        ->default(true)
                        ->formatStateUsing(fn ($state): bool => $state === true || $state === 'active')
                        ->dehydrateStateUsing(
                            fn (bool $state): string => $state ? 'active' : 'inactive'
                        ),
                ]),
        ]);
    }
}