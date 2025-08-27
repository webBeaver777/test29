<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\BrandController;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Services\BrandService;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\TestCase;

class BrandControllerTest extends TestCase
{
    public function test_index_returns_brands_list()
    {
        $brands = [
            new Brand(['id' => 1, 'name' => 'TestBrand1']),
            new Brand(['id' => 2, 'name' => 'TestBrand2']),
        ];
        $service = Mockery::mock(BrandService::class);
        $service->shouldReceive('list')->once()->andReturn($brands);

        $controller = new BrandController($service);

        $response = $controller->index();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $data = $response->getData(true)['data'];
        $this->assertCount(2, $data);
    }

    public function test_store_creates_brand()
    {
        $brandData = ['name' => 'TestBrand'];
        $brand = new Brand($brandData);

        $service = Mockery::mock(BrandService::class);
        $service->shouldReceive('create')->once()->with($brandData)->andReturn($brand);

        $request = Mockery::mock(BrandRequest::class);
        $request->shouldReceive('validated')->once()->andReturn($brandData);

        $controller = new BrandController($service);

        $response = $controller->store($request);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals($brand->name, $response->getData(true)['data']['name']);
    }

    public function test_show_returns_brand()
    {
        $brand = new Brand(['id' => 1, 'name' => 'TestBrand']);
        $service = Mockery::mock(BrandService::class);
        $service->shouldReceive('show')->once()->with($brand)->andReturn($brand);

        $controller = new BrandController($service);

        $response = $controller->show($brand);

        $this->assertEquals($brand->name, $response->getData(true)['data']['name']);
    }

    public function test_update_updates_brand()
    {
        $brand = new Brand(['id' => 1, 'name' => 'TestBrand']);
        $updateData = ['name' => 'UpdatedBrand'];

        $service = Mockery::mock(BrandService::class);
        $service->shouldReceive('update')->once()->with($brand, $updateData)->andReturn($brand);

        $request = Mockery::mock(BrandRequest::class);
        $request->shouldReceive('validated')->once()->andReturn($updateData);

        $controller = new BrandController($service);

        $response = $controller->update($request, $brand);

        $this->assertEquals($brand->name, $response->getData(true)['data']['name']);
    }

    public function test_destroy_deletes_brand()
    {
        $brand = new Brand(['id' => 1, 'name' => 'TestBrand']);

        $service = Mockery::mock(BrandService::class);
        $service->shouldReceive('delete')->once()->with($brand);

        $controller = new BrandController($service);

        $response = $controller->destroy($brand);

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEmpty($response->getData(true));
    }
}
