<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarModelRequest;
use App\Http\Resources\CarModelResource;
use App\Models\CarModel;
use App\Services\CarModelService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Car Models",
 *     description="Методы управления моделями автомобилей"
 * )
 */
class CarModelController extends Controller
{
    public function __construct(private readonly CarModelService $carModelService) {}

    /**
     * @OA\Get(
     *     path="/api/car-models",
     *     tags={"Car Models"},
     *     summary="Список моделей автомобилей",
     *     security={{"sanctum": {}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Список моделей",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *
     *                 @OA\Items(ref="#/components/schemas/CarModelModel")
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $models = $this->carModelService->list();

        return response()->json(['data' => CarModelResource::collection($models)]);
    }

    /**
     * @OA\Post(
     *     path="/api/car-models",
     *     tags={"Car Models"},
     *     summary="Создать модель автомобиля",
     *     security={{"sanctum": {}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"name","brand_id"},
     *
     *             @OA\Property(property="name", type="string", example="Camry"),
     *             @OA\Property(property="brand_id", type="integer", example=1)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Модель создана",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="data", ref="#/components/schemas/CarModelModel")
     *         )
     *     )
     * )
     */
    public function store(CarModelRequest $request): JsonResponse
    {
        $model = $this->carModelService->create($request->validated());

        return response()->json(['data' => new CarModelResource($model)], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/car-models/{id}",
     *     tags={"Car Models"},
     *     summary="Показать модель автомобиля",
     *     security={{"sanctum": {}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID модели",
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Данные модели",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="data", ref="#/components/schemas/CarModelModel")
     *         )
     *     )
     * )
     */
    public function show(CarModel $carModel): JsonResponse
    {
        return response()->json(['data' => new CarModelResource($this->carModelService->show($carModel))]);
    }

    /**
     * @OA\Patch(
     *     path="/api/car-models/{id}",
     *     tags={"Car Models"},
     *     summary="Обновить модель автомобиля",
     *     security={{"sanctum": {}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID модели",
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"name","brand_id"},
     *
     *             @OA\Property(property="name", type="string", example="Camry"),
     *             @OA\Property(property="brand_id", type="integer", example=1)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Модель обновлена",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="data", ref="#/components/schemas/CarModelModel")
     *         )
     *     )
     * )
     */
    public function update(CarModelRequest $request, CarModel $carModel): JsonResponse
    {
        $model = $this->carModelService->update($carModel, $request->validated());

        return response()->json(['data' => new CarModelResource($model)]);
    }

    /**
     * @OA\Delete(
     *     path="/api/car-models/{id}",
     *     tags={"Car Models"},
     *     summary="Удалить модель автомобиля",
     *     security={{"sanctum": {}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID модели",
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=204,
     *         description="Модель удалена"
     *     )
     * )
     */
    public function destroy(CarModel $carModel): JsonResponse
    {
        $this->carModelService->delete($carModel);

        return response()->json([], 204);
    }
}
