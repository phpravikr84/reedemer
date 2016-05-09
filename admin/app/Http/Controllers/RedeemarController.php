<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Http\Response; 
use App\Model\User;
use App\Model\Token;
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

	public function getGeneratetoken($length = 10)
	{
		$token = Token::first();
		$total_token=Token::count();
		//dd($total_token);

		$characters = '!@#$%^&*()[]{}0123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
		    $randomString .= $characters[rand(0, $charactersLength - 1)];		    
		}		    
		if($total_token >0)
		{
			$token->token_value	= $randomString;	
			$token->status 		= 1;	
			if($token->save())
			{
				return $randomString;				
			}
		}
		else
		{
		    $token = new Token();
			$token->token_value	= $randomString;			
			$token->status 		= 1;	
			if($token->save())
			{
				return 'added';
			}
		}
		//return $response;
	}
	/**
	 * add user to the system.
	 *
	 * @return Response
	*/

	public function getToken($length = 10)
	{
		$token = Token::first();
		return $token->token_value;
	}
	
	
	// Register user as reedemer
	public function postStore(Request $request)
	{		
		$token_value=$request->input('token_value');
		$token_value_db=$this->getToken();
		$error=0;
		if($token_value=="")
		{
			$response['success']='false';
			$response['message']='Token is missing';
			$error=1;
		}
		if($token_value!=$token_value_db)
		{
			$response['success']='false';
			$response['message']='Token not match with our db';
			$error=1;
		}
		//$logo_id = $request->input('logo_id');
		$company_name = $request->input('company_name');
		$address 	  = $request->input('address');
		$email 		  = $request->input('email');
		$web_address  = $request->input('web_address');
		$password     = $request->input('password');
		$confirm_user_password     = $request->input('confirm_user_password');
		$cat_id     = $request->input('category_id');
		$subcat_id     = $request->input('subcat_id');
		$owner 		  = $request->input('owner');
		$create_offer_permission 		  = $request->input('create_offer_permission');
		$type         = 2;
		$approve 	  = 0;
		
		if($company_name=="")
		{
			$response['success']='false';
			$response['message']='Company name is missing';
			$error=1;
		}
		if($address=="")
		{
			$response['success']='false';
			$response['message']='Address is missing';
			$error=1;
		}

		if($web_address=="")
		{
			$response['success']='false';
			$response['message']='Web address is missing';
			$error=1;
		}
		if (filter_var($web_address, FILTER_VALIDATE_URL) === false)
		{
			$response['success']='false';
			$response['message']='Enter valid url';
			$error=1;
		}
		if(strlen($password) <6)
		{
			$response['success']='false';
			$response['message']='Password must be atleast 6 character long';
			$error=1;
		}
		if($confirm_user_password=="")
		{
			$response['success']='false';
			$response['message']='Retype password again';
			$error=1;
		}
		if($password!=$confirm_user_password)
		{
			$response['success']='false';
			$response['message']='Password not match with Retype password';
			$error=1;
		}
		
		if($error==0)
		{
			$check_user = User::where('email',$email)->count();
			$check_company = User::where('company_name',strtolower($company_name))->count();

			if ($check_user >0) {

				$response['success']='false';
				$response['message']='Email already registered with us';			   
			}
			else if ($check_company >0) {

				$response['success']='false';
				$response['message']='Company name already registered with us';			   
			}
			else
			{
				$user = new User();
				$user->company_name	= $company_name;			
				$user->address 		= $address;	
				$user->email 		= $email;	
				$user->web_address 	= $web_address;	
				$user->cat_id 		= $cat_id;	
				$user->subcat_id 	= $subcat_id;	
				$user->owner 		= $owner;	
				$user->create_offer_permission 		= $create_offer_permission;
				$user->type 		= $type;			
				$user->approve 		= $approve;		
				$user->password = bcrypt($password);
				if($user->save())
				{
					$response['success']='true';
					$response['message']='User added successfully';
					$response['reedemer_id']=$user->id;
				}
				else
				{
					$response['success']='false';
					$response['message']='Unable to add user';
				}
			}
		}

		$response['message']=htmlspecialchars(ltrim($response['message'],' & '));	
		
		return $response;
	}
	
}
