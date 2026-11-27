<?php

namespace App\Filament\Store\Resources\Categories\Pages;

use App\Filament\Store\Resources\Categories\CategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    public function getTitle(): string
    {
        return 'Categorias';
    }

    public function getBreadcrumb(): ?string
    {
        return 'Categorias';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Nova categoria'),
        ];
    }
}
