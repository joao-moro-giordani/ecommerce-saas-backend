<?php

namespace App\Filament\Store\Resources\Categories\Pages;

use App\Filament\Store\Resources\Categories\CategoryResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    public function getTitle(): string
    {
        return 'Criar categoria';
    }

    public function getBreadcrumb(): string
    {
        return 'Criar';
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()->label('Criar categoria');
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
