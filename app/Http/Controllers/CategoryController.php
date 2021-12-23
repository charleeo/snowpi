<?php

namespace App\Http\Controllers;

use App\Services\PostCategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public $categoryService;
    public function __construct(PostCategoryService $service)
    {
        $this->categoryService = $service;
    }
    public function store(Request $request)
    {
       return $this->categoryService->store($request);
    }

    public function index(Request $request)
    {
        return $this->categoryService->index($request);
    }
    public function storeSubCategory(Request $request)
    {
      return $this->categoryService->storeSubCategory($request);
    }
    public function getSubCategory(Request $request)
    {
      return $this->categoryService->getSubCategory($request);
    }
}
