<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = ['Toyota', 'Honda', 'Ford', 'BMW', 'Mercedes'];

        foreach ($brands as $name) {
            Brand::factory()->brand($name)->create();
        }
    }
}
