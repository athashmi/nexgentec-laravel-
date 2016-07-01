<?php

namespace App\Modules\Crm\Http;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    public function service_items()
    {
        return $this->hasMany('App\Modules\Crm\Http\CustomerServiceItem');
    }

   /* public function billing_periods()
    {
        return $this->hasMany('App\Modules\Crm\Http\CustomerBillingPeriod');
    }*/

    public function locations()
    {
        return $this->hasMany('App\Modules\Crm\Http\CustomerLocation');
    }

     public function tickets()
    {
        return $this->hasMany('App\Modules\Crm\Http\Ticket');
    }

     public function default_rates()
    {
        return $this->hasMany('App\Modules\Crm\Http\DefaultRate');
    }
   
   public function assets()
    {
        return $this->hasMany('App\Modules\Assets\Http\Asset');
    }
    
}
