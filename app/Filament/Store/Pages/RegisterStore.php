<?php

namespace App\Filament\Store\Pages;

use App\Models\Store;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;

class RegisterStore extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Create store';
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

    protected function handleRegistration(array $data): Store
    {
        return DB::transaction(function () use ($data): Store {
            $store = Store::query()->create([
                'name' => $data['name'],
                'currency' => $data['currency'],
                'status' => 'active',
            ]);

            $store->users()->attach(auth()->user(), [
                'role' => 'owner',
                'status' => 'active',
            ]);

            return $store;
        });
    }
}