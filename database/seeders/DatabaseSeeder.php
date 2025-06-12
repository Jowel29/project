<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\Product\ProductSeeder;
class DatabaseSeeder extends Seeder
{
   public function run(): void
    {
        DB::transaction(function () {
            $this->call([
                ProductSeeder::class,
            ]);
        });
    }
}