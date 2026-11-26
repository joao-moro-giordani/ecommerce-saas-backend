<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreUserRelationshipTest extends TestCase
{
    use RefreshDatabase;
   
    public function test_store_user_relationship(): void
    {
        
        $user = \App\Models\User::factory()->create();
        $store = \App\Models\Store::factory()->create();

        $user->stores()->attach($store->id, [
            'role' => 'owner',
            'status' => 'active',
        ]);

        $this->assertTrue($user->stores()->whereKey($store->id)->exists());
        $this->assertTrue($store->users()->whereKey($user->id)->exists());

        $linkedStore = $user->stores()->findOrFail($store->id);

        $this->assertSame('owner', $linkedStore->pivot->role);
        $this->assertSame('active', $linkedStore->pivot->status);
    }
}
