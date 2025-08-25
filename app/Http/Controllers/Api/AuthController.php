<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Авторизация и регистрация пользователей"
 * )
 */
class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}

    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Auth"},
     *     summary="Регистрация пользователя",
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="password", type="string", example="password123"),
     *             @OA\Property(property="password_confirmation", type="string", example="password123")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Пользователь создан",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="user", type="object"),
     *             @OA\Property(property="token", type="string")
     *         )
     *     )
     * )
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $this->authService->register($request->validated());

        return response()->json($data, 201);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Auth"},
     *     summary="Логин пользователя",
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"email","password"},
     *
     *             @OA\Property(property="email", type="string", example="john@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Успешный логин",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="user", type="object"),
     *             @OA\Property(property="token", type="string")
     *         )
     *     ),
     *
     *     @OA\Response(response=422, description="Неверные данные")
     * )
     *
     * @throws ValidationException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $this->authService->login($request->validated());

        return response()->json($data);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Auth"},
     *     summary="Выход пользователя",
     *     security={{"sanctum": {}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Токен удален",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Токен удален, вы вышли из системы.")
     *         )
     *     )
     * )
     */
    public function logout(): JsonResponse
    {
        $data = $this->authService->logout(auth()->user());

        return response()->json($data);
    }
}
