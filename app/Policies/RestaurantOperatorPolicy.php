<?php

namespace App\Policies;

use App\Models\RestaurantOperator;
use App\Models\RestaurantRole;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RestaurantOperatorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RestaurantOperator  $restaurantOperator
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, RestaurantOperator $restaurantOperator)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(RestaurantOperator $restaurantOperator)
    {
        $pass = false;
        if($restaurantOperator->role_id === 1) $pass= true;
        return $pass;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RestaurantOperator  $restaurantOperator
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(RestaurantOperator $restaurantOperator)
    {
        
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RestaurantOperator  $restaurantOperator
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, RestaurantOperator $restaurantOperator)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RestaurantOperator  $restaurantOperator
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, RestaurantOperator $restaurantOperator)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\RestaurantOperator  $restaurantOperator
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, RestaurantOperator $restaurantOperator)
    {
        //
    }
}
