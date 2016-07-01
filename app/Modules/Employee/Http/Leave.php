<?php

namespace App\Modules\Employee\Http;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
     public function user()
    {
    	return $this->belongsTo('App\Model\User');
        
    }
}
