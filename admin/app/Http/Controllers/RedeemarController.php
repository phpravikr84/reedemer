<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Http\Response; 
use App\Model\User;
use Hash;
use Validator;
use App\Model\Logo;
use App\Helper\vuforiaclient;
use App\Helper\helpers;
use Auth; 
use Session ;


class RedeemarController extends Controller {

	
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
	/*public function __construct()
	{
		$this->middleware('guest');
	}*/

	public function __construct( )
	{
		// if($this->middleware('auth'))		
		// {
		// 	Auth::logout();
  //   		return redirect('auth/login');	
  //   	}
		
	}

	
	/**
	 * add user to the system.
	 *
	 * @return Response
	*/
	
	
	// Register user as reedemer
	public function postStore(Request $request)
	{
		//dd("a");
		//dd($request->all());

		$company_name = $request->input('company_name');
		$address 	  = $request->input('address');
		$email 		  = $request->input('email');
		$web_address  = $request->input('web_address');
		$password     = $request->input('password');
		$owner 		  = $request->input('owner');
		$type         = 2;
		$approve 	  = 0;
		
		$user = new User();
		$user->company_name	= $company_name;			
		$user->address 		= $address;	
		$user->email 		= $email;	
		$user->web_address 	= $web_address;	
		$user->owner 		= $owner;	
		$user->type 		= $type;			
		$user->approve 		= $approve;		
		$user->password = bcrypt($password);
		if($user->save())
		{
			return true;
		}
	}

	 

	

	
}
