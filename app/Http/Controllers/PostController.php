<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
   public $postService;
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function store(StorePostRequest $request)
    {
        return $this->postService->store($request);
    }
    public function update(StorePostRequest $request)
    {
        return $this->postService->update($request);
    }

    public function index(Request $request)
    {
        return $this->postService->index($request);
    }

    public function show(Request $request,$id)
    {
       return $this->postService->show($request,$id);
    }
}
