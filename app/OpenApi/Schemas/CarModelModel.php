<?php

namespace App\OpenApi\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="CarModelModel",
 *     type="object",
 *     title="Car Model",
 *
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="brand_id", type="integer", example=10),
 *     @OA\Property(property="name", type="string", example="Vesta"),
 * )
 */
class CarModelModel {}
