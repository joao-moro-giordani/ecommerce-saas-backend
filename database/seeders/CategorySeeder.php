<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Seed example categories for the demo store.
     */
    public function run(): void
    {
        $store = Store::query()
            ->where('name', 'Demo Store')
            ->firstOrFail();

        DB::transaction(function () use ($store): void {
            $categories = [
                'Roupas' => ['Camisetas', 'Calças', 'Vestidos'],
                'Calçados' => ['Tênis', 'Sandálias', 'Botas'],
                'Acessórios' => ['Bolsas', 'Cintos', 'Bonés'],
                'Casa e decoração' => ['Decoração', 'Cozinha'],
                'Beleza' => ['Cuidados com a pele', 'Maquiagem'],
            ];

            foreach ($categories as $parentName => $childNames) {
                $parent = $this->firstOrRestoreCategory(
                    storeId: $store->id,
                    parentId: null,
                    name: $parentName,
                );

                foreach ($childNames as $childName) {
                    $this->firstOrRestoreCategory(
                        storeId: $store->id,
                        parentId: $parent->id,
                        name: $childName,
                    );
                }
            }
        });
    }

    private function firstOrRestoreCategory(int $storeId, ?int $parentId, string $name): Category
    {
        $category = Category::withTrashed()->firstOrNew([
            'store_id' => $storeId,
            'parent_id' => $parentId,
            'name' => $name,
        ]);

        if ($category->trashed()) {
            $category->restore();
        }

        $category->description ??= 'Categoria de exemplo para a loja de demonstração.';
        $category->status = 'active';
        $category->save();

        return $category;
    }
}
