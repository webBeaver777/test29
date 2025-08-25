<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="CarModel",
 *     type="object",
 *     title="Car",
 *
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="brand_id", type="integer", example=10),
 *     @OA\Property(property="user_id", type="integer", example=10),
 *     @OA\Property(property="year", type="integer", example=2025),
 *     @OA\Property(property="mileage", type="integer", example=20000),
 *     @OA\Property(property="color", type="string", example="black")
 * )
 */
class CarModel {}
