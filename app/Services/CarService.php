<?php

namespace App\Services;

use App\Models\Car;
use App\Models\User;

class CarService
{
    public function list($user)
    {
        return $user->cars()->with(['carModel.brand'])->get();
    }

    public function create(User $user, array $data): Car
    {
        $data['user_id'] = $user->id;

        return Car::create($data);
    }

    public function show(Car $car): Car
    {
        return $car->load(['carModel.brand']);
    }

    public function update(Car $car, array $data): Car
    {
        $car->update($data);

        return $car->load(['carModel.brand']);
    }

    public function delete(Car $car): bool
    {
        return $car->delete();
    }
}
