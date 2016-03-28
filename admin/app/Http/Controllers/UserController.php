<?php namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Http\Response; 
use App\Model\User;
use Hash;
use Validator; 


class UserController extends Controller {

	
	/*
	|--------------------------------------------------------------------------
	| User Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	
	/**
	 * add user to the system.
	 *
	 * @return Response
	*/
	

	public function getAdd($id = Null)
	{
		
		return view('user.add');
	}

	// Register user as reedemer
	public function postStore(Request $request)
	{	
	
		$rules = array(
				'company_name'     => 'required',  
				'email'            => 'required|email|unique:users',   
				'password'         => 'required|min:6'

			);	
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {				
			$messages = $validator->messages();
			// redirect our user back to the form with the errors from the validator			
			return redirect()->back()
							 ->withInput($request->only('company_name'))
							 ->withErrors($validator);
		} else {
			// create the data for our user
			$user = new User();
			$user->company_name 		= $request->input('company_name');			
			$user->type 		= 2;			
			$user->approve 		= 0;
			$user->email 		= $request->input('email');
			$user->password = bcrypt($request->input('password'));
			$user->save();
				
			
			$request->session()->flash('alert-success', 'User has been created successfully');			
			return redirect('user/add');		
			exit;	
		}
	}


	public function getShow()
	{
		//$user=User::where('status',1)->get();		
		//return $user;
	}

	public function getStatusupdate($id)
	{
		dd($id);
		//$user = new User();
		//$user->status=1;
		//$user->save();
		//return $id;
	}
}
