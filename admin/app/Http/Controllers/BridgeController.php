<?php namespace App\Http\Controllers;
use Auth;
//use App\Model\Logo;
use App\Model\Wptoken;
use App\Model\Demotest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
//use Request; 
use Illuminate\Http\Response; 
use Redirect;
use Input;
use Session;
use App\Helper\vuforiaclient;
use App\Model\User;
use App\Model\Logo;
use App\Model\Category;
use Illuminate\Http\Request;

class BridgeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
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
	// public function __construct()
	// {
	// 	$this->middleware('guest');
	// }

	public function __construct()
	{
		//$this->middleware('auth');
		//$this->menuItems				= $menu->where('active' , '1')->orderBy('weight' , 'asc')->get();
 				
		
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function postIndex(Request $request)
	{
		if($request->get('target_id'))
		{
			$target_id=$request->get('target_id');

		}
		else
		{
			$target_id="BOOM!!!!";
		}
		$target_id=$request->get('data');
	 	$demotest=new Demotest();
	 	$demotest->target_id=$target_id;
	 	$demotest->save();

		if($request->get('webservice_name')=='')
		{
			$response['success']='false';
			$response['message']='Webservice name is missing';
		}
		if($request->get('target_id')=='')
		{
			$response['success']='false';
			$response['message']='Target ID is missing';
		}
		
		$base_path=getenv('WEBSERVICE');
		$webservice_name=$request->get('webservice_name');
		$target_id=$request->get('target_id');

		 $data = array(
		   	'target_id' => urlencode($target_id)
		 );		

		switch ($webservice_name) {
		case "check_target":
			$url=$base_path."checktarget";
		break;		
		default:
			$url=$base_path."not_found";
		}

		// $response['success']='false';
		// $response['message']='Token is missing';

		// $response['message']=htmlspecialchars(ltrim($response['message'],' & '));	
		
		// //return $response;

		// $response['message']=htmlspecialchars(ltrim($response['message'],' & '));	
		
		// return $response;

		
		$response= $this->post_to_url($url, $data);
		//$response= $this->checktarget($target_id);
		$json = json_decode($response, true);
		//return $result;

		//$response['message']=htmlspecialchars(ltrim($response['message'],' & '));	
		
		// //return $response;

		//$response['message']=htmlspecialchars(ltrim($response['message'],' & '));

		//return $response;

		// $response['success']='false';
		// $response['message']='Token is missing';
		// $response['demo']=$url;

		//$result['message']=htmlspecialchars(ltrim($response['message'],' & '));	
		
		return $response;

		//$result['message']=htmlspecialchars(ltrim($response['message'],' & '));	
		
		
	}

	

	public function post_to_url($url, $data) {
	    $fields = '';
	    foreach ($data as $key => $value) {
	        $fields .= $key . '=' . $value . '&';
	    }
	    rtrim($fields, '&');

	    $post = curl_init();

	    curl_setopt($post, CURLOPT_URL, $url);
	    curl_setopt($post, CURLOPT_POST, count($data));
	    curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
	    curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

	    $result = curl_exec($post);

	    curl_close($post);
	    return $result;
	}


	// public function postChecktarget(Request $request)
	// {
	// 	$target_id=$request->get('target_id');

	// 	$demotest=new Demotest();
	// 	$demotest->target_id=$target_id;
	// 	$demotest->save();
	// }

	public function postChecktarget(Request $request)
	{
		$target_id=$request->get('target_id');
		 $logo=Logo::where('target_id',$target_id)->get()->first();		
		
		 if($logo->reedemer_id)
		 {
		 	$return['status']="partner_found";
		 	$return['message']="There are already a partner associates with this logo.";
		 }
		 else
		 {
		 	$return['status']="partner_not_found";
		 	$return['message']="No partner associates with this logo.";
		 }
		return $return;
	}
	

}
