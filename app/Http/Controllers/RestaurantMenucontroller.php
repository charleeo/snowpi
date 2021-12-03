<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRestaurantMenuRequest;
use App\Repositories\RestaurantMenuRepository;
use Illuminate\Http\Request;

class RestaurantMenucontroller extends Controller
{
    public $restaurantMenuRepo;

    public function __construct(RestaurantMenuRepository $repo)
    {
        $this->restaurantMenuRepo = $repo;
    }

    public function store(StoreRestaurantMenuRequest $request)
    {
        return $this->restaurantMenuRepo->store($request);
    }

    public function update(StoreRestaurantMenuRequest $request,$id)
    {
        return $this->restaurantMenuRepo->update($request,$id);
    }

}
