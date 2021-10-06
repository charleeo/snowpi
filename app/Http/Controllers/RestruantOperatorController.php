<?php

namespace App\Http\Controllers;

use App\Exceptions\Helpers\Helper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreRestaurantOperatorRequest;
use App\Models\RestaurantOperator;
use App\Models\RestaurantRole;
use App\Repositories\RestaurantProvidersRepository;
use App\Services\AppUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestruantOperatorController extends Controller
{
    protected $restaurantRepo;
    public function __construct(RestaurantProvidersRepository $restaurantRepo)
    {
        $this->restaurantRepo = $restaurantRepo;
    }
    public function store(StoreRestaurantOperatorRequest $request)
    {   
            return $this->restaurantRepo->store($request);
    }
    public function login(LoginRequest $request)
    {
        return $this->restaurantRepo->login($request);
    }

    public function getOperator(Request $request){
        return $this->restaurantRepo->getRestaurantOperator($request);
    }

}
