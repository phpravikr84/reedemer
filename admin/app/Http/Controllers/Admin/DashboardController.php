<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
		dd("a");
		//
		//dd($request->all());
		return 'c';
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
		$user->save();*/

		//$user = User

		$company_name = $request->input('company_name');
		echo  $company_name."VVV";
	}
	
	
}
