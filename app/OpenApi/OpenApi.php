<?php

namespace App\OpenApi;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="API для управления автомобилями",
 *     version="1.0.0",
 *     description="Документация API"
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000/",
 *     description="Local server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class OpenApi {}
