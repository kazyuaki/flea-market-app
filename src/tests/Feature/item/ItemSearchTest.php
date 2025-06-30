<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testProductSearchByPartialName()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create(['id' => 1]);

        Item::factory()->create([
            'name' => 'RedShoes',
            'user_id' => $user->id
        ]);

        Item::factory()->create([
            'name' => 'RedShoes',
            'user_id' => $user->id
        ]);

        Item::factory()->create([
            'name' => 'BlueHat',
            'user_id' => $user->id
        ]);

        $response = $this->get('/?keyword=Red');

        $response->assertSee('RedShoes');
        $response->assertDontSee('BlueHat');
    }
}
