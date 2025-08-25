<?php

namespace App\Services;

use App\Models\CarModel;

class CarModelService
{
    public function list()
    {
        return CarModel::with('brand')->get();
    }

    public function create(array $data): CarModel
    {
        return CarModel::create($data);
    }

    public function show(CarModel $carModel): CarModel
    {
        return $carModel->load('brand');
    }

    public function update(CarModel $carModel, array $data): CarModel
    {
        $carModel->update($data);

        return $carModel->load('brand');
    }

    public function delete(CarModel $carModel): bool
    {
        return $carModel->delete();
    }
}
