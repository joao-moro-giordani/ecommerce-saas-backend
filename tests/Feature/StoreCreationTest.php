<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreCreationTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_a_store_can_be_created(): void
    {
        $store = \App\Models\Store::factory()->create();

        $this->assertDatabaseHas('stores', [
            'id' => $store->id,
            'name' => $store->name,
            'currency' => 'BRL',
            'status' => 'active',
        ]);
    }
}
