<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    protected $user;

    protected $signedIn;


    public function __construct() {// Need to call "parent::__construct();" in child controllers "__construct()" if they have "__construct()" of their defined
        $this->user = $this->signedIn = Auth::user();// if user is guest "Auth::user()" will return null
        //$this->user->username;// Can access user info like this in child controllers
        
        
        /*
         * To check if user is signed-in when not using middleware
         * if($this->signedIn){
            
        }*/
    }
}
