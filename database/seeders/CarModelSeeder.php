<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class CarModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = [
            'Toyota' => ['Camry', 'Corolla', 'RAV4'],
            'Honda' => ['Civic', 'Accord', 'CR-V'],
            'Ford' => ['Focus', 'Mustang', 'Explorer'],
            'BMW' => ['X5', 'X3', '3 Series'],
            'Mercedes' => ['C-Class', 'E-Class', 'GLE'],
        ];

        foreach ($models as $brandName => $modelNames) {
            $brand = Brand::where('name', $brandName)->first();

            foreach ($modelNames as $modelName) {
                CarModel::factory()->modelForBrand($modelName, $brand->id)->create();
            }
        }
    }
}
