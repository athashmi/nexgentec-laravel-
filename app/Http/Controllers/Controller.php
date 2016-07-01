<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Model\Config;



abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

public $global_date;

     function __construct() 
    {

    	$global_date = Config::where('title','date_format')->first();
        $global_time = Config::where('title','time_format')->first();
        if($global_date)
		$this->global_date = $global_date->key;
		else
		$this->global_date = 'm/d/Y';


        \View::share('global_date',$this->global_date);
         \View::share('global_time', $global_time);
       
    }
}
