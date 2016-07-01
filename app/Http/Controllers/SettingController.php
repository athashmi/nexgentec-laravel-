<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\GoogleGmail;

use App\Model\Config;
use App\Modules\Crm\Http\Zoho;

use App\Modules\Employee\Http\Employee;
use App\Model\User;

use Auth;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index()
    {
       $user = \Auth::user();
         // dd($user);      
        return view('admin.setting.index',compact('user'));

    }
    public function imap()
    {
        $imap = Config::where('title','imap')->get();
        //dd($imap);
        $imap_email ='';
        $imap_password = '';
        foreach ($imap as $value) {
            if($value->key=='email')
                $imap_email = $value->value;
             if($value->key=='password')
                $imap_password = $value->value;
        }
        //dd($imap_email);
        //return view('admin.config.imap',compact('imap_email','imap_password'));
        $arr['imap_email'] = $imap_email;
        $arr['imap_password'] = $imap_password;
        return $arr;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function imapStore(Request $request)
    {
         $this->validate($request, 
            [
                'gmail_email' => 'required',
                'gmail_password'=>'required',
               
               
                
            ]);

       
            $imap =  Config::where('key','email')->first();
            $imap->value  = $request->gmail_email;
            $imap->save();
       
            $imap =  Config::where('key','password')->first();
            $imap->value  = $request->gmail_password;
            $imap->save();
           
     
               $arr['success'] = 'IMAP credentials updated successfully';
       //$arr['imap_password'] = $imap_password;
        return $arr;
       
         //return redirect()->intended('admin/config/imap')->with('success', 'Gmail credentials updated Successfully!');
    }

    public function smtp()
    {
        $smtp_arr = Config::where('title','smtp')->get();
       
        $smtp =[];
        foreach ($smtp_arr as $value) {
            if($value->key=='server_address')
                $smtp['server_address'] = $value->value;
            if($value->key=='gmail_address')
                $smtp['gmail_address'] = $value->value;
            if($value->key=='gmail_password')
                $smtp['password'] = $value->value;
            if($value->key=='port')
                $smtp['port'] = $value->value;
        }
        //dd($imap_email);
       // return view('admin.config.smtp',compact('smtp'));


        return $smtp;
    }

     public function smtpStore(Request $request)
    {
        //dd($request->all());
         $this->validate($request, 
            [
                'server_address' => 'required',
                'smtp_address'=>'required',
                'smtp_password' => 'required',
                'smtp_port'=>'required',
               
               
                
            ]);

       
            $smtp =  Config::where('key','server_address')->first();
            $smtp->value  = $request->server_address;
            $smtp->save();
       
            $smtp =  Config::where('key','gmail_address')->first();
            $smtp->value  = $request->smtp_address;
            $smtp->save();

            $smtp =  Config::where('key','password')->first();
            $smtp->value  = $request->smtp_password;
            $smtp->save();

            $smtp =  Config::where('key','port')->first();
            $smtp->value  = $request->smtp_port;
            $smtp->save();
     
             $arr['success'] = 'SMTP credentials updated successfully';
       //$arr['imap_password'] = $imap_password;
        return $arr;
       
        // return redirect()->intended('admin/config/smtp')->with('success', 'SMTP Gmail credentials updated Successfully!');
    }
    
    function updateEmailData(Request $request)
    {
        //dd($request->all());

        $employee = User::find(Auth::user()->id);

        $employee->signature = $request->signature;
        $employee->save();
       // if()

        $intro_email = Config::where('title','intro_email')->first();
        $intro_email->value = $request->intro;

        $intro_email->save();

        $arr['success'] = 'Email data updated successfully';
        return json_encode($arr);
        exit;
    }


     function updateDateTime(Request $request)
    {
        //dd($request->all());

        if($request->date_format)
        {
            $date = Config::where('title','date_format')->first();
            if($date)
            {
                //dd('jj');
                $date_format_arr = explode('|',$request->date_format);
                $date_format_key = $date_format_arr[1];
                $date_format_value = $date_format_arr[0];
                $date->key =  $date_format_key ;
                $date->value = $date_format_value ;
                 $date->save();
            }
            else
            {
                 $date_format_arr = explode('|',$request->date_format);
                $date_format_key = $date_format_arr[1];
                $date_format_value = $date_format_arr[0];

                $date = new Config;
                $date->title = 'date_format';
                $date->value = $date_format_value;
                $date->key  = $date_format_key;
                $date->save();
            }
        }

         if($request->time_format)
         {
            $time = Config::where('title','time_format')->first();
            if($time)
            {
                $time->value = $request->time_format;
                $time->save();
            }
            else
            {
                $time = new Config;
                $time->title = 'time_format';
                $time->value = $request->time_format;
                $time->key = 'time_format';
                $time->save();
            }
         }

        //$intro_email->save();

        $arr['success'] = 'Date/Time format updated successfully';
        return json_encode($arr);
        exit;
    }
    
     public function getDateTime()
    {
        $date = Config::where('title','date_format')->first();
        $time = Config::where('title','time_format')->first();

         
                $arr['config_date'] = $date->value.'|'.$date->key;
                 $arr['config_time'] = $time->value;

             return json_encode($arr);
        exit;    
    }

     function getEmailData()
    {

        $employee = User::find(Auth::user()->id);
    

         $arr['signature'] = $employee->signature;

         $intro_email = Config::where('title','intro_email')->first();
        
          $arr['intro_email'] = $intro_email->value;


        return json_encode($arr);
        exit;
    }

    function gmailApiUpdate(Request $request)
    {

         $this->validate($request, 
            [
                'gmail_auth_client_id' => 'required',
                'gmail_auth_client_secret'=>'required',

               
               
                
            ]);
 //$gmail = new GoogleGmail('new');
            $file_path = base_path('resources/assets');

            $file['client_id'] = $request->gmail_auth_client_id;
            $file['client_secret'] = $request->gmail_auth_client_secret;
            $file['redirect_uris'] = [\URL::route('get_token')];
            $str_to_json['web']= $file;
           // dd($file);
//dd($file_path."client_secret.json");
           try
              {
                //file_put_contents($file_path."client_secret.json",  json_encode($file);

                        $myfile = fopen($file_path."/client_secret.json", "w") or die("Unable to open file!");

                        
                        fwrite($myfile, json_encode($str_to_json,JSON_UNESCAPED_SLASHES));
                        
                        
                        fclose($myfile);
            }
               catch (Exception $e) {
                        echo 'Caught exception: ',  $e->getMessage(), "\n";
               }


             $gmail = new GoogleGmail('reset');

            //dd($response);
               return compact("gmail");

           // dd('done');

    }

    function getToken(Request $request)
    {
        $code = $request->all();
        //dd($request->all());

        $token = $code['code'].'#';

        $set = new GoogleGmail('token_rest',$token);
if($set)
        dd('credentials updated successfully');
        //dd( $token);

    }
    
}
