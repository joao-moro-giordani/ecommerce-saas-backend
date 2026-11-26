<?php

namespace App\Filament\Store\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Dashboard;
use Filament\Pages\Tenancy\EditTenantProfile;
use Filament\Schemas\Schema;
use App\Models\Store;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;

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
                ->label('Moeda')
                ->options([
                    'BRL' => 'BRL',
                    'USD' => 'USD',
                    'EUR' => 'EUR',
                ])
                ->required(),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('backToDashboard')
                ->label('Voltar')
                ->icon(Heroicon::ArrowLeft)
                ->color('gray')
                ->url(fn (): string => Dashboard::getUrl(
                    panel: 'store',
                    tenant: $this->tenant,
                )),

            Action::make('toggleStoreStatus')
                ->label(fn (): string => $this->tenant->status === 'active'
                    ? 'Fechar loja'
                    : 'Reabrir loja')
                ->color(fn (): string => $this->tenant->status === 'active'
                    ? 'danger'
                    : 'success')
                ->requiresConfirmation()
                ->modalHeading(fn (): string => $this->tenant->status === 'active'
                    ? 'Fechar esta loja?'
                    : 'Reabrir esta loja?')
                ->modalDescription(fn (): string => $this->tenant->status === 'active'
                    ? 'A loja será marcada como fechada. Você poderá reabri-la depois.'
                    : 'A loja será marcada como ativa novamente.')
                ->action(function (): void {
                    abort_unless(
                        auth()->user()->stores()
                            ->whereKey($this->tenant->getKey())
                            ->wherePivot('status', 'active')
                            ->wherePivot('role', 'owner')
                            ->exists(),
                        403,
                    );

                    DB::transaction(function (): void {
                        $store = Store::query()
                            ->lockForUpdate()
                            ->findOrFail($this->tenant->getKey());

                        $store->status = $store->status === 'active'
                            ? 'closed'
                            : 'active';

                        $store->save();

                        $this->tenant = $store;
                    });

                    Notification::make()
                        ->success()
                        ->title($this->tenant->status === 'active'
                            ? 'Loja reaberta'
                            : 'Loja fechada')
                        ->send();
                }),
        ];
    }

    protected function getRedirectUrl(): ?string
    {
        return Dashboard::getUrl(
            panel: 'store',
            tenant: $this->tenant,
        );
    }
}
