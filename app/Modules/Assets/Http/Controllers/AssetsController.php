<?php
namespace App\Modules\Assets\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Crm\Http\Customer;
use App\Modules\Crm\Http\CustomerLocation;
use App\Modules\Assets\Http\Asset;
use Datatables;

use App\Model\Role;
use App\Model\User;
use Auth;
use Mail;
use URL;
class AssetsController extends Controller
{

	public function index()
	{

        return view('assets::index');
		//return "Controller Index";
	}
	function networkIndex($id=NULL)
	{
		$global_date = $this->global_date;
		   if($id!='')
		   	$assets = Asset::with(['customer'])->where('asset_type','network')->where('customer_id',$id);
		   	else
		$assets = Asset::with(['customer'])->where('asset_type','network');

//dd($assets);
		return Datatables::of($assets)


				->addColumn('action', function ($asset) {

				$return = '<button type="button" class="btn btn-primary btn-sm"
						 data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal-edit-asset">
							 <i class="fa fa-pencil"></i> Edit
					 </button>
				<button type="button" class="btn btn-primary btn-sm"
						 data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal-show-asset">
							 <i class="fa fa-eye"></i> View
					 </button>
					 <button type="button" class="btn btn-danger btn-sm"
															data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal-delete-ticket">
																<i class="fa fa-times-circle"></i>
																Delete
														</button>';



						return $return;
				})
				->addColumn('customer',function ($asset){

				return '<button class="btn bg-gray-active  btn-sm" type="button">
                            <i class="fa fa-user"></i>
                                <span>'.$asset->customer->name.'</span>
                            </button>';
				})
				->editColumn('created_at', function ($ticket) use ($global_date){

						return  date($global_date,strtotime($ticket->created_at));
				})
				  ->make(true);
	}


	function gatewayIndex($id=Null)
	{
		$global_date = $this->global_date;
		if($id!='')
		$assets = Asset::with(['customer'])->where('asset_type','gateway')->where('customer_id',$id);

			else
		$assets = Asset::with(['customer'])->where('asset_type','gateway');


		return Datatables::of($assets)


				->addColumn('action', function ($asset) {

				$return = '<button type="button" class="btn btn-primary btn-sm"
						 data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal-edit-asset">
							 <i class="fa fa-pencil"></i> Edit
					 </button>
				<button type="button" class="btn btn-primary btn-sm"
						 data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal-show-asset">
							 <i class="fa fa-eye"></i> View
					 </button>
					 <button type="button" class="btn btn-danger btn-sm"
															data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal-delete-ticket">
																<i class="fa fa-times-circle"></i>
																Delete
														</button>';



						return $return;
				})
				->editColumn('created_at', function ($ticket) use ($global_date){

						return  date($global_date,strtotime($ticket->created_at));
				})
				->addColumn('customer',function ($asset){

				return '<button class="btn bg-gray-active  btn-sm" type="button">
                            <i class="fa fa-user"></i>
                                <span>'.$asset->customer->name.'</span>
                            </button>';
				})
					->make(true);
	}


	function pbxIndex($id=Null)
	{
		$global_date = $this->global_date;

			if($id!='')
				$assets = Asset::with(['customer'])->where('asset_type','pbx')->where('customer_id',$id);
			else

				$assets = Asset::with(['customer'])->where('asset_type','pbx');


		return Datatables::of($assets)


				->addColumn('action', function ($asset) {

				$return = '<button type="button" class="btn btn-primary btn-sm"
						 data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal-edit-asset">
							 <i class="fa fa-pencil"></i> Edit
					 </button>

				<button type="button" class="btn btn-primary btn-sm"
						 data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal-show-asset">
							 <i class="fa fa-eye"></i> View
					 </button>
												 <button type="button" class="btn btn-danger btn-sm"
															data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal-delete-ticket">
																<i class="fa fa-times-circle"></i>
																Delete
														</button>';



						return $return;
				})
				->editColumn('created_at', function ($ticket) use ($global_date){

						return  date($global_date,strtotime($ticket->created_at));
				})
				->addColumn('customer',function ($asset){

				return '<button class="btn bg-gray-active  btn-sm" type="button">
                            <i class="fa fa-user"></i>
                                <span>'.$asset->customer->name.'</span>
                            </button>';
				})
					->make(true);
	}

	function serverIndex($id=Null)
	{
		$global_date = $this->global_date;
		if($id!='')
			$assets = Asset::with(['customer'])->where('asset_type','server')->where('customer_id',$id);
		else
			$assets = Asset::with(['customer'])->where('asset_type','server');


		return Datatables::of($assets)


				->addColumn('action', function ($asset) {

				$return = '<button type="button" class="btn btn-primary btn-sm"
						 data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal-edit-asset">
							 <i class="fa fa-pencil"></i> Edit
					 </button>
				<button type="button" class="btn btn-primary btn-sm"
						 data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal-show-asset">
							 <i class="fa fa-eye"></i> View
					 </button>
												 <button type="button" class="btn btn-danger btn-sm"
															data-toggle="modal" data-id="'.$asset->id.'" id="modaal" data-target="#modal-delete-ticket">
																<i class="fa fa-times-circle"></i>
																Delete
														</button>';



						return $return;
				})
				->editColumn('created_at', function ($ticket) use ($global_date){

						return  date($global_date,strtotime($ticket->created_at));
				})
				->addColumn('customer',function ($asset){

				return '<button class="btn bg-gray-active  btn-sm" type="button">
                            <i class="fa fa-user"></i>
                                <span>'.$asset->customer->name.'</span>
                            </button>';
				})
					->make(true);
	}

	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers_obj = Customer::with(['locations','locations.contacts'])->get();
        $customers = [];
         if($customers_obj->count())
        {
            foreach($customers_obj as $customer) {
                $customers[$customer->id]=$customer->name.'('.$customer->email_domain.')';
                //dd($user->id);
            }

        }


         return view('assets::add',compact('customers'));
        //
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
						 'name' => 'required',
             'customer' => 'required',


				 ]);

				 if($request->asset_type == 'network')
				 {
					// dd($request->asset_type);

                    $this->validate($request,
                     [
                        'manufacture' => 'required',
                        'model' => 'required',
                     ]);


                    $asset = new Asset();
                    $asset->name = $request->name;
                     $asset->customer_id = $request->customer;
										 $asset->location_id = $request->location;
                     $asset->manufacture = $request->manufacture;
                     $asset->os = $request->os;
										 $asset->asset_type = 'network';
                     $asset->model = $request->model;
                     $asset->ip_address = $request->ip_address;
                     $asset->user_name = $request->user_name;
                     $asset->password = $request->password;
                     $asset->is_static = $request->is_static;
                     $asset->static_type = $request->static_type;
                     $asset->notes = $request->notes;
                     $asset->save();
                     $arr['success'] = 'Asset added sussessfully';
            return json_encode($arr);
            exit;


				 }
				 if($request->asset_type == 'gateway')
				 {
					 	//dd('here');
										 $this->validate($request,
											[
												 'manufacture' => 'required',
												 'model' => 'required',
											]);


										 $asset = new Asset();
										 $asset->name = $request->name;
											$asset->customer_id = $request->customer;
											$asset->location_id = $request->location;
											$asset->manufacture = $request->manufacture;
											 $asset->asset_type = 'gateway';
											$asset->model = $request->model;
											$asset->lan_ip_address = $request->lan_ip_address;
											$asset->wan_ip_address = $request->wan_ip_address;
											$asset->password = $request->password;
											$asset->ssid = $request->ssid;

											$asset->notes = $request->notes;
											$asset->save();
											$arr['success'] = 'Asset added sussessfully';
						 return json_encode($arr);
						 exit;


				 }

				 if($request->asset_type == 'pbx')
				{
					 //dd('here');
										$this->validate($request,
										 [
												'manufacture' => 'required',

										 ]);


										 $asset = new Asset();
                     $asset->name = $request->name;
                      $asset->customer_id = $request->customer;
 										 $asset->location_id = $request->location;
                      $asset->manufacture = $request->manufacture;
                      $asset->os = $request->os;
 										 $asset->asset_type = 'pbx';

                      $asset->ip_address = $request->ip_address;
                      $asset->host_name = $request->host_name;
											$asset->user_name = $request->user_name;
                      $asset->password = $request->password;
                      $asset->admin_gui_address = $request->admin_gui_address;
                      $asset->hosted = $request->hosted;

                      $asset->save();
										 $arr['success'] = 'Asset added sussessfully';
						return json_encode($arr);
						exit;


				}

				if($request->asset_type == 'server')
			 {

			 	 //dd($request->all());
				//dd(json_encode($request->roles));
			 						$this->validate($request,
			 						 [
			 								'serial_number' => 'required',

			 						 ]);


			 						 	$asset = new Asset();
			 						 	$asset->name = $request->name;
			 							$asset->customer_id = $request->customer;
			 						 	$asset->location_id = $request->location;
			 							$asset->server_type = $request->server_type;
			 							$asset->virtual_server_type = $request->virtual_type;
			 						 	$asset->asset_type = 'server';
										$asset->roles = json_encode($request->roles);
			 							$asset->ip_address = $request->ip_address;
			 							$asset->host_name = $request->host_name;
			 							$asset->serial_number = $request->serial_number;

										$asset->notes = $request->notes;
										$asset->save();
			 						 $arr['success'] = 'Asset added sussessfully';
			 		return json_encode($arr);
			 		exit;


			 }


        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

				$asset = Asset::with(['customer','location'])->where('id',$id)->first();
				//dd($asset);
				$arr['html_content_asset'] =  view('assets::show_partial',compact('asset'))->render();
				$arr['asset_name'] = $asset->name;
				 return json_encode($arr);
			exit;

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
			$asset = Asset::with(['customer','location'])->where('id',$id)->first();

			$cust_locations = CustomerLocation::where('customer_id',$asset->customer->id)->get();
            $locations = [];
			if($cust_locations->count())
    		 {
    				 foreach($cust_locations as $cust_location) {
    						 $locations[$cust_location->id]=$cust_location->location_name;
    						 //dd($user->id);
    				 }

    		 }

             $customers_obj = Customer::with(['locations','locations.contacts'])->get();
                $customers = [];
                     if($customers_obj->count())
                    {
                        foreach($customers_obj as $customer) {
                            $customers[$customer->id]=$customer->name.'('.$customer->email_domain.')';
                            //dd($user->id);
                        }

                    }


			//dd($asset);
			//	$arr['locations'] = $locations;
			$arr['html_content_asset'] =  view('assets::edit_partial',compact('asset','locations','customers'))->render();
            $arr['asset_type'] = $asset ->asset_type;

			//$arr['asset_name'] = $asset->name;
			 return json_encode($arr);
		exit;
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->asset_id;


            //dd($request->all());
            $this->validate($request,
                 [
                'name' => 'required',
                'customer' => 'required',


                 ]);

                 if($request->asset_type == 'network')
                 {
                    // dd($request->asset_type);

                    $this->validate($request,
                     [
                        'manufacture' => 'required',
                        'model' => 'required',
                     ]);


                    $asset = Asset::find($id);
                    $asset->name = $request->name;
                     $asset->customer_id = $request->customer;
                                         $asset->location_id = $request->location;
                     $asset->manufacture = $request->manufacture;
                     $asset->os = $request->os;
                                         $asset->asset_type = 'network';
                     $asset->model = $request->model;
                     $asset->ip_address = $request->ip_address;
                     $asset->user_name = $request->user_name;
                     $asset->password = $request->password;
                     $asset->is_static = $request->is_static;
                     $asset->static_type = $request->static_type;
                     $asset->notes = $request->notes;
                     $asset->save();
                     $arr['success'] = 'Asset added sussessfully';
            return json_encode($arr);
            exit;


                 }
                 if($request->asset_type == 'gateway')
                 {
                        //dd('here');
                                         $this->validate($request,
                                            [
                                                 'manufacture' => 'required',
                                                 'model' => 'required',
                                            ]);


                                       $asset = Asset::find($id);
                                         $asset->name = $request->name;
                                            $asset->customer_id = $request->customer;
                                            $asset->location_id = $request->location;
                                            $asset->manufacture = $request->manufacture;
                                             $asset->asset_type = 'gateway';
                                            $asset->model = $request->model;
                                            $asset->lan_ip_address = $request->lan_ip_address;
                                            $asset->wan_ip_address = $request->wan_ip_address;
                                            $asset->password = $request->password;
                                            $asset->ssid = $request->ssid;

                                            $asset->notes = $request->notes;
                                            $asset->save();
                                            $arr['success'] = 'Asset added sussessfully';
                         return json_encode($arr);
                         exit;


                 }

                 if($request->asset_type == 'pbx')
                {
                     //dd('here');
                                        $this->validate($request,
                                         [
                                                'manufacture' => 'required',

                                         ]);


                                         $asset = Asset::find($id);
                     $asset->name = $request->name;
                      $asset->customer_id = $request->customer;
                                         $asset->location_id = $request->location;
                      $asset->manufacture = $request->manufacture;
                      $asset->os = $request->os;
                                         $asset->asset_type = 'pbx';

                      $asset->ip_address = $request->ip_address;
                      $asset->host_name = $request->host_name;
                                            $asset->user_name = $request->user_name;
                      $asset->password = $request->password;
                      $asset->admin_gui_address = $request->admin_gui_address;
                      $asset->hosted = $request->hosted;

                      $asset->save();
                                         $arr['success'] = 'Asset added sussessfully';
                        return json_encode($arr);
                        exit;


                }

                if($request->asset_type == 'server')
             {

                 //dd($request->all());
                //dd(json_encode($request->roles));
                                    $this->validate($request,
                                     [
                                            'serial_number' => 'required',

                                     ]);


                                      $asset = Asset::find($id);
                                        $asset->name = $request->name;
                                        $asset->customer_id = $request->customer;
                                        $asset->location_id = $request->location;
                                        $asset->server_type = $request->server_type;
                                        $asset->virtual_server_type = $request->virtual_type;
                                        $asset->asset_type = 'server';
                                        $asset->roles = json_encode($request->roles);
                                        $asset->ip_address = $request->ip_address;
                                        $asset->host_name = $request->host_name;
                                        $asset->serial_number = $request->serial_number;

                                        $asset->notes = $request->notes;
                                        $asset->save();
                                     $arr['success'] = 'Asset added sussessfully';
                    return json_encode($arr);
                    exit;


             }


        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
