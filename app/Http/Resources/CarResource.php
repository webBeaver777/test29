<?php

namespace App\Http\Resources;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Car
 */
class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'brand' => $this->carModel->brand->name ?? null,
            'model' => $this->carModel->name ?? null,
            'year' => $this->year,
            'mileage' => $this->mileage,
            'color' => $this->color,
        ];
    }
}
