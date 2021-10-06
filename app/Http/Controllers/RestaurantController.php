<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteRestaurantRequest;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Repositories\RestaurantRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    public $restaurantRepo;
    public function __construct(RestaurantRepository $restaurantRepository)
    {
        $this->restaurantRepo = $restaurantRepository;
    }
    public function create(StoreRestaurantRequest $request)
    {
        return $this->restaurantRepo->store($request);
    }

    public function index(Request $request){
        return $this->restaurantRepo->index($request);
    }

    public function update(StoreRestaurantRequest $request, UpdateRestaurantRequest $update)
    {   
           return $this->restaurantRepo->store($request,$update->restaurant_guid);
    }

    public function show(Request $request, $id){
        return $this->restaurantRepo->show($request,$id);
    }
    public function delete(DeleteRestaurantRequest $request, $id){
        return $this->restaurantRepo->delete($request,$id);
    }
}
