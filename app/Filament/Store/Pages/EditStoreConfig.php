<?php

namespace App\Filament\Store\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\EditTenantProfile;
use Filament\Schemas\Schema;

class EditStoreConfig extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Configurações da Loja';
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Nome da Loja')
                ->required()
                ->maxLength(255),

            Select::make('currency')
                ->options([
                    'BRL' => 'BRL',
                    'USD' => 'USD',
                    'EUR' => 'EUR',
                ])
                ->required(),
        ]);
    }
}