<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\AuthController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function test_register_returns_created_user_and_token()
    {
        $mockService = Mockery::mock(AuthService::class);
        $requestData = ['name' => 'Test', 'email' => 'test@mail.com', 'password' => 'pass'];
        $responseData = ['user' => ['id' => 1, 'name' => 'Test'], 'token' => 'token123'];

        $mockService->shouldReceive('register')->once()->with($requestData)->andReturn($responseData);

        $request = Mockery::mock(RegisterRequest::class);
        $request->shouldReceive('validated')->once()->andReturn($requestData);

        $controller = new AuthController($mockService);

        $response = $controller->register($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals($responseData, $response->getData(true));
    }

    public function test_login_returns_user_and_token()
    {
        $mockService = Mockery::mock(AuthService::class);
        $requestData = ['email' => 'test@mail.com', 'password' => 'pass'];
        $responseData = ['user' => ['id' => 1, 'name' => 'Test'], 'token' => 'token123'];

        $mockService->shouldReceive('login')->once()->with($requestData)->andReturn($responseData);

        $request = Mockery::mock(LoginRequest::class);
        $request->shouldReceive('validated')->once()->andReturn($requestData);

        $controller = new AuthController($mockService);

        $response = $controller->login($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->getData(true));
    }

    public function test_logout_returns_message()
    {
        $mockService = Mockery::mock(AuthService::class);
        $user = (object) ['id' => 1];
        $responseData = ['message' => 'Токен удален, вы вышли из системы.'];

        $mockService->shouldReceive('logout')->once()->with($user)->andReturn($responseData);

        Auth::shouldReceive('user')->once()->andReturn($user);

        $controller = new AuthController($mockService);

        $response = $controller->logout();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->getData(true));
    }
}
