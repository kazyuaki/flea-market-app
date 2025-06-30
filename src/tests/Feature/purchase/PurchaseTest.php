<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCanPurchaseItemAndSeeItInHistory()
    {
        /** @var \App\Models\User $user */

        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        // Stripe呼び出しをモック
        \Stripe\Checkout\Session::shouldReceive('create')
            ->once()
            ->andReturn((object)['url' => 'https://example.com']);

        // act: checkoutにPOST
        $this->post("/purchase/checkout/{$item->id}", [
            'payment_method' => 'カード払い',
        ])->assertRedirect();

        // 本物のcompleteをシミュレート
        $this->get("/purchase/complete/{$item->id}?method=2");

        // assert: 購入記録
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // assert: 一覧画面
        $response = $this->get('/');
        $response->assertSee('SOLD');

        // assert: マイページ
        $response = $this->get('/mypage?tab=buy');
        $response->assertSee($item->name);
    }
}
