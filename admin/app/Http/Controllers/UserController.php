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
	/*public function __construct()
	{
		$this->middleware('guest');
	}*/

	
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

	

	public function getStatusupdate($id)
	{
		dd($id);
		//$user = new User();
		//$user->status=1;
		//$user->save();
		//return $id;
	}

	public function getDash()
	{
		dd("a");
		//$user = new User();
		//$user->status=1;
		//$user->save();
		//return $id;
	}

	public function getDashboard()
	{
		return view('user.dashboard.index');
	}

	public function getLogo()
	{	
		$id=Auth::user()->id;
		dd($id);	
		$logo_details = Logo::where('reedemer_id',41)
						->orderBy('id','DESC')
						->get();
		//dd("d");
		$logo_arr=array();	
		$company_name="N/A";
		$target_id=NULL;
		foreach($logo_details as $logo_details)
		{			
			if($logo_details['reedemer_id'] >0)
			{
				$company_details=User::find($logo_details['reedemer_id']);
				$company_name=$company_details['company_name'];
			}			
			$logo_arr[]=array(
						'id'=>$logo_details['id'],
						'reedemer_id'=>$logo_details['reedemer_id'],
						'tracking_rating'=>$logo_details['tracking_rating'],
						'reedemer_company'=>$company_name,
						'logo_name'=>$logo_details['logo_name'],
						'logo_text'=>$logo_details['logo_text'],
						'status'=>$logo_details['status'],
						'uploaded_by'=>41,
						'created_at'=>$logo_details['created_at'],
						'updated_at'=>$logo_details['updated_at'],
					  );
		}
		$logo_json=json_encode($logo_arr);
		
		return $logo_json;	
	}

	public function getShow()
	{
		$id=Auth::User()->id;
		//dd($id);
		$user=User::where('id',$id)->get();		
		return $user;
	}
}
