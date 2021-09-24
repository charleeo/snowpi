<?php

namespace App\Http\Controllers;

use App\Services\SetupUtils;
use Illuminate\Http\Request;

class SetupController extends Controller
{
    public $setup ;
    public $message;
    public function __construct(SetupUtils $setup)
    {
        $this->setup = $setup;
    }
    public function setupSite():string{
        if($this->setup->createRoles()){
          $this->message = "Roles created ";
        }
        else $this->message = "Could not create Roles";
        return $this->message;
    }
}
