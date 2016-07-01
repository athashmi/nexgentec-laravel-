<?php
namespace App\Modules\Crm\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\Controller;
use App\Modules\Crm\Http\Customer;
use App\Modules\Crm\Http\CustomerServiceType;
use App\Modules\Crm\Http\CustomerBillingPeriod;
use App\Modules\Crm\Http\CustomerServiceItem;
use App\Modules\Crm\Http\CustomerServiceRate;
use App\Modules\Crm\Http\CustomerLocation;

use App\Modules\Crm\Http\CustomerLocationContact;
use App\Modules\Crm\Http\Zoho;
use App\Model\Role;
use App\Model\User;
use Auth;


class ZohoController extends Controller
{

    function ajaxExportContact($id)
    {
         $customer_data = Customer::with(['locations','locations.contacts'])->where('id',$id)->first();

       //dd($customer_data->locations);

         $contacts = [];


         $billing_address = [];
         foreach ($customer_data->locations as $location)
            {
                if($location->default)
                {
                    $billing_address = [
                        "address" => $location->address,
                        "city" => $location->city,
                        "state" => $location->state,
                        "zip" => $location->zip,
                        "country" => $location->country];
                }

                foreach ($location->contacts as $contact)
                {
                    $contacts[] = [
                              "first_name"=>$contact->f_name,
                              "last_name"=>$contact->l_name,
                              "email"=>$contact->email,
                              "phone"=>$contact->phone,
                              "mobile"=>$contact->mobile,
                              "is_primary_contact"=>($contact->is_poc)?true:''];
                }
            }
            $zoho = Zoho::first();

                $ch = curl_init();

                $post["contact_name"]= $customer_data->name;
                $post["company_name"]= $customer_data->email_domain;
                ///$post["payment_terms_label"]= "Net 15";
                //$post["currency_id"]= "460000000000097";
                //$post["website"]= "www.bowmanfurniture.com";

                $post['contact_persons'] = $contacts;
                $post['billing_address'] = $billing_address;

                $data = array(
                'authtoken' => $zoho->auth_token,
                'JSONString' => json_encode($post)
                // "organization_id" => '62682228'
                );

                $url = 'https://invoice.zoho.com/api/v3/contacts';

                $curl = curl_init($url);

                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS,$data);

                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);


                $result_curl = curl_exec($curl);
                $result = json_decode($result_curl);
                //print_r($result);
                //dd($result->contact);

                if($result->code==0)
                {

                    $customer_to_update = Customer::find($id);
                    $customer_to_update->zohoid =  $result->contact->contact_id;
                    $customer_to_update->save();
                    // $customer_to_update->zohoid =

                    $arr['success'] = 'Exported customer to Zoho invoice successfully.';
                }
                else
                {
                   $arr['error'] = 'Error occured.' ;
                   $arr['error_msg'] = $result->message;

                }
        return json_encode($arr);
    }


    function getForm()
    {
        $zoho = Zoho::first();
         return view('crm::zoho.add',compact('zoho'))->render();
    }

    function zohoStore(Request $request)
    {

        $id = $request->zoho_id;
        $this->validate($request,
            [
                'email' => 'required',
                'password' => 'required',


            ]);

        //dd($request->all());
        $zoho_obj =  Zoho::find($id);

           $zoho_obj->email = $request->email;
           $zoho_obj->password = $request->password;
           $zoho_obj->auth_token = $request->token;

           $zoho_obj->save();
           $zoho = Zoho::find($id);
           //return view('crm::zoho.add',compact('zoho'))->with('status', 'saved');
           $arr['success'] = 'Zoho credentials updated successfully';
            return json_encode($arr);
            exit;
    }

    function resetAuthToken($id)
    {

        //dd($id);
        $zoho =  Zoho::find($id);
        $url  = 'https://accounts.zoho.com/apiauthtoken/nb/create?SCOPE=ZohoInvoice/invoiceapi&EMAIL_ID='.$zoho->email.'&PASSWORD='.$zoho->password;

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
       // dd($result);

        $arr['msg'] = $result;
        return json_encode($arr);
        exit;

    }

    function getContacts()
    {
        $zoho = Zoho::first();

        $data = array(
                'authtoken' => $zoho->auth_token
                //'JSONString' => json_encode($post)
                // "organization_id" => '62682228'
                );

            $url = 'https://invoice.zoho.com/api/v3/contacts?authtoken='.$zoho->auth_token;

            $curl = curl_init($url);
           // curl_setopt($curl, CURLOPT_POST, true);
            //curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);


            $result_curl = curl_exec($curl);
            $result = json_decode($result_curl);

            //dd($result);
            $contacts =[];
            foreach($result->contacts as $contact)
            {
                $url = 'https://invoice.zoho.com/api/v3/contacts/'.$contact->contact_id.'?authtoken='.$zoho->auth_token;

                $curl = curl_init($url);
               // curl_setopt($curl, CURLOPT_POST, true);
                //curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);


                $result = curl_exec($curl);
                $cntcts =  json_decode($result);
                $contacts[] = $cntcts->contact;

            }
            //dd($contacts);

            foreach($contacts as $contact)
            {

                $flag = Customer::where('zohoid',$contact->contact_id)->first();

                if(!$flag)
                {
                    $customer = new Customer;
                    $customer->name  = $contact->contact_name;
                   // $customer->main_phone = $contact->phone;
                    $customer->email_domain = $contact->company_name;
                    $customer->customer_since = date( "Y-m-d",strtotime($contact->created_time));
                    $customer->zohoid =  $contact->contact_id;
                    $customer->is_active = ($contact->status=='active')? 1 : 0;
                    //$customer->is_taxable = $contact->taxable;
                    $customer->created_at = date('Y-m-d',strtotime($contact->created_time));
                    $customer->updated_at =  date('Y-m-d',strtotime($contact->last_modified_time));
                    $customer->save();

                    $billing_address = $contact->billing_address;
                    $shipping_address = $contact->shipping_address;
                    if($billing_address->city!='')
                    {
                        $location_obj = new CustomerLocation;
                       $location_obj->location_name = $billing_address->city;
                       $location_obj->address = $billing_address->address;
                       $location_obj->country = $billing_address->country;
                       $location_obj->city = $billing_address->city;
                       $location_obj->zip = $billing_address->zip;
                       $location_obj->phone = $billing_address->fax;
                        $location_obj->customer_id = $customer->id;
                        $location_obj->default =1;
                        $location_obj->save();
                    }

                    if($shipping_address->city!='')
                    {
                        $location_obj = new CustomerLocation;
                       $location_obj->location_name = $shipping_address->city;
                       $location_obj->address = $shipping_address->address;
                       $location_obj->country = $shipping_address->country;
                       $location_obj->city = $shipping_address->city;
                       $location_obj->zip = $shipping_address->zip;
                       $location_obj->phone = $shipping_address->fax;
                        $location_obj->customer_id = $customer->id;
                        $location_obj->default =0;
                        $location_obj->save();
                    }
                    if($shipping_address->city=='' && $billing_address->city=='')
                    {
                        $location_obj = new CustomerLocation;
                        $location_obj->location_name = 'location';

                        $location_obj->customer_id = $customer->id;
                        $location_obj->default =0;
                        $location_obj->save();
                    }
                    foreach ($contact->contact_persons as $contact_)
                    {

                        $contact_obj         = new CustomerLocationContact;
                        $contact_obj->f_name = $contact_->first_name;
                        $contact_obj->l_name = $contact_->last_name;
                        $contact_obj->email  = $contact_->email;
                        //$contact_obj->title  = $contact->title_;
                        $phone = explode('-', $contact_->phone);
                        $contact_obj->phone = '('. $phone[1].')'.' '.$phone[2].'-'.$phone[3];
                        //$contact_obj->phone  = $contact_->phone;
                        $contact_obj->mobile = $contact_->mobile;
                        $contact_obj->is_poc = $contact_->is_primary_contact?1:0;
                        $contact_obj->customer_location_id = $location_obj->id;

                       $contact_obj->save();

                    }

                }
            }
             $arr['success'] = 'Imported customers from Zoho invoice successfully.Page will be refreshed in a while.';
        return json_encode($arr);
        exit;
            exit;
    }

    function getExpense($cust_id)
    {
        $zoho =  Zoho::first();
        $url = 'https://invoice.zoho.com/api/v3/expenses?authtoken='.$zoho->auth_token.'&customer_id='.$cust_id;

        $curl = curl_init($url);
       // curl_setopt($curl, CURLOPT_POST, true);
        //curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);


        $result_curl = curl_exec($curl);
        $result = json_decode($result_curl);

        $expense_dates = [];
        foreach ($result->expenses as $expense) {
            $expense_dates[] = $expense->date;
        }


        dd($result);
    }

}
