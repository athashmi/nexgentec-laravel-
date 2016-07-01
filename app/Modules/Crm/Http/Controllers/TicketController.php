<?php
namespace App\Modules\Crm\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use App\Modules\Crm\Http\Customer;
use App\Modules\Crm\Http\Employee;

use App\Modules\Crm\Http\Ticket;




use App\Modules\Crm\Http\Attachment;

use App\Modules\Crm\Http\Response;


use App\Services\GoogleGmail;
use App\Services\ImapGmail;

use App\Modules\Crm\Http\CustomerServiceType;
use App\Modules\Crm\Http\CustomerBillingPeriod;
use App\Modules\Crm\Http\CustomerServiceItem;
use App\Modules\Crm\Http\CustomerServiceRate;
use App\Modules\Crm\Http\CustomerLocation;

use App\Modules\Crm\Http\CustomerLocationContact;

use App\Model\Config;

use App\Model\Role;
use App\Model\User;
use Auth;
use Mail;
use URL;

use Datatables;


class TicketController extends Controller
{
    



    public function index()
    {
        //dd(dirname(__FILE__));
       
         return view('crm::ticket.index');
    }
	/*public function index()
	{
       
       
        $tickets = Ticket::with(['responses','assigned_to','entered_by','customer','location','service_item'])->paginate(10);
        //dd($tickets);
      
        return view('crm::ticket.index',compact('tickets'));
	}*/

    public function ajaxDataIndex($id=NULL)
    {
        //$controller = $this->controller;
        $global_date = $this->global_date;

        if($id!='')
            $tickets = Ticket::with(['responses','assigned_to','entered_by','customer','location','service_item','status'])->where('customer_id',$id);

        else
            $tickets = Ticket::with(['responses','assigned_to','entered_by','customer','location','service_item','status']);
       

        return Datatables::of($tickets)


            ->addColumn('action', function ($ticket) {

            $return = '<a href="'.URL::route('admin.ticket.show',$ticket->id).'" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a>
                            
                             
                             <button type="button" class="btn btn-danger btn-sm"
                                  data-toggle="modal" data-id="'.$ticket->id.'" id="modaal" data-target="#modal-delete-ticket">
                                    <i class="fa fa-times-circle"></i>
                                    Delete
                                </button>';
                               
                              
                            
                return $return;
            })
             ->addColumn('created_by', function ($ticket) {
                if($ticket->entered_by) 
                    $return = $ticket->entered_by->f_name;
                elseif($ticket->type =='email')
                    $return = '<button type="button" class="btn bg-gray-active  btn-sm">
                                
                                    <span>system</span>
                                    </button>';
             
            
                return $return;
            })
         ->addColumn('customer_info', function ($ticket) {
                    $return = '<button type="button" class="btn bg-gray-active  btn-sm">
                                
                                    <span>';

                                    if($ticket->customer)
                                   $return .=  '<i class="fa fa-user"></i>'. $ticket->customer->name;
                                elseif($ticket->email)
                                     $return .= '<i class="fa fa-envelope"></i>'.$ticket->email;
                                
                                $return .='</span></button>';
                                if($ticket->location)
                                 $return .= ' <button type="button" class="btn bg-gray-active  btn-sm">
                                  <i class="fa fa-map-marker"></i> 
                                    <span>'.$ticket->location->location_name.'</span>
                                </button>';
                                if($ticket->service_item)
                                $return .= ' <button type="button" class="btn bg-gray-active  btn-sm">
                                  <i class="fa  fa-gears"></i> 
                                    <span>'.$ticket->service_item->title.'</span>
                                </button>';
                            
                             
                    return $return;
            })
            ->addColumn('assigned_to', function ($ticket) {

             //$customer->locations //loop   
             $return = ''; 
                if($ticket->assigned)
                {
                   foreach($ticket->assigned_to as $employee)
                   {
                       $return .= '<button type="button" class="btn bg-gray-active  btn-sm">
                          
                              <i class="fa fa-user"></i>  
                              <span>'.$employee->f_name.'</span>
                          </button>';
                    }
                     
                }
                return $return;
            })
            ->editColumn('created_at', function ($ticket) use ($global_date){

                return  date($global_date,strtotime($ticket->created_at));
            })
            ->editColumn('priority', function ($ticket) {
                  $btn_class = 'bg-gray';
                    if($ticket->priority == 'normal')
                      $btn_class = 'bg-blue';
                    if($ticket->priority == 'high')
                      $btn_class = 'bg-green';
                    if($ticket->priority == 'urgent')
                    $btn_class = 'bg-yellow';
                  if($ticket->priority == 'critical')
                    $btn_class = 'bg-red';
                $return = '<button type="button" class="btn '.$btn_class.'  btn-sm">
                                 
                                    <span>'.$ticket->priority.'</span>
                                </button>';

                  return $return;
            })
            ->editColumn('status', function ($ticket) {
                    $return ='<button type="button" class="btn   btn-sm" style="background-color:'.$ticket->status->color_code.'">
                                 
                                    <span>'.$ticket->status->title.'</span>
                                </button>';
               
             return $return;
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

        $managers_obj =  Role::with('users')->where('name','manager')->orWhere('name','technician')->get();

      // dd($managers_obj);
        $users = [];
        $roles = [];
        //if ($manager->users->count())
        //$managers = $manager->users;
        if($managers_obj->count())
        {
            foreach($managers_obj as $manager_obj) {
                foreach($manager_obj->users as $user) {
                $users[$user->id]=$user->f_name." ".$user->l_name.'('.$manager_obj->name.')';
                //dd($user->id);
            }
        }

        }

       
        return view('crm::ticket.add',compact('customers','users'));
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
                'customer_id' => 'required',
                'title'=>'required',
                'body'=>'required',
               
                
            ]);

       $ticket = new Ticket;
        $ticket->customer_id = $request->customer_id;
        $ticket->location_id= $request->location;
        $ticket->service_item_id= $request->service_item;
        $ticket->title= $request->title;
        $ticket->created_by= Auth::user()->id;
        $ticket->entered_date =   date("Y-m-d");
        $ticket->entered_time =  date('h:i:s');

        $ticket->body= $request->body;
        $ticket->status= 'new';
        $ticket->priority= $request->priority;
        $ticket->save();
        foreach ($request->users as $user) {
            # code...
            if(!$user=='')
            $ticket->assigned_to()->attach($user);
        }
     //$customer->service_items()->save($service_item);

        return redirect()->intended('admin/crm/ticket'); 
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

       // $ticket = Ticket::where('id',$id)->with(['responses','assigned_to','attachments','entered_by','customer','location','service_item','responses.responder'])->first();
       
       $ticket = Ticket::where('id',$id)->with(['assigned_to','attachments','entered_by','customer','location','service_item'])->first();
       $responses_result= Response::where('ticket_id',$id)->with(['responder'])->orderBy('entered_date','asc')->orderBy('entered_time','asc')->get();
      
       $responses = [];
       foreach ($responses_result as  $response) {
         //dd(\DateTime::getTimezone($response->entered_date));
            $responses[$response->entered_date][] = $response; 
           # code...
       }
      // $responses = $responses_customer->merge($responses_employee);

        //dd($tickets[0]->created_by);
      //dd($ticket);
         $managers_obj =  Role::with('users')->where('name','manager')->orWhere('name','technician')->get();

      // dd($managers_obj);
        $users = [];
        $roles = [];
        //if ($manager->users->count())
        //$managers = $manager->users;
        if($managers_obj->count())
        {
            foreach($managers_obj as $manager_obj) {
                foreach($manager_obj->users as $user) {
                $users[$user->email]=$user->f_name." ".$user->l_name.' ('.$manager_obj->name.')';
                //dd($user->id);
                }
            }

        }
         $assigned_users = [];
         //dd($ticket->assigned_to);
        foreach($ticket->assigned_to as $assigned) {
               
                $assigned_users[]=$assigned->email;
                //dd($user->id);
               
            }

       $customers_records = Customer::where('is_active',1)->get();
       $customers = [];
       foreach ($customers_records as $customer) {
          $customers[$customer->id]=$customer->name.' <'.$customer->email_domain.'>';
       }
        //dd($assigned_users);
       $customer_assigned = '';
       if($ticket->customer)
        $customer_assigned = $ticket->customer->id;

        $tickets = [];
        $tickets_ = Ticket::where('id','<>',$id)->get();
       // dd($tickets_);
        foreach ($tickets_ as $ticket_) {
            $tickets[$ticket_->id] = $ticket_->id.'. '.$ticket_->title;
        }
        return view('crm::ticket.show',compact('ticket','users','assigned_users','responses','customers','customer_assigned','tickets'));
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
        $ticket = Ticket::where('id',$id)->with(['responses','assigned_to','attachments','entered_by','customer','location','service_item','responses.responder'])->first();

        $ticket->responses()->delete();
        $ticket->attachments()->delete();
         $ticket->assigned_to()->delete();

      
       

       $ticket->delete();
        //Session::flash('flash_message', 'User successfully deleted!');
        return redirect()->intended('admin/crm/ticket');
    }

  
   

     function addResponse(Request $request)
     {
         if($request->original_ticket !='')
             $original_ticket_record =  Ticket::where('id',$request->original_ticket)->first();
      
        
        $site_path = URL::to('/');
            //dd($request->all());
            $pattern = '/\/ckfinder/';
            $replacement = $site_path.'/ckfinder';
            $body = $request->body;
            //dd($original_ticket_record);
            if($request->original_ticket !='')
            {
               // dd('ff');
                $body .= '<p>Its duplicate of  <a href="'.URL::route('admin.ticket.show',$request->original_ticket).'">'.$original_ticket_record->title.'</a>';
            }
//dd($body);
             //preg_match( $pattern, $body, $output_array);
            //dd($output_array);

            $response_body = preg_replace($pattern, $replacement, $body);
            //src="/ckfinder
            //dd($vv);
            $flag = $request->response_flag;
            $response = new Response;
            $response->ticket_id = $request->ticket_id;
            $response->body = htmlentities($response_body);
            $response->responder_id = Auth::user()->id;
            $response->entered_date =   date("Y-m-d");
            $response->entered_time =  date('h:i:s');
            if($flag == 'note')
                $response->response_type =  'note';

            $response->save();

           /* $responses_ = Response::with(['responder'])->where('ticket_id',$request->ticket_id)->orderBy('created_at', 'desc')->get();
            $responses =[];
            foreach ($responses_ as $response) {

                $responses[]=['name'=>$response->responder->f_name,
                              'body'=>html_entity_decode($response->body),
                              'response_time' => date('d/m/Y  h:i A',strtotime($response->created_at))
                              ];

               }*/
            $ticket = Ticket::where('id',$request->ticket_id)->with(['assigned_to','attachments','entered_by','customer','location','service_item'])->first();
             if($request->original_ticket !='')
             {
                $ticket->status =  'closed';
                $ticket->save();
            }

            $responses_result= Response::where('ticket_id',$request->ticket_id)->with(['responder'])->orderBy('entered_date','asc')->get();
      
               $responses = [];
               foreach ($responses_result as  $response) {

                    $responses[$response->entered_date][] = $response; 
                   # code...
               }
            $arr['success'] = 'Response Added successfully';
            //$arr['responses'] = $responses;


            //$ticket = Ticket::find($request->ticket_id);

            $smtp_arr = Config::where('title','smtp')->get();
       
            $smtp =[];
            foreach ($smtp_arr as $value) {
                if($value->key=='server_address')
                    $server_address = $value->value;
                if($value->key=='gmail_address')
                    $gmail_address = $value->value;
                if($value->key=='gmail_password')
                    $password = $value->value;
                if($value->key=='port')
                    $port= $value->value;
            }

            config(['mail.driver' => 'smtp',
                    'mail.host' => $server_address,
                    'mail.port' => $port,
                    'mail.encryption' => 'ssl',
                    'mail.username' => $gmail_address,
                    'mail.password' => $password]);
            $bcc =[];
            $cc = [];
            if($flag =='reply')
            {
                $bcc = $request->bcc;
                $cc = $request->cc;
            }

            if($ticket->type=='email' && $ticket->email!='' && $flag =='reply')
            {

                 Mail::send('crm::ticket.email.response', array('firstname'=>$ticket->sender_name,'body'=>$response_body), function($message) use ($ticket,$gmail_address,$response,$bcc,$cc){

                   /* $swiftMessage = $message->getSwiftMessage();
                    $headers = $swiftMessage->getHeaders();
                    $headers->addTextHeader('In-Reply-To', $ticket->gmail_msg_id);
                    $headers->addTextHeader('References', $ticket->gmail_msg_id);*/


                    $message->getHeaders()->addTextHeader('In-Reply-To', $ticket->gmail_msg_id);
                    $message->getHeaders()->addTextHeader('References', $ticket->gmail_msg_id);
                    $message->getHeaders()->addTextHeader('response_id', $response->id);
                    if(count($bcc)>0)
                    {
                        foreach ($bcc as $key => $bcc_email) {
                          $message->bcc($bcc_email, $name = null);
                        }
                    }
                    if(count($cc)>0)
                    {
                        foreach ($cc as $key => $cc_email) {
                          $message->cc($cc_email, $name = null);
                        }
                    }
                    
                    
                    //$headers->addTextHeader('References', $ticket->gmail_msg_id);
                    $message->to($ticket->email,$ticket->sender_name)->subject($ticket->title)->from($gmail_address,Auth::user()->f_name.' '.Auth::user()->l_name);
                });
            }

             $view = view('crm::ticket.ajax_ticket_timeline',compact('ticket','responses'));
            $arr['html_content'] = (string) $view;
            return json_encode($arr);
            exit;
            //dd($responses);
            //return 
     }

   
     function ajaxAssignCustomer(Request $request)
     {
          $this->validate($request, 
            [
                'customer' => 'required',
                
                
            ]);

          $ticket = Ticket::find($request->id);
        $ticket->customer_id = $request->customer;
        //$ticket->location_id= $request->location;
        //$ticket->service_item_id= $request->service_item;
        //$ticket->title= $request->title;
        //$ticket->created_by= Auth::user()->id;
        //$ticket->body= $request->body;
        //$ticket->status= 'new';
        //$ticket->priority= $request->priority;
        $ticket->save();

        $ticket_ = Ticket::where('id',$request->id)->with(['customer'])->first();

       

      


        //dd($ticket_);
        $arr['success'] = 'Customer assigned to ticket sussessfully';
        $arr['customer_assigned'] =  $ticket_->customer->name.' <'.$ticket_->customer->email_domain.'>';
        $arr['ticket_id'] =  $request->id;
        return json_encode($arr);

       
        exit;
        


     }
    function ajaxAssignUsers(Request $request)
    {
        //dd($request->all());
        $this->validate($request, 
            [
                'users' => 'required',
                
                
            ]);

        $ticket = Ticket::find($request->id);
        //$ticket->customer_id = $request->customer_id;
        //$ticket->location_id= $request->location;
        //$ticket->service_item_id= $request->service_item;
        //$ticket->title= $request->title;
        //$ticket->created_by= Auth::user()->id;
        //$ticket->body= $request->body;
        //$ticket->status= 'new';
        //$ticket->priority= $request->priority;
        $ticket->save();
        $ticket->assigned_to()->detach();
        foreach ($request->users as $user) {
            # code...
            if(!$user=='')
            {
                $ticket->assigned_to()->attach($user);
            }
        }
        //$customer->service_items()->save($service_item);

        //return redirect()->intended('admin/crm/ticket'); 
        $ticket_ = Ticket::where('id',$request->id)->with(['assigned_to'])->first();

        $managers_obj =  Role::with('users')->where('name','manager')->orWhere('name','technician')->get();

      // dd($ticket_->assigned_to);
        $users = [];
        if($managers_obj->count())
        {
            foreach($managers_obj as $manager_obj) {
                foreach($manager_obj->users as $user) {
                    //if($user->id == )
                $users[$user->id]=$user->f_name." ".$user->l_name.' ('.$manager_obj->name.')';
                //dd($user->id);
            }
        }

        }

        $assigned_users = [];

        if($ticket_->assigned_to->count()!=0)
        {
            foreach($ticket_->assigned_to as $key=>$assigned) {
               
                //dd($assigned); 
                $assigned_users[$assigned->id]=$users[$assigned->id];
               
        }

        }


        //dd($ticket_);
        $arr['success'] = 'Assigned Users to ticket sussessfully';
        $arr['assigned_users'] =  $assigned_users;
        $arr['ticket_id'] =  $request->id;
        return json_encode($arr);

       
        exit;
      
    }


    function ajaxUpdateStatusPriority(Request $request)
    {
       // dd($request->all());
         $ticket_ = Ticket::find($request->id);
        //$ticket->customer_id = $request->customer_id;
        //$ticket->location_id= $request->location;
        //$ticket->service_item_id= $request->service_item;
        //$ticket->title= $request->title;
        //$ticket->created_by= Auth::user()->id;
        //$ticket->body= $request->body;
        $ticket_->status= $request->status;
        $ticket_->priority= $request->priority;
        $ticket_->save();

         $ticket = Ticket::where('id',$request->id)->first();
        $btn_class =  '';
        if($ticket->priority == 'low')
          $btn_class = 'bg-gray';
        if($ticket->priority == 'normal')
          $btn_class = 'bg-blue';
        if($ticket->priority == 'high')
          $btn_class = 'bg-green';
        if($ticket->priority == 'urgent')
          $btn_class = 'bg-yellow';
        if($ticket->priority == 'critical')
          $btn_class = 'bg-red';
        
         $arr['success'] = 'Changed status/priority sussessfully';
         $arr['btn_class_priority'] =  $btn_class;
         $arr['ticket'] =  $ticket;
         $arr['ticket_id'] =  $request->id;
        return json_encode($arr);

       
        exit;

    }

    function ajaxDeleteAssignedUser($t_id,$u_id)
    {
             $ticket = Ticket::find($t_id);
              $ticket->assigned_to()->detach([$u_id]);

             $ticket_ = Ticket::where('id',$t_id)->with(['assigned_to'])->first();

                $managers_obj =  Role::with('users')->where('name','manager')->orWhere('name','technician')->get();

              // dd($ticket_->assigned_to);
                $users = [];
                if($managers_obj->count())
                {
                    foreach($managers_obj as $manager_obj) {
                        foreach($manager_obj->users as $user) {
                            //if($user->id == )
                        $users[$user->id]=$user->f_name." ".$user->l_name.' ('.$manager_obj->name.')';
                        //dd($user->id);
                    }
                }

                }

                $assigned_users = [];

                if($ticket_->assigned_to->count()!=0)
                {
                    foreach($ticket_->assigned_to as $key=>$assigned) {
                       
                        //dd($assigned); 
                        $assigned_users[$assigned->id]=$users[$assigned->id];
                       
                }

                }


                //dd($ticket_);
                $arr['success'] = 'Employee successfully detached';
                $arr['assigned_users'] =  $assigned_users;
                $arr['ticket_id'] =  $t_id;
                return json_encode($arr); 
    }

    function ajaxDeleteAssignedCustomer($t_id)
    {
         $ticket = Ticket::find($t_id);
        $ticket->customer_id = 0;
        $ticket->save();

         $ticket_ = Ticket::where('id',$t_id)->with(['customer'])->first();

      
        //dd($ticket_);
        $arr['success'] = 'Customer detached from ticket sussessfully';
        $arr['customer_assigned'] =  '';
        $arr['ticket_id'] =  $t_id;
        return json_encode($arr);

       
        exit;
    }

     function readGmail()
     {

       

        //dd(url('/'));
        //$gmail = new GoogleGmail();
        //$gmail = new ImapGmail();
        //$emails = $gmail->getMessages();
        // $emails = $gmail->getThread();

         $gmail = new GoogleGmail();
        //$emails = $gmail->getMessages();0
         $threads = $gmail->getThreads();
         
      //dd($threads);

       
    foreach ($threads as $key => $thread) 
    {
        foreach ($thread as  $email) 
        {
            $body =$email['body'];
            if($key==$email['messageId'])
            {
                $chk_ticket = Ticket::where('gmail_msg_id',$email['gmail_msg_id'])->first();
                if(!$chk_ticket)
                {   
                    $customer_email = $email['messageSenderEmail'];
                    
                    $customer = Customer::where('email_domain',$customer_email)->first();
                    //dd($customer);
                    if($customer)
                    {
                        $customer_id = $customer->id;
                    }
                    
                    $ticket = new Ticket;
                    if($customer)
                      $ticket->customer_id = $customer_id;//$request->customer_id;
                    else
                    {
                        $ticket->email = $customer_email;
                        $ticket->sender_name = $email['messageSender'];
                    }
                    //$ticket->location_id= $request->location;
                    //$ticket->service_item_id= $request->service_item;

                    $ticket->gmail_msg_id = $email['gmail_msg_id'];

                    $ticket->entered_date=  date('Y-m-d',strtotime($email['revceived_date']));
                    $ticket->entered_time = date('h:i:s',strtotime($email['revceived_date']));
               
                    $ticket->title= $email['title'];
                    //$ticket->created_by= 4;//Auth::user()->id;
                    $ticket->body= $body;
                     $ticket->type= 'email';

                     $ticket->thread_id= $key;
                     

                    $ticket->status= 'new';
                    $ticket->priority= 'low';
                     $ticket->save();
                     $ticket_id  = $ticket->id;
                    if($email['attachments'])
                    {
                        foreach ($email['attachments'] as $attachment) {
                           // $body .= urlencode('<a href="'.url('/')."/attachments/$attachment".'"  data-lightbox="$attachment"><img src="'.url('/')."/attachments/$attachment".'" /> </a>');

                            $new_attachment = new Attachment;
                            $new_attachment->name = $attachment['name'];
                            $new_attachment->type = $attachment['mime_type'];
                            $ticket->attachments()->save($new_attachment);


                        }
                        
                    }
                }
            }
            else
            {
                if(!$chk_ticket) 
                 $ticket_id = $ticket_id;
                else
                    $ticket_id = $chk_ticket->id;
                //check if gmial_msg_id exist, it means its customer earlier reply/response to our/employee reponse.
                $check_response_already_exist = Response::where('gmail_msg_id',$email['gmail_msg_id'])->first();
                if(!$check_response_already_exist)
                {
                    //check if response_id exist, it means that its response and already exist in database.
                    $chk_reponse_by_id = Response::find($email['response_id']);
                    if(!$chk_reponse_by_id)
                    {

                        $_ticket = Ticket::where('thread_id',$key)->first();
                        $_ticket->status='open';
                        $_ticket->save();
                        $response = new Response;
                        $response->ticket_id = $ticket_id;
                        $response->body =  $body;
                        $response->sender_type = 'customer';
                        $response->entered_date = date('Y-m-d',strtotime($email['revceived_date']));
                        $response->entered_time = date(' h:i:s',strtotime($email['revceived_date']));

                        $response->gmail_msg_id = $email['gmail_msg_id'];
                        $response->save();
                    } 
                }

            }
        }
    }
         $arr['success'] = 'Tickets added sussessfully from email';
          //$arr['html_content_rates'] =  view('crm::crm.rate.ajax_refresh_service_item_rates',compact('service_items'))->render();
           return json_encode($arr);
        exit; 
     }
}


