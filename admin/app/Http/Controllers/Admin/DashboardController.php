<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\Logo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hash;
use Validator; 

class DashboardController extends Controller {

	//protected $dashboard;
	
	public function __construct(  )
	{
		//$this->dashboard = $dashboard;
	}	

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	 
	public function getIndex()
	{
		return view('admin.dashboard.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//dd("a");
		//
		//dd($request->all());
		//return 'c';
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getShow()
	{
		$user=User::where('type',2)->get();		
		return $user;
	}

	public function getStatusupdate($id,$approve)
	{		
		if($approve==1)
		{
			$new_status=0;
		}
		else
		{
			$new_status=1;	
		}
		$user = User::find($id);
		$user->approve=$new_status;
		$user->save();
		return $new_status;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	
	public function postStorereedemer(Request $request)
	{
		/*$user = new User();
		$user->company_name 		= $request->input('company_name');			
		$user->type 		= 2;			
		$user->approve 		= 1;	
		$user->email 		= $request->input('email');
		$user->password = bcrypt($request->input('password'));
		if($user->save())
		{
			return 'success';
		}*/

		$rules = array(
				'company_name'     => 'required',  
				'email'            => 'required|email|unique:users',   
				'password'         => 'required|min:6'

			);	
		$validator = Validator::make($request->all(), $rules);
		if ($validator->fails()) {				
			$messages = $validator->messages();
			// redirect our user back to the form with the errors from the validator			
			/*return redirect()->back()
							 ->withInput($request->only('company_name'))
							 ->withErrors('Please insert all field');*/
			return 'error';		
			exit;	
		} else {
			// create the data for our user
			$user = new User();
			$user->company_name 		= $request->input('company_name');			
			$user->type 		= 2;			
			$user->approve 		= 1;
			$user->email 		= $request->input('email');
			$user->password = bcrypt($request->input('password'));
			$user->save();
				
			
			return 'success';		
			exit;	
		}
		
	}

	/*public function getCreatereedemer()
	{
		return view('admin.reedemer.add');
	}*/

	public function postStorelogo(Request $request)
	{
		$user = new Logo();
		$user->logo_name 		= $request->input('company_id');	
		$user->logo_text 		= $request->input('logo_text');		
		$user->status 		= 1;			
		$user->uploaded_by 		= 1;
		$user->save();

		return 'success';		
		exit;	
		//echo "aaaaa:".$request->input('company_id');
	}

	public function getLogo()
	{
		$logo = Logo::get();
		
		//echo $logo->reedemer;
		return $logo;		
		//exit;	
	}



	
}
