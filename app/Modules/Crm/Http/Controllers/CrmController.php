<?php
namespace App\Modules\Crm\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use App\Modules\Crm\Http\Customer;
use App\Modules\Crm\Http\CustomerServiceType;
use App\Modules\Crm\Http\DefaultRate;
use App\Modules\Crm\Http\CustomerBillingPeriod;
use App\Modules\Crm\Http\CustomerServiceItem;
use App\Modules\Crm\Http\CustomerServiceRate;
use App\Modules\Crm\Http\CustomerLocation;
use App\Modules\Crm\Http\Country;

use App\Modules\Crm\Http\CustomerLocationContact;

use App\Model\Config;

use App\Model\Role;
use App\Model\User;
use Auth;
use URL;
use Datatables;

class CrmController extends Controller
{
    private $hourly = 'hourly';
    private $flate_fee = 'flate fee';
    private $project = 'project';

	public function index()
	{
		//$controller = $this->controller;
        //$customers = Customer::with(['locations','locations.contacts'])->paginate(10);
       // dd($customers);
       // $route_delete = 'admin.crm.destroy';

        $route_delete = 'admin.crm.destroy';

        //return view('crm::crm.index',compact('customers','controller','route_delete'));
         return view('crm::crm.index',compact('route_delete'));
	}

    public function ajaxDataIndex()
    {
         $date_format = Config::where('title','date_format')->first();
        //$controller = $this->controller;
        $customers = Customer::with(['locations','locations.contacts']);
       

        return Datatables::of($customers)
            //->editColumn('title', '{!! str_limit($title, 60) !!}')
        ->addColumn('action', function ($customer) {

             //$customer->locations //loop    

            $return = '<a href="'.URL::route('admin.crm.show',$customer->id).'" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a>
                            
                             
                             <button type="button" class="btn btn-danger btn-sm"
                                  data-toggle="modal" data-id="'.$customer->id.'" id="modaal" data-target="#modal-delete-customer">
                                    <i class="fa fa-times-circle"></i>
                                    Delete
                                </button>';
                                if(!$customer->zohoid)
                               $return .= ' <a href="javascript:;"  onclick="export_zoho("'.$customer->id.'")" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i>  Export to Zoho</a>
                                  <img id="load_img" src="'.asset('img/loader.gif').'" style="display:none" />';
                              
                            
                return $return;
            })
            ->addColumn('contact', function ($customer) {

             //$customer->locations //loop   
             $return = ''; 
                foreach($customer->locations as $location)
                {
                    foreach($location->contacts as $contact)
                    {
                        if($contact->is_poc)
                        {
                           $return .= '<button type="button" class="btn bg-gray-active  btn-sm">
                            <i class="fa fa-user"></i>  
                                <span>'.$contact->f_name.' '.$contact->l_name.'</span>
                            </button>  
                             <button type="button" class="btn bg-gray-active  btn-sm">
                              <i class="fa fa-phone"></i> 
                                <span>'.$contact->phone.'</span>
                            </button>';
                          
                        } 
                    }
                }
           
                return $return;
            })
            ->editColumn('created_at', function ($customer) use($date_format) {

                return  date($date_format->key,strtotime($customer->created_at));
            })
           ->addColumn('locations', function ($customer) {

                
                return '<button type="button" class="btn bg-gray-active  btn-sm">
                                
                                   <span>'.count($customer->locations).'</span>
                                </button>';
            })
            ->make(true);

        //return view('crm::crm.index',compact('customers','controller','route_delete'));

    }
	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $def_rates_ = DefaultRate::all();
        $def_rates = [];
        foreach($def_rates_ as $def_rate)
        {
           $def_rates[$def_rate->title.'|'.$def_rate->amount] =$def_rate->title.' ($'.$def_rate->amount.')';
        }

        $service_items = CustomerServiceType::all(); 
        $service_types = [];
        foreach($service_items as $service_item)
        {
           $service_types[$service_item->id] =$service_item->title;
        }

        $countries_ = Country::all();
        $countries = [];
        foreach($countries_ as $country)
        {
           $countries[$country->name] =$country->name;
        }


         $billing_periods = CustomerBillingPeriod::all();
        $billing_arr = [];
        foreach($billing_periods as $billing_period)
        {
           $billing_arr[$billing_period->id] =$billing_period->title;
        }

        $date_format = Config::where('title','date_format')->first();
        $time_format = Config::where('title','time_format')->first();

        return view('crm::crm.add',compact('service_types','billing_arr','countries','def_rates','date_format','time_format'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $service_items = CustomerServiceType::all();
        $service_types = [];
        foreach($service_items as $service_item)
        {
           $service_types[$service_item->id] =$service_item->title;
        }

        //dd($request->all()); //
        
        //dd($contacts_arr);
        //dd();
        //1st step
        $customer = new Customer;
        $customer->name  = $request->customer_name;
        $customer->main_phone = $request->phone;
        $customer->email_domain = $request->email_domain;
        $customer->customer_since = date( "Y-m-d",strtotime($request->customer_since));
        $customer->is_active = $request->active;
        $customer->is_taxable = $request->taxable;
        $customer->save();


        //2nd step 
        $service_item = new CustomerServiceItem;
        $service_item->service_type_id = $request->service_type_id;
        $service_item->title = $request->service_item_name;
        $service_item->start_date = date( "Y-m-d",strtotime($request->start_date));
        $service_item->end_date = date( "Y-m-d",strtotime($request->end_date));

        $service_item->is_active = $request->service_active;
        if(isset($request->service_default))
        $service_item->is_default = $request->service_default;
        else
        $service_item->is_default =0;

        //if flate fee
        if(strtolower($service_types[$request->service_type_id])==$this->hourly || strtolower($service_types[$request->service_type_id])== $this->flate_fee)
        {
            $service_item->billing_period_id = $request->billing_period_id;
        }

        if(strtolower($service_types[$request->service_type_id])==$this->flate_fee)
        {
            $service_item->unit_price = $request->unit_price;
            $service_item->quantity  = $request->quantity;
        }

        if(strtolower($service_types[$request->service_type_id])==$this->project)
        {
            $service_item->estimate = $request->project_estimate;
            $service_item->estimated_hours = $request->estimated_hours;
            $service_item->bill_for = $request->bill_for;
        }
        //$service_item->save();
        $service_item->comments = $request->description_invoicing;
        $customer->service_items()->save($service_item);

        if($request->default_rate)
        {
            $rate = new CustomerServiceRate;

            $default_rate_arr = explode('|',$request->default_rate);
            $default_rate_title = $default_rate_arr[0];
            $default_rate_amount = $default_rate_arr[1];

            $rate->title = $default_rate_title;
            $rate->amount = $default_rate_amount;
            $rate->status = 1;
            $service_item->rates()->save($rate);
        }
        if($request->additional_rates)
        {
            foreach($request->additional_rates as $additional_rate)
            {
                $additional_rate_obj = new CustomerServiceRate;

                $additional_rates_arr = explode('|',$additional_rate);
                /*$additional_rates[] = ['amount'=>$additional_rates_arr[1],
                                        'title'=>$additional_rates_arr[0]];*/
                $additional_rate_obj->title = $additional_rates_arr[0];
                $additional_rate_obj->amount = $additional_rates_arr[1];
                 $additional_rate_obj->status = 1;

                
                $service_item->rates()->save($additional_rate_obj);
            }
        }

        



        $contacts_arr = json_decode($request->cntct_obj);
        $locations_arr = json_decode($request->loc_obj);
        //dd($locations_arr);
        foreach ($locations_arr as $location) 
        {
            $location_obj = new CustomerLocation;
           $location_obj->location_name = $location->location_name;
           $location_obj->address = $location->address;
           $location_obj->country = $location->country;
           $location_obj->state = $location->state;
           $location_obj->city = $location->city;
           $location_obj->zip = $location->zip;
           $location_obj->phone = $location->loc_main_phone;
           if($location->default_)
           $location_obj->default = $location->default_;
            else
            $location_obj->default =0;
           

           $customer->locations()->save($location_obj);

           foreach ($contacts_arr as $contact) 
            {
                if($contact->contact_location_index == $location->loc_id)
                {
                    $contact_obj         = new CustomerLocationContact;
                    $contact_obj->f_name = $contact->f_name;
                    $contact_obj->l_name = $contact->l_name;
                    $contact_obj->email  = $contact->email;
                    $contact_obj->title  = $contact->title_;
                    $contact_obj->phone  = $contact->contact_phone;
                    $contact_obj->mobile = $contact->contact_mobile;
                    $contact_obj->is_poc = $contact->contact_poc;

                   $location_obj->contacts()->save($contact_obj);
               }
            }

        }

        return redirect()->intended('admin/crm'); 
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::with(['service_items','locations','locations.contacts','service_items.rates','service_items.service_type'])->where('id',$id)->first();
        //dd($customer);
        $countries_ = Country::all();
        $countries = [];
        foreach($countries_ as $country)
        {
           $countries[$country->name] =$country->name;
        }
        // for edit purpose
       /* $service_items = CustomerServiceType::all();
      
        $service_types = [];
        foreach($service_items as $service_item)
        {
           $service_types[$service_item->id] =$service_item->title;
        }*/
       // \View::share('cust_id',$id);
         session(['cust_id' => $id,
                    'customer_name'=>$customer->name]);

        return view('crm::crm.show',compact('customer','service_types','countries'));
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
        $id = $request->customer_del_id;
        $customer = Customer::with(['service_items','locations','locations.contacts','service_items.rates','service_items.service_type'])->where('id',$id)->first();
        
        foreach ($customer->locations as $location) {
            $location->contacts()->delete();
        }
      
        $customer->locations()->delete();

        foreach ($customer->service_items as $service_item) {
            $service_item->rates()->delete();
        }
        $customer->service_items()->delete();


       $customer->delete();
        //Session::flash('flash_message', 'User successfully deleted!');
        return redirect()->intended('admin/crm');
    }




    function ajaxDataLoad(Request $request)
    {
        $hourly = $this->hourly;
        $flate_fee = $this->flate_fee;
        $project = $this->project;

        $service_item = CustomerServiceType::find($request->id);
        $billing_periods = CustomerBillingPeriod::all();
        $billing_arr = [];
        foreach($billing_periods as $billing_period)
        {
           $billing_arr[$billing_period->id] =$billing_period->title;
        }
        return view('crm::crm.service_item.ajax_service_item',compact('service_item','billing_periods','billing_arr','hourly','flate_fee','project'))->render();
        
    }

    function ajaxLoadLocation(Request $request)
    {
        $location = CustomerLocation::find($request->id)->toJson();
        return $location;
    }


    function ajaxUpdateLocation(Request $request)
    {
        $this->validate($request, 
            [
                'location_name' => 'required',
               
                
            ]);
//dd($request->all());
           $location_obj =  CustomerLocation::find($request->loc_id);
          
           $customer_id = $location_obj->customer_id;
           $location_obj->location_name = $request->location_name;
           $location_obj->address = $request->address;
           $location_obj->country = $request->country;
           $location_obj->state = $request->state;
           $location_obj->city = $request->city;
           $location_obj->zip = $request->zip;
           $location_obj->phone = $request->loc_main_phone;
           $location_obj->default = $request->default;

           $location_obj->save();


           $locations =  CustomerLocation::where('customer_id',$customer_id)->get();
            $view = view('crm::crm.location.ajax_refresh_locations',compact('locations','customer_id'))->render();
           // dd($view);
            $arr['html_content'] = (string) $view;
            $arr['success'] = 'Location updated successfully';
            return json_encode($arr);
            exit;
    }

    function ajaxLoadContact(Request $request)
        {
            //echo $request->id;
            $data['contact'] = CustomerLocationContact::find($request->cntct_id);

            //echo $data['contact'];
            $data['locations'] = CustomerLocation::where('customer_id',$request->customer_id)->get();
            return json_encode($data);
            exit;
        }



    function ajaxUpdateContact(Request $request)
    {
        $this->validate($request, 
            [
                'f_name' => 'required',
               
                
            ]);
            //dd($request->all());
           $contact_obj =  CustomerLocationContact::find($request->cntct_id);
          
            $contact_obj->f_name = $request->f_name;
            $contact_obj->l_name = $request->l_name;
            $contact_obj->customer_location_id = $request->location_index;
            $contact_obj->email  = $request->email;
            $contact_obj->title  = $request->title;
            $contact_obj->phone  = $request->contact_phone;
            $contact_obj->mobile = $request->contact_mobile;
            if($request->primary_poc)
            $contact_obj->is_poc = 1;
            else
              $contact_obj->is_poc = 0;   
            $contact_obj->save();

            $arr['success'] = 'Contact updated sussessfully';
            return json_encode($arr);
            exit;
    }

    function ajaxRefreshContacts($customer_id)
    {
        //dd($id);
        //echo $request->id;
        //$location_contacts = CustomerLocationContact::where('customer_location_id',$location_id)->get();
        $customer = Customer::with(['locations','locations.contacts'])->where('id',$customer_id)->first();

        //dd($customer);
        //echo $data['contact'];
        //$data['customer'] = 
        return view('crm::crm.contact.ajax_refresh_location_contacts',compact('customer'))->render();
        //return json_encode($data);
        exit;
    }

   
     function ajaxLoadInfo($id)
    {
        //dd($id);
        //echo $request->id;
        $customer = Customer::find($id);
        //dd( $customer);
        //echo $data['contact'];

        $data['customer_name'] = $customer->name;
        $data['phone'] = $customer->main_phone;
        $data['email_domain'] = $customer->email_domain;
        $data['customer_since'] = date('m/d/Y',strtotime($customer->customer_since));
        $data['is_taxable'] = $customer->is_taxable;

        $data['is_active'] = $customer->is_active;


        

        //$data['loc_name'] = $location->location_name;
      
        return json_encode($data);
        //return json_encode($data);
        exit;
    }


     function ajaxUpdateInfo(Request $request)
    {
        $this->validate($request, 
            [
                'customer_name' => 'required',
               
                
            ]);

            $customer = Customer::find($request->c_id);
            $customer->name  = $request->customer_name;
            $customer->main_phone = $request->phone;
            $customer->email_domain = $request->email_domain;
            $customer->customer_since = date( "Y-m-d",strtotime($request->customer_since));
            $customer->is_active = $request->active;
            $customer->is_taxable = $request->taxable;
            $customer->save();

            $arr['success'] = 'Customer info updated successfully';
            return json_encode($arr);
            exit;
    }

    function ajaxRefreshInfo($id)
    {
        //dd($id);
        //echo $request->id;
        $customer = Customer::find($id);
        //dd( $customer);
        //echo $data['contact'];

        $view = view('crm::crm.info.ajax_refresh_info',compact('customer'));
        $data['html_content'] = (string) $view;
        $data['h1_title'] = $customer->name;
      
        return json_encode($data);
        //return json_encode($data);
        exit;
    }


function ajaxAddLocation(Request $request)
    {

        $this->validate($request, 
            [
                'location_name' => 'required',
               
                
            ]);

        //dd($request->all());
            $location_obj = new CustomerLocation;
           $location_obj->location_name = $request->location_name;
           $location_obj->address = $request->address;
           $location_obj->country = $request->country;
           $location_obj->state = $request->state;
           $location_obj->city = $request->city;
           $location_obj->zip = $request->zip;
           $location_obj->phone = $request->loc_main_phone;
           if($request->default)
           $location_obj->default = $request->default;
            else
            $location_obj->default =0;
            $location_obj->customer_id = $request->new_loc_customer_id;

            $location_obj->save();
           //dd( $location_obj->id);

            $customer_id = $request->new_loc_customer_id;

           $arr['success'] = 'Location added successfully';


           $locations = CustomerLocation::with('contacts')->where('customer_id',$request->new_loc_customer_id)->get();
           //dd(  $locations );
           $view = view('crm::crm.location.ajax_refresh_locations',compact('locations','customer_id'));
            $arr['html_content'] = (string) $view;
           //$arr['new_loc_id'] = $location_obj->id;
           return json_encode($arr);
            exit;
    }


    function ajaxDeleteLocation($id,$customer_id)
    {
         CustomerLocation::find($id)->delete();
        
         CustomerLocationContact::where('customer_location_id',$id)->delete();


         $arr['success'] = 'Location deleted sussessfully';

          $locations = CustomerLocation::with('contacts')->where('customer_id',$customer_id)->get();
           //dd(  $locations );
           $view = view('crm::crm.location.ajax_refresh_locations',compact('locations','customer_id'));
            $arr['html_response'] = (string) $view;
          return json_encode($arr);
        exit;


    }
    

     function ajaxGetLocationsList($cust_id)
    {
        $data['locations'] = CustomerLocation::where('customer_id',$cust_id)->get();
            return json_encode($data);
            exit;
       
    }

     function ajaxAddContact(Request $request)
    {
        $this->validate($request, 
            [
                'f_name' => 'required',
               
                
            ]);
            //dd($request->all());
           $contact_obj =  new CustomerLocationContact;
          
            $contact_obj->f_name = $request->f_name;
            $contact_obj->l_name = $request->l_name;
            $contact_obj->customer_location_id = $request->location_index;
            $contact_obj->email  = $request->email;
            $contact_obj->title  = $request->title;
            $contact_obj->phone  = $request->contact_phone;
            $contact_obj->mobile = $request->contact_mobile;
            if($request->primary_poc)
            $contact_obj->is_poc = 1;
            else
              $contact_obj->is_poc = 0;   
            $contact_obj->save();

            $arr['success'] = 'Contact Added sussessfully';
            return json_encode($arr);
            exit;
    }

    function ajaxLoadServiceItem(Request $request)
    {
        $service_item = CustomerServiceItem::where('id',$request->srvc_item_id)->with(['rates','service_type','billing_period'])->first();

        $service_items = CustomerServiceType::all();

        $hourly = $this->hourly;
        $flate_fee = $this->flate_fee;
        $project = $this->project;

        //$service_type = CustomerServiceType::find($service_item->service_type_id);
      
        $billing_periods = CustomerBillingPeriod::all();
        $service_types = [];
        foreach($service_items as $service_item_obj)
        {
           $service_types[$service_item_obj->id] =$service_item_obj->title;
        }

        $billing_arr = [];
        foreach($billing_periods as $billing_period)
        {
           $billing_arr[$billing_period->id] =$billing_period->title;
        }

       
        //dd($service_item);
       /*$service_item['start_date'] = $service_item_obj->start_date;
        $service_item['end_date'] = $service_item_obj->end_date;
        $service_item['is_active'] = $service_item_obj->is_active;
        $service_item['is_default'] = $service_item_obj->is_default;

      
        $service_item['start_date'] = $service_item_obj->start_date;
        $service_item['start_date'] = $service_item_obj->start_date;
        $service_item['start_date'] = $service_item_obj->start_date;
        $service_item['start_date'] = $service_item_obj->start_date;*/
        $view = view('crm::crm.service_item.ajax_load_service_item',compact('service_item','service_types','hourly','flate_fee','project','billing_arr'))->render();
          //return $view;
            $arr['view_srvc_itm'] = (string) $view;
           //$arr['new_loc_id'] = $location_obj->id;
           return json_encode($arr);
            exit;
        //return $service_item;
    }

    function ajaxUpdateServiceItem(Request $request)
    {
        //dd($request->all());

        $service_items = CustomerServiceType::all();
        $service_types = [];
        foreach($service_items as $service_item)
        {
           $service_types[$service_item->id] =$service_item->title;
        }

        $service_item = CustomerServiceItem::find($request->service_item_id);
        $service_item->service_type_id = $request->service_type_id;
        $service_item->title = $request->service_item_name;
        $service_item->start_date = date( "Y-m-d",strtotime($request->start_date));
        $service_item->end_date = date( "Y-m-d",strtotime($request->end_date));

        $service_item->is_active = $request->service_active;
        if(isset($request->service_default))
        $service_item->is_default = $request->service_default;
        else
        $service_item->is_default =0;

        //if flate fee
        if(strtolower($service_types[$request->service_type_id])==$this->hourly || strtolower($service_types[$request->service_type_id])== $this->flate_fee)
        {
            $service_item->billing_period_id = $request->billing_period_id;
        }

        if(strtolower($service_types[$request->service_type_id])==$this->flate_fee)
        {
            $service_item->unit_price = $request->unit_price;
            $service_item->quantity  = $request->quantity;
        }

        if(strtolower($service_types[$request->service_type_id])==$this->project)
        {
            $service_item->estimate = $request->project_estimate;
            $service_item->estimated_hours = $request->estimated_hours;
            $service_item->bill_for = $request->bill_for;
        }
        //$service_item->save();
        //$service_item->comments = $request->description_invoicing;

         $customer_id = $service_item->customer_id;

        $service_item->save();

        
        CustomerServiceRate::where('customer_service_item_id',$request->service_item_id)->delete();
        //$billing_period->delete();
        //Session::flash('flash_message', 'User successfully deleted!');
      
            $rate = new CustomerServiceRate;
       
            $default_rate_arr     = explode('|',$request->default_rate);
            $default_rate_title   = $default_rate_arr[0];
            $default_rate_amount  = $default_rate_arr[1];

           
            $rate->title = $default_rate_title;
            $rate->amount = $default_rate_amount;
            $rate->is_default = 1;
            $rate->status = 1;
            $service_item->rates()->save($rate);
       
            if($request->additional_rates)
            {
                foreach($request->additional_rates as $additional_rate)
                {
                    $additional_rate_obj = new CustomerServiceRate;

                    $additional_rates_arr = explode('|',$additional_rate);
                    /*$additional_rates[] = ['amount'=>$additional_rates_arr[1],
                                            'title'=>$additional_rates_arr[0]];*/
                    $additional_rate_obj->title = $additional_rates_arr[0];
                    $additional_rate_obj->amount = $additional_rates_arr[1];
                    $additional_rate_obj->status =1;
                    
                    $service_item->rates()->save($additional_rate_obj);
                }
            }
            
      
        $rates = CustomerServiceRate::where('customer_service_item_id',$request->service_item_id)->get();

        
        $service_items = CustomerServiceItem::with(['rates','service_type'])->where('customer_id', $customer_id)->get();
        
        $arr['html_contents'] =  view('crm::crm.service_item.ajax_refresh_service_items',compact('service_items','customer_id'))->render();
        $arr['html_content_rates'] =  view('crm::crm.rate.ajax_refresh_service_item_rates',compact('service_item_id','rates'))->render();

       
        
        $arr['success'] = 'Service Type Updated sussessfully';
        return json_encode($arr);
        exit;
    }

    function ajaxLoadRate($id)
    {
        $rate =  CustomerServiceRate::find($id);

        return json_encode($rate);
        exit;
       

    }

    function ajaxUpdateRate(Request $request)
    {
        $rate = CustomerServiceRate::find($request->rate_id);
       
        $rate->title = $request->title;
        $rate->amount = $request->amount;
        if($request->default)
            $rate->is_default = 1;
        else
            $rate->is_default=0;

        if($request->status)
            $rate->status = 1;
        else
            $rate->status = 0;
        $rate->save();
        $service_item_id = $request->servc_item_id_rate;

        $service_item =  CustomerServiceItem::find($service_item_id);
        $customer_id = $service_item->customer_id;

        $service_items = CustomerServiceItem::with(['rates','service_type'])->where('customer_id', $customer_id)->get();
        
        $arr['html_content_rates'] =  view('crm::crm.rate.ajax_refresh_service_item_rates',compact('service_items'))->render();


         
         $arr['success'] = 'Service Type rate Updated sussessfully';
          
           return json_encode($arr);
        exit;
    }

    function ajaxAddRate(Request $request)
    {

        $service_item_id = $request->servc_item_id_new_rate;
        //dd($service_item_id );
        $rate = new CustomerServiceRate;
       
        $rate->title = $request->title;
        $rate->amount = $request->amount;
        $rate->customer_service_item_id = $service_item_id;
        if($request->default)
        {
            $rate->is_default = 1;
            $change_rate = CustomerServiceRate::where('customer_service_item_id',$service_item_id)->first();
            $change_rate->is_default = 0;
            $change_rate->save();
        }
        else
        {
            $rate->is_default=0;
        }

        if($request->status)
            $rate->status = 1;
        else
            $rate->status = 0;
        $rate->save();
      
      $service_item =  CustomerServiceItem::find($service_item_id);
      $customer_id = $service_item->customer_id;

         $service_items = CustomerServiceItem::with(['rates','service_type'])->where('customer_id', $customer_id)->get();
         //$rates = CustomerServiceRate::where('customer_service_item_id',$service_item_id)->get();
         $arr['success'] = 'Service Type rate Added sussessfully';
          $arr['html_content_rates'] =  view('crm::crm.rate.ajax_refresh_service_item_rates',compact('service_items'))->render();
           return json_encode($arr);
        exit;
    }



    function ajaxLoadNewServiceItem($cust_id)
    {

        $hourly = $this->hourly;
        $flate_fee = $this->flate_fee;
        $project = $this->project;
         $service_types_arr = CustomerServiceType::all();
        $service_types = [];
        foreach($service_types_arr as $service_type_obj)
        {
           $service_types[$service_type_obj->id] =$service_type_obj->title;
        }

       // $view = view('crm::crm.ajax_load_new_service_item',compact('service_types','hourly','flate_fee','project'))->render();
          //return $view;
           // $arr['view_srvc_itm'] = (string) $view;
           //$arr['new_loc_id'] = $location_obj->id;

        $arr['service_types'] = $service_types;
           return json_encode($arr);
            exit;
        //dd($cust_id);

    }

    function ajaxAddServiceItem(Request $request)
    {
            $this->validate($request, 
            [
                'service_type_id' => 'required',
                'default_rate'     =>'required'
               
                
            ]);
        $service_types_data = CustomerServiceType::all();
        $service_types = [];
        foreach($service_types_data as $service_item)
        {
           $service_types[$service_item->id] =$service_item->title;
        }

        $service_item = new CustomerServiceItem;
        $service_item->service_type_id = $request->service_type_id;
        $service_item->title = $request->service_item_name;
        $service_item->start_date = date( "Y-m-d",strtotime($request->start_date));
        $service_item->end_date = date( "Y-m-d",strtotime($request->end_date));

        $service_item->customer_id = $request->customer_id_new_service_item;

        $service_item->is_active = $request->service_active;
        if(isset($request->service_default))
        $service_item->is_default = $request->service_default;
        else
        $service_item->is_default =0;

        //if flate fee
        if(strtolower($service_types[$request->service_type_id])==$this->hourly || strtolower($service_types[$request->service_type_id])== $this->flate_fee)
        {
            $service_item->billing_period_id = $request->billing_period_id;
        }

        if(strtolower($service_types[$request->service_type_id])==$this->flate_fee)
        {
            $service_item->unit_price = $request->unit_price;
            $service_item->quantity  = $request->quantity;
        }

        if(strtolower($service_types[$request->service_type_id])==$this->project)
        {
            $service_item->estimate = $request->project_estimate;
            $service_item->estimated_hours = $request->estimated_hours;
            $service_item->bill_for = $request->bill_for;
        }
        //$service_item->save();
        //$service_item->comments = $request->description_invoicing;
        $service_item->save();

   
       
            $rate = new CustomerServiceRate;
       
            $default_rate_arr     = explode('|',$request->default_rate);
            $default_rate_title   = $default_rate_arr[0];
            $default_rate_amount  = $default_rate_arr[1];

           
            $rate->title = $default_rate_title;
            $rate->amount = $default_rate_amount;
            $rate->is_default = 1;
            $rate->status = 1;
            $service_item->rates()->save($rate);

           if($request->additional_rates)
           {
                foreach($request->additional_rates as $additional_rate)
                {
                    $additional_rate_obj = new CustomerServiceRate;

                    $additional_rates_arr = explode('|',$additional_rate);
                    /*$additional_rates[] = ['amount'=>$additional_rates_arr[1],
                                            'title'=>$additional_rates_arr[0]];*/
                    $additional_rate_obj->title = $additional_rates_arr[0];
                    $additional_rate_obj->amount = $additional_rates_arr[1];
                    $additional_rate_obj->status =1;
                    
                    $service_item->rates()->save($additional_rate_obj);
                }
            }
            
        //$rates = CustomerServiceRate::where('customer_service_item_id',$request->service_item_id)->get();

        // $service_item_data = CustomerServiceItem::find($request->service_item_id);
            $customer_id = $request->customer_id_new_service_item;
         $service_items = CustomerServiceItem::with(['rates','service_type'])->where('customer_id', $request->customer_id_new_service_item)->get();
        //dd($service_items);
        //$service_item_id = $service_item_data->id;

        $arr['html_content_rates'] =  view('crm::crm.rate.ajax_refresh_service_item_rates',compact('service_items'))->render();


        $arr['html_contents'] =  view('crm::crm.service_item.ajax_refresh_service_items',compact('service_items','customer_id'))->render();
        //$arr['service_item_title'] = $service_item_data->title;
        $arr['success'] = 'Service Item added sussessfully';
        return json_encode($arr);
        exit;

    }


    function ajaxDeleteContact($cntct_id)
    {

         $contact = CustomerLocationContact::find($cntct_id);
         $contact->delete();

         $arr['success'] = 'Contact deleted sussessfully';
          return json_encode($arr);
        exit;
    }

    function ajaxDeleteRate($rate_id,$service_item_id)
    {

       
        //dd($service_item_id );
        $rate =  CustomerServiceRate::find($rate_id);
       
        
        $rate->delete();
      

        $service_item =  CustomerServiceItem::find($service_item_id);
        $customer_id = $service_item->customer_id;

         $service_items = CustomerServiceItem::with(['rates','service_type'])->where('customer_id', $customer_id)->get();
         //$rates = CustomerServiceRate::where('customer_service_item_id',$service_item_id)->get();
         $arr['success'] = 'Service Type rate Deleted sussessfully';
          $arr['html_content_rates'] =  view('crm::crm.rate.ajax_refresh_service_item_rates',compact('service_items'))->render();
           return json_encode($arr);

       
        exit;
    }


    function ajaxDeleteServiceItem($s_id,$customer_id)
    {

       
        //dd($service_item_id );
        CustomerServiceItem::where('id',$s_id)->delete();
        CustomerServiceRate::where('customer_service_item_id',$s_id)->delete();
       
       
      
         $service_items = CustomerServiceItem::with(['rates','service_type'])->where('customer_id', $customer_id)->get();
        //dd($service_items);
        //$service_item_id = $service_item_data->id;

        //$arr['html_content_rates'] =  view('crm::crm.ajax_refresh_service_item_rates',compact('service_item_id','rates'))->render();


        $arr['html_contents'] =  view('crm::crm.service_item.ajax_refresh_service_items',compact('service_items','customer_id'))->render();
        //$arr['service_item_title'] = $service_item_data->title;
        $arr['success'] = 'Service Item deleted sussessfully';
        return json_encode($arr);
        exit;
    }

    function ajaxGetServiceItems($c_id)
    {
        $customer = Customer::with(['service_items','locations','service_items.rates','service_items.service_type'])->where('id',$c_id)->first();
        
        $arr['locations'] = $customer->locations;
        $arr['service_items'] = $customer->service_items;

          return json_encode($arr);
        exit;
      
    }
}


