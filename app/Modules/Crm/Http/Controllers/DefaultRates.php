<?php
namespace App\Modules\Crm\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use App\Modules\Crm\Http\Customer;

use App\Modules\Crm\Http\DefaultRate;

use App\Model\Role;
use App\Model\User;
use Auth;
use URL;
use Datatables;

class DefaultRates extends Controller
{
    
	public function index()
	{
	
        $rates = DefaultRate::all();
        return view('crm::crm.def_rate.index',compact('rates'))->render();

         //return view('crm::crm.def_rate.index',compact('rates'));
	}

   
    public function create()
    {
        
       
        return view('crm::crm.def_rate.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
         $this->validate($request, 
            [
                'title' => 'required',
                'amount' => 'required',
               
                
            ]);
        $rate  = new  DefaultRate;
          
           $rate->title = $request->title;
           $rate->amount = $request->amount;
            

           $rate->save();

            $arr['success'] = 'Rate created successfully';
            return json_encode($arr);
            exit;
        
       // return redirect()->intended('admin/crm/list_default_rates'); 
       
    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$id = $request->id;
        $rate = DefaultRate::find($id);
        
        

       $rate->delete();
        //Session::flash('flash_message', 'User successfully deleted!');
       // return redirect()->intended('admin/crm/list_default_rates'); 
       $arr['success'] = 'Rate deleted successfully';
            return json_encode($arr);
            exit;
    }




}


