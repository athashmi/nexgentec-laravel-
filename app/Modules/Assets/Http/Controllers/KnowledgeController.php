<?php
namespace App\Modules\Assets\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Crm\Http\Customer;
use App\Modules\Crm\Http\CustomerLocation;
use App\Modules\Assets\Http\Asset;

use App\Modules\Assets\Http\KnowledgePassword;
use App\Modules\Assets\Http\KnowledgeProcedure;
use App\Modules\Assets\Http\KnowledgeSerialNumber;

use Datatables;

use App\Model\Role;
use App\Model\User;
use Auth;
use Mail;
use URL;
class KnowledgeController extends Controller
{

	public function index()
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


        return view('assets::knowledge.index',compact('customers'));
		//return "Controller Index";
	}
	function passwordsIndex($id=Null)
	{
		$global_date = $this->global_date;

        if($id!='')
            $passwords = KnowledgePassword::with(['customer'])->where('customer_id',$id);
        else
		  $passwords = KnowledgePassword::with(['customer']);

//dd($assets);
		return Datatables::of($passwords)


				->addColumn('action', function ($password) {

				$return = '<button type="button" class="btn btn-primary btn-sm"
						 data-toggle="modal" data-id="'.$password->id.'" id="modaal" data-target="#modal-edit-knowledge-pass">
							 <i class="fa fa-pencil"></i> Edit
					 </button>

					 <button type="button" class="btn btn-danger btn-sm"
															data-toggle="modal" data-id="'.$password->id.'" id="modaal" data-target="#modal-delete-pass">
																<i class="fa fa-times-circle"></i>
																Delete
														</button>';



						return $return;
				})
				->addColumn('customer',function ($password){
                    if($password->customer)
                    {
				        return '<button class="btn bg-gray-active  btn-sm" type="button">
                            <i class="fa fa-user"></i>
                                <span>'.$password->customer->name.'</span>
                            </button>';
                    }
                    else
                    {
                        return '<button class="btn bg-gray-active  btn-sm" type="button">
                            <i class="fa fa-user"></i>
                                <span></span>
                            </button>';
                    }
				})
				->editColumn('created_at', function ($password) use ($global_date){

						return  date($global_date,strtotime($password->created_at));
				})
				  ->make(true);
	}


	function proceduresIndex($id=Null)
	{
		$global_date = $this->global_date;

        if($id!='')
            $procedures = KnowledgeProcedure::with(['customer'])->where('customer_id',$id);
        else
		  $procedures = KnowledgeProcedure::with(['customer']);


		return Datatables::of($procedures)


				->addColumn('action', function ($procedure) {

				$return = '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-id="'.$procedure->id.'" id="modaal" data-target="#modal-edit-knowledge-procedure">
							 <i class="fa fa-pencil"></i> Edit
					 </button>
				<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-id="'.$procedure->id.'" id="modaal" data-target="#modal-show-knowledge" data-type="procedure">
							 <i class="fa fa-eye"></i> View
					 </button>
					 <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-id="'.$procedure->id.'" id="modaal" data-target="#modal-delete-procedure">
                                <i class="fa fa-times-circle"></i> Delete
														</button>';



						return $return;
				})
				->editColumn('created_at', function ($procedure) use ($global_date){

						return  date($global_date,strtotime($procedure->created_at));
				})
				->addColumn('customer',function ($procedure){

                    if($procedure->customer)
                    {
				        return '<button class="btn bg-gray-active  btn-sm" type="button">
                            <i class="fa fa-user"></i>
                                <span>'.$procedure->customer->name.'</span>
                            </button>';
                    }
                    else
                    {
                        return '<button class="btn bg-gray-active  btn-sm" type="button">
                            <i class="fa fa-user"></i>
                                <span></span>
                            </button>';
                    }
				})
					->make(true);
	}


	function serialnumberIndex($id=Null)
	{
		$global_date = $this->global_date;

        if($id!='')
           $serial_numbers = KnowledgeSerialNumber::with(['customer'])->where('customer_id',$id);
        else
		$serial_numbers = KnowledgeSerialNumber::with(['customer']);


		return Datatables::of($serial_numbers)


				->addColumn('action', function ($serial_number) {

				$return = '<button type="button" class="btn btn-primary btn-sm"	 data-toggle="modal" data-id="'.$serial_number->id.'" id="modaal" data-target="#modal-edit-serial-number">
							 <i class="fa fa-pencil"></i> Edit
					 </button>

				<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-id="'.$serial_number->id.'" id="modaal" data-target="#modal-show-knowledge" data-type="serial_number">
							 <i class="fa fa-eye"></i> View
					 </button>
				<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-id="'.$serial_number->id.'" id="modaal" data-target="#modal-delete-serial-number">
						<i class="fa fa-times-circle"></i> Delete
				</button>';

						return $return;
				})
				->editColumn('created_at', function ($serial_number) use ($global_date){

						return  date($global_date,strtotime($serial_number->created_at));
				})
				->addColumn('customer',function ($serial_number){

                     if($serial_number->customer)
                     {
				            return '<button class="btn bg-gray-active  btn-sm" type="button">
                            <i class="fa fa-user"></i>
                                <span>'.$serial_number->customer->name.'</span>
                            </button>';
                    }
                    else
                    {
                        return '<button class="btn bg-gray-active  btn-sm" type="button">
                            <i class="fa fa-user"></i>
                                <span></span>
                            </button>';
                    }
				})
					->make(true);
	}



    public function storePassword(Request $request)
    {
			//dd($request->all());
			$this->validate($request,
				 [
				    'system' => 'required',
                    'login' => 'required',
					'password' => 'required',


				 ]);
                    $password = new KnowledgePassword();
                    $password->system = $request->system;
                    if($request->customer)
                    $password->customer_id = $request->customer;
				    $password->login = $request->login;
                    $password->password = $request->password;
					$password->notes = $request->notes;

                    $password->save();
                    $arr['success'] = 'Password added sussessfully';
            return json_encode($arr);
            exit;



    }

	public function editPassword($id)
    {
  		$password = KnowledgePassword::with(['customer'])->where('id',$id)->first();
        $arr['password'] = $password;
        return json_encode($arr);
        exit;



    }


     public function updatePassword(Request $request)
    {
            //dd($request->all());
        $id = $request->id;
            $this->validate($request,
                 [
                    'system' => 'required',
                    'login' => 'required',
                    'password' => 'required',


                 ]);

                    $password = KnowledgePassword::find($id);
                    $password->system = $request->system;
                    if($request->customer)
                    $password->customer_id = $request->customer;
                    $password->login = $request->login;
                    $password->password = $request->password;
                    $password->notes = $request->notes;

                     $password->save();
                     $arr['success'] = 'Password added sussessfully';
            return json_encode($arr);
            exit;



    }


     public function storeProcedure(Request $request)
    {
            //dd($request->all());
            $this->validate($request,
                 [
                    'title' => 'required',             
                 ]);
                    $procedure = new KnowledgeProcedure();
                    $procedure->title = $request->title;
                    if($request->customer)
                    $procedure->customer_id = $request->customer;
                    $procedure->procedure = $request->procedure;
                   

                    $procedure->save();
                    $arr['success'] = 'Procedure added sussessfully';
            return json_encode($arr);
            exit;



    }

    public function editProcedure($id)
    {
        $procedure = KnowledgeProcedure::with(['customer'])->where('id',$id)->first();
        $arr['procedure'] = $procedure;
        return json_encode($arr);
        exit;



    }

      public function updateProcedure(Request $request)
    {
        $id = $request->id;
            //dd($request->all());
            $this->validate($request,
                 [
                    'title' => 'required',
                ]);
                    $procedure = KnowledgeProcedure::find($id);
                    $procedure->title = $request->title;
                    $procedure->customer_id = $request->customer;
                    $procedure->procedure = $request->procedure;
                   

                    $procedure->save();
                    $arr['success'] = 'Procedure updated sussessfully';
            return json_encode($arr);
            exit;
    }

  public function storeSerialNumber(Request $request)
    {
        //dd($request->all());
        $this->validate($request,
             [
                'title' => 'required',
                'serial_number' => 'required'
            ]);
                $password = new KnowledgeSerialNumber();
                $password->title = $request->title;
                if($request->customer)
                $password->customer_id = $request->customer;
                $password->serial_number = $request->serial_number;
                
                $password->notes = $request->notes;

                $password->save();
                $arr['success'] = 'Serial number added sussessfully';
        return json_encode($arr);
        exit;
    }
    public function editSerialNumber($id)
    {
        $serial_number = KnowledgeSerialNumber::with(['customer'])->where('id',$id)->first();
        $arr['serial_number'] = $serial_number;
        return json_encode($arr);
        exit;



    }

    public function updateSerialNumber(Request $request)
    {
        $id = $request->id;
            //dd($request->all());
            $this->validate($request,
                 [
                    'title' => 'required',
                    'serial_number' => 'required'
                ]);
                    $password = KnowledgeSerialNumber::find($id);
                    $password->title = $request->title;
                    if($request->customer)
                    $password->customer_id = $request->customer;
                    $password->serial_number = $request->serial_number;
                    
                    $password->notes = $request->notes;

                    $password->save();
                    $arr['success'] = 'Serial number updated sussessfully';
            return json_encode($arr);
            exit;



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($type,$id)
    {
        if($type=='procedure')
        {
            $procedure = KnowledgeProcedure::with(['customer'])->where('id',$id)->first();
            $type = 'procedure';
            $arr['html_content'] =  view('assets::knowledge.show_partial',compact('procedure','type'))->render();
            //$arr['content'] = $procedure;
            $arr['type'] =  $type;

        }
           
        if($type=='serial_number')
        {
            $serial_number = KnowledgeSerialNumber::with(['customer'])->where('id',$id)->first();
            $type = 'serial_number';
            $arr['html_content'] =  view('assets::knowledge.show_partial',compact('serial_number','type'))->render();
            //$arr['content'] = $serial_number;
            $arr['type'] = $type;

        }
				 return json_encode($arr);
			exit;

        //
    }


    public function deletePassword($id)
    {
        //
         $password = KnowledgePassword::find($id);
         $password->delete();
         $arr['success'] = 'Password deleted sussessfully';
            return json_encode($arr);
            exit;

    }


    public function deleteProcedure($id)
    {
        //
         $procedure = KnowledgeProcedure::find($id);
         $procedure->delete();
         $arr['success'] = 'Procedure deleted sussessfully';
            return json_encode($arr);
            exit;

    }

     public function deleteSerialNumber($id)
    {
        //
         $serial_number = KnowledgeSerialNumber::find($id);
         $serial_number->delete();
         $arr['success'] = 'Serial number deleted sussessfully';
            return json_encode($arr);
            exit;

    }

}
