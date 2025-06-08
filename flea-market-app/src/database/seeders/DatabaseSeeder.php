<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,          // 先に users
            CategoriesTableSeeder::class, // 次に categories
            ItemsTableSeeder::class,      // 最後に items
        ]);
    }
}
