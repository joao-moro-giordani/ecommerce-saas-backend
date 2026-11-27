<?php

namespace App\Filament\Store\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('parent.name')
                    ->label('Categoria principal')
                    ->placeholder('Categoria principal')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Ativa',
                        'inactive' => 'Inativa',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Criada em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make()->label('Categorias excluídas'),
            ])
            ->recordActions([
                EditAction::make()->label('Editar'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Excluir selecionadas')
                        ->modalHeading('Excluir categorias selecionadas')
                        ->modalSubmitActionLabel('Sim, excluir'),
                    ForceDeleteBulkAction::make()
                        ->label('Excluir permanentemente')
                        ->modalHeading('Excluir categorias permanentemente')
                        ->modalDescription('Esta ação é permanente e não poderá ser desfeita.')
                        ->modalSubmitActionLabel('Sim, excluir permanentemente'),
                    RestoreBulkAction::make()
                        ->label('Restaurar selecionadas')
                        ->modalHeading('Restaurar categorias selecionadas')
                        ->modalSubmitActionLabel('Sim, restaurar'),
                ]),
            ]);
    }
}
