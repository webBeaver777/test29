<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Services\CarService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Cars",
 *     description="Методы управления автомобилями"
 * )
 */
class CarController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private readonly CarService $carService) {}

    /**
     * @OA\Get(
     *     path="/api/cars",
     *     tags={"Cars"},
     *     summary="Список автомобилей пользователя",
     *     security={{"sanctum": {}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Список автомобилей",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *
     *                 @OA\Items(ref="#/components/schemas/CarModel")
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $cars = $this->carService->list(auth()->user());

        return response()->json(['data' => CarResource::collection($cars)]);
    }

    /**
     * @OA\Post(
     *     path="/api/cars",
     *     tags={"Cars"},
     *     summary="Создать автомобиль",
     *     security={{"sanctum": {}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"car_model_id", "brand_id", "year", "color", "mileage"},
     *
     *             @OA\Property(property="car_model_id", type="integer", example=1),
     *             @OA\Property(property="brand_id", type="integer", example=2),
     *             @OA\Property(property="year", type="integer", example=2020),
     *             @OA\Property(property="mileage", type="integer", example=15000),
     *             @OA\Property(property="color", type="string", example="red"),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Автомобиль создан",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="data", ref="#/components/schemas/CarModel")
     *         )
     *     )
     * )
     */
    public function store(CarRequest $request): JsonResponse
    {
        $car = $this->carService->create(auth()->user(), $request->validated());

        return response()->json(['data' => new CarResource($car)], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/cars/{car}",
     *     tags={"Cars"},
     *     summary="Показать автомобиль",
     *     security={{"sanctum": {}}},
     *
     *     @OA\Parameter(
     *         name="car",
     *         in="path",
     *         required=true,
     *         description="ID автомобиля",
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Данные автомобиля",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="data", ref="#/components/schemas/CarModel")
     *         )
     *     )
     * )
     * @throws AuthorizationException
     */
    public function show(Car $car): JsonResponse
    {
        $this->authorize('view', $car);

        return response()->json(['data' => new CarResource($this->carService->show($car))]);
    }

    /**
     * @OA\Patch(
     *     path="/api/cars/{car}",
     *     tags={"Cars"},
     *     summary="Обновить автомобиль",
     *     security={{"sanctum": {}}},
     *
     *     @OA\Parameter(
     *         name="car",
     *         in="path",
     *         required=true,
     *         description="ID автомобиля",
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"car_model_id", "brand_id", "year", "color", "mileage"},
     *
     *             @OA\Property(property="car_model_id", type="integer", example=1),
     *             @OA\Property(property="brand_id", type="integer", example=2),
     *             @OA\Property(property="year", type="integer", example=2020),
     *             @OA\Property(property="color", type="string", example="red"),
     *             @OA\Property(property="mileage", type="integer", example=15000)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Автомобиль обновлен",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="data", ref="#/components/schemas/CarModel")
     *         )
     *     )
     * )
     * @throws AuthorizationException
     */
    public function update(CarRequest $request, Car $car): JsonResponse
    {
        $this->authorize('update', $car);
        $car = $this->carService->update($car, $request->validated());

        return response()->json(['data' => new CarResource($car)]);
    }

    /**
     * @OA\Delete(
     *     path="/api/cars/{car}",
     *     tags={"Cars"},
     *     summary="Удалить автомобиль",
     *     security={{"sanctum": {}}},
     *
     *     @OA\Parameter(
     *         name="car",
     *         in="path",
     *         required=true,
     *         description="ID автомобиля",
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=204,
     *         description="Автомобиль удален"
     *     )
     * )
     * @throws AuthorizationException
     */
    public function destroy(Car $car): JsonResponse
    {
        $this->authorize('delete', $car);
        $this->carService->delete($car);

        return response()->json([], 204);
    }
}
