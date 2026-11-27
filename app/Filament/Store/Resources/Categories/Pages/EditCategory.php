<?php

namespace App\Filament\Store\Resources\Categories\Pages;

use App\Filament\Store\Resources\Categories\CategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    public function getTitle(): string
    {
        return 'Editar categoria';
    }

    public function getBreadcrumb(): string
    {
        return 'Editar';
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Excluir')
                ->modalHeading('Excluir categoria')
                ->modalDescription('Tem certeza de que deseja excluir esta categoria? Ela poderá ser restaurada depois.')
                ->modalSubmitActionLabel('Sim, excluir'),
            ForceDeleteAction::make()
                ->label('Excluir permanentemente')
                ->modalHeading('Excluir categoria permanentemente')
                ->modalDescription('Esta ação é permanente e não poderá ser desfeita.')
                ->modalSubmitActionLabel('Sim, excluir permanentemente'),
            RestoreAction::make()
                ->label('Restaurar')
                ->modalHeading('Restaurar categoria')
                ->modalSubmitActionLabel('Sim, restaurar'),
        ];
    }
}
