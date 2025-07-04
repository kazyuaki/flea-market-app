<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;


class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'user_id' => 1,
                'name' => '腕時計',
                'price' => 15000,
                'detail' => 'スタイリッシュなデザインのメンズ腕時計',
                'condition' => 1,
            ],
            [
                'user_id' => 1,
                'name' => 'HDD',
                'price' => 5000,
                'detail' => '高速で信頼性の高いハードディスク',
                'condition' => 2,
            ],
            [
                'user_id' => 1,
                'name' => '玉ねぎ3束',
                'price' => 300,
                'detail' => '新鮮な玉ねぎ3束のセット',
                'condition' => 3,
            ],
            [
                'user_id' => 1,
                'name' => '革靴',
                'price' => 4000,
                'detail' => 'クラシックなデザインの革靴',
                'condition' => 4,
            ],
            [
                'user_id' => 1,
                'name' => 'ノートPC',
                'price' => 45000,
                'detail' => '高性能なノートパソコン',
                'condition' => 1,
            ],
            [
                'user_id' => 1,
                'name' => 'マイク',
                'price' => 8000,
                'detail' => '高音質のレコーディング用マイク',
                'condition' => 2,
            ],
            [
                'user_id' => 1,
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'detail' => 'おしゃれなショルダーバッグ',
                'condition' => 3,
            ],
            [
                'user_id' => 1,
                'name' => 'タンブラー',
                'price' => 500,
                'detail' => '使いやすいタンブラー',
                'condition' => 4,
            ],
            [
                'user_id' => 1,
                'name' => 'コーヒーミル',
                'price' => 4000,
                'detail' => '手動のコーヒーミル',
                'condition' => 1,
            ],
            [
                'user_id' => 1,
                'name' => 'メイクセット',
                'price' => 2500,
                'detail' => '便利なメイクアップセット',
                'condition' => 2,
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
