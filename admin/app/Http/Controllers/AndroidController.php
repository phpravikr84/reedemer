<?php namespace App\Http\Controllers;
use Auth;
//use App\Model\Logo;
use App\Model\Wptoken;
use App\Model\Demotest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Http\Response; 
use Redirect;
use Input;
use Session;
use App\Helper\vuforiaclient;
use App\Model\User;
use App\Model\Logo;
use App\Model\Category;

class AndroidController extends Controller {

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
	public function getIndex(Request $request)
	{
		 // $data = array(
		 // 	'target_id' => urlencode($request->get('target_id')),
		 // 	'webservice_name' => 'demo_add'
		 // );
		dd($request->all());
		
		//$url = getenv('WEBSERVICE');
		//echo $url;
		//$result= $this->post_to_url($url, $data);
		//$result_arr=json_decode($result);
		$webservice_name="demo_add";
		$base_path=getenv('WEBSERVICE');
		//$favcolor = "red";

		switch ($webservice_name) {
		case "demo_name":
			$url=$base_path."demo_add";
		break;		
		default:
			$url=$base_path."not_found";
		}
	}

	public function getAdd()
	{
		



		$demotest=new Demotest();
		$demotest->target_id='4444';
		$demotest->save();
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
	

}
