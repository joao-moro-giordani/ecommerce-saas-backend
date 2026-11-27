<?php

namespace App\Filament\Store\Resources\Products\Pages;

use App\Filament\Store\Resources\Products\ProductResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    public function getTitle(): string
    {
        return 'Produtos';
    }

    public function getBreadcrumb(): ?string
    {
        return 'Produtos';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Novo produto'),
        ];
    }
}
