<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\CarController;
use App\Http\Requests\CarRequest;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\Brand;
use App\Models\User;
use App\Services\CarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class CarControllerTest extends TestCase
{
    public function test_index_returns_cars_list()
    {
        $user = new User(['id' => 1]);
        Auth::shouldReceive('user')->once()->andReturn($user);

        $carModel = new CarModel(['id' => 1, 'name' => 'Model S', 'brand_id' => 2]);
        $brand = new Brand(['id' => 2, 'name' => 'TestBrand']);
        $carModel->setRelation('brand', $brand);

        $cars = [
            new Car(['id' => 1, 'car_model_id' => 1, 'brand_id' => 2, 'year' => 2020, 'color' => 'red', 'mileage' => 15000]),
            new Car(['id' => 2, 'car_model_id' => 1, 'brand_id' => 2, 'year' => 2021, 'color' => 'blue', 'mileage' => 10000])
        ];
        foreach ($cars as $car) {
            $car->setRelation('carModel', $carModel);
            $car->setRelation('brand', $brand);
        }

        $service = Mockery::mock(CarService::class);
        $service->shouldReceive('list')->once()->with($user)->andReturn($cars);

        $controller = new CarController($service);

        $response = $controller->index();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $data = $response->getData(true)['data'];
        $this->assertCount(2, $data);
    }

    public function test_store_creates_car()
    {
        $user = new User(['id' => 1]);
        Auth::shouldReceive('user')->once()->andReturn($user);

        $carData = ['car_model_id' => 1, 'brand_id' => 2, 'year' => 2020, 'color' => 'red', 'mileage' => 15000];
        $car = new Car($carData);

        $carModel = new CarModel(['id' => 1, 'name' => 'Model S', 'brand_id' => 2]);
        $brand = new Brand(['id' => 2, 'name' => 'TestBrand']);
        $carModel->setRelation('brand', $brand);
        $car->setRelation('carModel', $carModel);
        $car->setRelation('brand', $brand);

        $service = Mockery::mock(CarService::class);
        $service->shouldReceive('create')->once()->with($user, $carData)->andReturn($car);

        $request = Mockery::mock(CarRequest::class);
        $request->shouldReceive('validated')->once()->andReturn($carData);

        $controller = new CarController($service);

        $response = $controller->store($request);

        $this->assertEquals(201, $response->getStatusCode());

        $responseData = $response->getData(true)['data'];

        // Проверяем поля, которые реально возвращает CarResource
        $this->assertEquals($car->id, $responseData['id']);
        $this->assertEquals($brand->name, $responseData['brand']);
        $this->assertEquals($carModel->name, $responseData['model']);
        $this->assertEquals($car->year, $responseData['year']);
        $this->assertEquals($car->mileage, $responseData['mileage']);
        $this->assertEquals($car->color, $responseData['color']);
    }

    public function test_show_returns_car()
    {
        $car = new Car(['id' => 1, 'car_model_id' => 1, 'brand_id' => 2, 'year' => 2020, 'color' => 'red', 'mileage' => 15000]);
        $carModel = new CarModel(['id' => 1, 'name' => 'Model S', 'brand_id' => 2]);
        $brand = new Brand(['id' => 2, 'name' => 'TestBrand']);
        $carModel->setRelation('brand', $brand);
        $car->setRelation('carModel', $carModel);
        $car->setRelation('brand', $brand);

        $service = Mockery::mock(CarService::class);
        $service->shouldReceive('show')->once()->with($car)->andReturn($car);

        $controller = Mockery::mock(CarController::class.'[authorize]', [$service]);
        $controller->shouldAllowMockingProtectedMethods()
            ->shouldReceive('authorize')->once()->with('view', $car);

        $response = $controller->show($car);

        $this->assertEquals($car->id, $response->getData(true)['data']['id']);
    }

    public function test_update_updates_car()
    {
        $car = new Car(['id' => 1, 'car_model_id' => 1, 'brand_id' => 2, 'year' => 2020, 'color' => 'red', 'mileage' => 15000]);
        $carModel = new CarModel(['id' => 1, 'name' => 'Model S', 'brand_id' => 2]);
        $brand = new Brand(['id' => 2, 'name' => 'TestBrand']);
        $carModel->setRelation('brand', $brand);
        $car->setRelation('carModel', $carModel);
        $car->setRelation('brand', $brand);

        $updateData = ['car_model_id' => 2, 'brand_id' => 3, 'year' => 2021, 'color' => 'blue', 'mileage' => 10000];

        $service = Mockery::mock(CarService::class);
        $service->shouldReceive('update')->once()->with($car, $updateData)->andReturn($car);

        $request = Mockery::mock(CarRequest::class);
        $request->shouldReceive('validated')->once()->andReturn($updateData);

        $controller = Mockery::mock(CarController::class.'[authorize]', [$service]);
        $controller->shouldAllowMockingProtectedMethods()
            ->shouldReceive('authorize')->once()->with('update', $car);

        $response = $controller->update($request, $car);

        $this->assertEquals($car->id, $response->getData(true)['data']['id']);
    }

    public function test_destroy_deletes_car()
    {
        $car = new Car(['id' => 1, 'car_model_id' => 1, 'brand_id' => 2, 'year' => 2020, 'color' => 'red', 'mileage' => 15000]);
        $carModel = new CarModel(['id' => 1, 'name' => 'Model S', 'brand_id' => 2]);
        $brand = new Brand(['id' => 2, 'name' => 'TestBrand']);
        $carModel->setRelation('brand', $brand);
        $car->setRelation('carModel', $carModel);
        $car->setRelation('brand', $brand);

        $service = Mockery::mock(CarService::class);
        $service->shouldReceive('delete')->once()->with($car);

        $controller = Mockery::mock(CarController::class.'[authorize]', [$service]);
        $controller->shouldAllowMockingProtectedMethods()
            ->shouldReceive('authorize')->once()->with('delete', $car);

        $response = $controller->destroy($car);

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEmpty($response->getData(true));
    }
}
