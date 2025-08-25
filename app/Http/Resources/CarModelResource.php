<?php

namespace App\Http\Resources;

use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CarModel
 */
class CarModelResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'brand' => $this->brand->name ?? null,
            'name' => $this->name,
        ];
    }
}
