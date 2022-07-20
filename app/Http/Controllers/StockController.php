<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveStockRequest;
use App\Services\StockService;
use Illuminate\Http\Request;

class StockController extends Controller
{
    private $stockService;
    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function createAstockRecord(SaveStockRequest $request)
    {
        return $this->stockService->createAstock($request);
    }
}
