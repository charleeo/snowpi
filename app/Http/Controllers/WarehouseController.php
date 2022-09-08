<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWarehouseRequest;
use Illuminate\Http\Request;
use App\Services\WarehouseService;

class WarehouseController extends Controller
{
    private $service ;
    public function __construct(WarehouseService $wareHouseService)
    {
        $this->service=$wareHouseService;
    }

    public function createWarehouse(CreateWarehouseRequest  $request)
    {
        return $this->service->createWarehouse($request);
    }
    public function getWarehousesForAUser(Request  $request)
    {
        return $this->service->getWarehousesForAUser($request);
    }
    public function index(Request  $request)
    {
        return $this->service->index($request);
    }
    public function getAWarehouse(Request  $request,$id)
    {
        return $this->service->getAWarehouse($request,$id);
    }
}
