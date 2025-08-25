<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Services\BrandService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Brands",
 *     description="Методы управления брендами автомобилей"
 * )
 */
class BrandController extends Controller
{
    public function __construct(private readonly BrandService $brandService) {}

    /**
     * @OA\Get(
     *     path="/api/brands",
     *     tags={"Brands"},
     *     summary="Список брендов",
     *     security={{"sanctum": {}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Список брендов",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *
     *                 @OA\Items(ref="#/components/schemas/BrandModel")
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $brands = $this->brandService->list();

        return response()->json(['data' => BrandResource::collection($brands)]);
    }

    /**
     * @OA\Post(
     *     path="/api/brands",
     *     tags={"Brands"},
     *     summary="Создать бренд",
     *     security={{"sanctum": {}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"name"},
     *
     *             @OA\Property(property="name", type="string", example="Toyota")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Бренд создан",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="data", ref="#/components/schemas/BrandModel")
     *         )
     *     )
     * )
     */
    public function store(BrandRequest $request): JsonResponse
    {
        $brand = $this->brandService->create($request->validated());

        return response()->json(['data' => new BrandResource($brand)], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/brands/{brand}",
     *     tags={"Brands"},
     *     summary="Показать бренд",
     *     security={{"sanctum": {}}},
     *
     *     @OA\Parameter(
     *         name="brand",
     *         in="path",
     *         required=true,
     *         description="ID бренда",
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Данные бренда",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="data", ref="#/components/schemas/BrandModel")
     *         )
     *     )
     * )
     */
    public function show(Brand $brand): JsonResponse
    {
        return response()->json(['data' => new BrandResource($this->brandService->show($brand))]);
    }

    /**
     * @OA\Patch(
     *     path="/api/brands/{brand}",
     *     tags={"Brands"},
     *     summary="Обновить бренд",
     *     security={{"sanctum": {}}},
     *
     *     @OA\Parameter(
     *         name="brand",
     *         in="path",
     *         required=true,
     *         description="ID бренда",
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"name"},
     *
     *             @OA\Property(property="name", type="string", example="Toyota")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Бренд обновлен",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="data", ref="#/components/schemas/BrandModel")
     *         )
     *     )
     * )
     *
     *     @OA\Response(
     *         response=200,
     *         description="Бренд обновлен",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="data", ref="#/components/schemas/BrandModel")
     *         )
     *     )
     * )
     */
    public function update(BrandRequest $request, Brand $brand): JsonResponse
    {
        $brand = $this->brandService->update($brand, $request->validated());

        return response()->json(['data' => new BrandResource($brand)]);
    }

    /**
     * @OA\Delete(
     *     path="/api/brands/{brand}",
     *     tags={"Brands"},
     *     summary="Удалить бренд",
     *     security={{"sanctum": {}}},
     *
     *     @OA\Parameter(
     *         name="brand",
     *         in="path",
     *         required=true,
     *         description="ID бренда",
     *
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response=204,
     *         description="Бренд удален"
     *     )
     * )
     */
    public function destroy(Brand $brand): JsonResponse
    {
        $this->brandService->delete($brand);

        return response()->json([], 204);
    }
}
