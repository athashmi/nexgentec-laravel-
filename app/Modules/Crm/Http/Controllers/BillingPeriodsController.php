<?php
namespace App\Modules\Crm\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use App\Modules\Crm\Http\CustomerBillingPeriod;


use Auth;


class BillingPeriodsController extends Controller
{

	public function index()
	{
		//$controller = $this->controller;
        $billing_periods = CustomerBillingPeriod::all();
        $route_delete = 'admin.billing.destroy';

        return view('crm::billing.ajax_index',compact('billing_periods','route_delete'))->render();
	}
	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('crm::billing.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate($request, 
            [
                'title' => 'required|unique:customer_billing_periods|max:15',
                'description' => 'required',
            ]);
        
        $billing_period = New CustomerBillingPeriod();
        $billing_period->title = $request->title;
        $billing_period->description = $request->description;
        $billing_period->save();

        $arr['success'] = 'Billing period created successfully';
            return json_encode($arr);
            exit;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       $id = $request->id;
        $billing_period = CustomerBillingPeriod::findorFail($id);
        $billing_period->delete();
        //Session::flash('flash_message', 'User successfully deleted!');
        $arr['success'] = 'Billing period deleted successfully';
            return json_encode($arr);
            exit;
    }

}
