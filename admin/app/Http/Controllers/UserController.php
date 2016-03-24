<?php namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Illuminate\Http\Response; 
use App\Model\User;
use Hash;


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

	public function postStore(Request $request)
	{
		dd("V");
		//return view('user.add');
	}
}
