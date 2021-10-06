<?php

namespace App\Interfaces;

use Illuminate\Support\Facades\Request;

interface RestaurantInterface{
    public function store();
    public function update();
    public function delete();
}