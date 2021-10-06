<?php

namespace App\Http\Controllers;

use App\Services\SetupUtils;
use Illuminate\Http\Request;

class SetupController extends Controller
{
    public $setup ;
    public $message =[];
    public function __construct(SetupUtils $setup)
    {
        $this->setup = $setup;
    }
    public function setupSite():string{
        if($this->setup->createRoles()){
          $this->message['Roles'] = "Roles created ";
        }
        else{ 
            $this->message['roles'] = "Could not create Roles";
        };
        
        if($this->setup->createOperatorRoles()){
            $this->message['Operator-Roles'] = "Operator Roles created ";  
        }else{
            $this->message['Operator-Roles'] = "Could not create Operators Roles";
        }
        $message = "<pre>".implode(",\n",$this->message)."</pre>"; 
        return $message;
    }
}
