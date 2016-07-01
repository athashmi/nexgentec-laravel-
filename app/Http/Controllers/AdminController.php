<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SignUpPostRequest;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Hash;
use App\Model\User;
use Auth;

use Event;
use App\Events\countNewLeaves;
use Session;


class AdminController extends Controller {
//private $admin = 1;

 use AuthenticatesAndRegistersUsers, ThrottlesLogins;

 private $admin = 1;
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
		public function __construct(){

			
		} 
	
		public function getRegister()
		{
			return view('admin.register');
		}

		public function postRegister(SignUpPostRequest $request) 
		{
			$user = new User;
			$user->name = $request->name;
			$user->email = $request->email;
			$user->password = bcrypt($request->password);
			$user->save();
			return redirect()->intended('admin/dashboard');			
		}

		public function getLogin()
		{
	    	
	        return view('admin.login');
	    }

		public function postLogin(Request $request)
		{
	    	 $this->validate($request, [
		        'email' => 'required|email',
	            'password' => 'required',
		    ]);
	        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
	         	if(Auth::user()->hasRole('admin'))
	         	{
			     	$leaves_count = Event::fire(new countNewLeaves());
			     	Session::forget('leaves_posted_count');
			     	Session::put('leaves_posted_count', $leaves_count[0]);
			 	}
			         //dd($leaves_count);
	            return redirect()->intended('admin/dashboard');
	        }
	        else
	        {
	    	  return redirect()->intended('admin/login');
	    	}
	    }
		
	
	
		public function showDashboard()
		{
			//dd(Auth::user());
			session()->forget('cust_id');
			session()->forget('customer_name');
			//session('cust_id'));
			//unset(session('customer_name'));
			 return View('admin.dashboard');

		}
		public function doLogout()
		{
			Auth::logout(false); // log the user out of our application
			return Redirect::to('admin'); // redirect the user to the login screen
		}

	    function profile()
	    {
	       

	    }
	    function listUsers()
	    {

	    	$user = User::where('role_id','<>',$this->admin)->get();
	    	//$role = $user->role;
	    	
	    	/*foreach($user as $usr)
	    	{
	    		echo $usr->name;
	    	}*/
	    	//exit;
	    	return view('admin.users',['users'=>$user]);

	    }

		public function addUser() 
		{
			
			return view('admin.add_user');		
		}
		
	    public function postAddUser(SignUpPostRequest $request) 
		{
			$user = new User;
			$user->name = $request->name;
			$user->email = $request->email;
			$user->password = bcrypt($request->password);
			$user->role_id = 2;
			$user->save();
			return redirect()->intended('admin/users');			
		}
}
