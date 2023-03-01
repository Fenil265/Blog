<?php

namespace Database\Seeders;

use App\Models\Blogs;
use App\Models\Categories;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Categories::truncate();
        Schema::enableForeignKeyConstraints();

        Categories::factory(5)->create();
        Blogs::factory(5)->create();
    }
}
