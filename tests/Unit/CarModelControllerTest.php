<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\CarModelController;
use App\Http\Requests\CarModelRequest;
use App\Models\CarModel;
use App\Services\CarModelService;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class CarModelControllerTest extends TestCase
{
    public function test_index_returns_car_models_list()
    {
        $carModels = [
            new CarModel(['id' => 1, 'name' => 'Model S', 'brand_id' => 1]),
            new CarModel(['id' => 2, 'name' => 'Model X', 'brand_id' => 1]),
        ];
        foreach ($carModels as $carModel) {
            $carModel->setRelation('brand', new \App\Models\Brand(['id' => 1, 'name' => 'TestBrand']));
        }
        $service = Mockery::mock(CarModelService::class);
        $service->shouldReceive('list')->once()->andReturn($carModels);

        $controller = new CarModelController($service);

        $response = $controller->index();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $data = $response->getData(true)['data'];
        $this->assertCount(2, $data);
    }

    public function test_store_creates_car_model()
    {
        $carModelData = ['name' => 'Model S', 'brand_id' => 1];
        $carModel = new CarModel($carModelData);
        $carModel->setRelation('brand', new \App\Models\Brand(['id' => 1, 'name' => 'TestBrand']));

        $service = Mockery::mock(CarModelService::class);
        $service->shouldReceive('create')->once()->with($carModelData)->andReturn($carModel);

        $request = Mockery::mock(CarModelRequest::class);
        $request->shouldReceive('validated')->once()->andReturn($carModelData);

        $controller = new CarModelController($service);

        $response = $controller->store($request);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals($carModel->name, $response->getData(true)['data']['name']);
    }

    public function test_show_returns_car_model()
    {
        $carModel = new CarModel(['id' => 1, 'name' => 'Model S', 'brand_id' => 1]);
        $carModel->setRelation('brand', new \App\Models\Brand(['id' => 1, 'name' => 'TestBrand']));
        $service = Mockery::mock(CarModelService::class);
        $service->shouldReceive('show')->once()->with($carModel)->andReturn($carModel);

        $controller = new CarModelController($service);

        $response = $controller->show($carModel);

        $this->assertEquals($carModel->name, $response->getData(true)['data']['name']);
    }

    public function test_update_updates_car_model()
    {
        $carModel = new CarModel(['id' => 1, 'name' => 'Model S', 'brand_id' => 1]);
        $carModel->setRelation('brand', new \App\Models\Brand(['id' => 1, 'name' => 'TestBrand']));
        $updateData = ['name' => 'Model X', 'brand_id' => 2];

        $service = Mockery::mock(CarModelService::class);
        $service->shouldReceive('update')->once()->with($carModel, $updateData)->andReturn($carModel);

        $request = Mockery::mock(CarModelRequest::class);
        $request->shouldReceive('validated')->once()->andReturn($updateData);

        $controller = new CarModelController($service);

        $response = $controller->update($request, $carModel);

        $this->assertEquals($carModel->name, $response->getData(true)['data']['name']);
    }

    public function test_destroy_deletes_car_model()
    {
        $carModel = new CarModel(['id' => 1, 'name' => 'Model S', 'brand_id' => 1]);
        $carModel->setRelation('brand', new \App\Models\Brand(['id' => 1, 'name' => 'TestBrand']));

        $service = Mockery::mock(CarModelService::class);
        $service->shouldReceive('delete')->once()->with($carModel);

        $controller = new CarModelController($service);

        $response = $controller->destroy($carModel);

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEmpty($response->getData(true));
    }
}
