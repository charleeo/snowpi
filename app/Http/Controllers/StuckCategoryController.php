<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;

class StuckCategoryController extends Controller
{
    public $service;
    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function getAllCategory(Request $request)
    {
        return $this->service->getAllCategory($request);
    }
    public function getAllCustomCategory(Request $request)
    {
        return $this->service->getAllCustomCategory($request);
    }

    public function createAcategory(Request $request)
    {
        return $this->service->createAcategory($request);
    }
    
    public function createACustomCategory(Request $request)
    {
        return $this->service->createACustomCategory($request);
    }
}
