<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $owner = User::query()->firstOrCreate(
                ['email' => 'owner@demo.test'],
                [
                    'name' => 'Demo Store Owner',
                    'password' => 'demo123',
                ],
            );

            $store = $owner->stores()
                ->where('stores.name', 'Demo Store')
                ->first();

            if (! $store) {
                $store = Store::query()->create([
                    'name' => 'Demo Store',
                    'currency' => 'BRL',
                    'status' => 'active',
                ]);
            }

            $owner->stores()->syncWithoutDetaching([
                $store->id => [
                    'role' => 'owner',
                    'status' => 'active',
                ],
            ]);
        });
    }
}