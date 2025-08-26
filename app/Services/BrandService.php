<?php

namespace App\Services;

use App\Models\Brand;

class BrandService
{
    public function list()
    {
        return Brand::all();
    }

    public function create(array $data): Brand
    {
        return Brand::create($data);
    }

    public function show(Brand $brand): Brand
    {
        return $brand;
    }

    public function update(Brand $brand, array $data): Brand
    {
        $brand->update($data);

        return $brand;
    }

    public function delete(Brand $brand): bool
    {
        return $brand->delete();
    }
}
