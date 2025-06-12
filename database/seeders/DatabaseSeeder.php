<?php

namespace Database\Seeders;

use Database\Seeders\Product\ProductSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
