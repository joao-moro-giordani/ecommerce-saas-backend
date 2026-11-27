<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_factory_creates_a_category_for_a_store(): void
    {
        $store = Store::factory()->create();

        $category = Category::factory()->create([
            'store_id' => $store->id,
        ]);

        $this->assertInstanceOf(Category::class, $category);
        $this->assertSame($store->id, $category->store_id);
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'store_id' => $store->id,
            'name' => $category->name,
        ]);
    }
}