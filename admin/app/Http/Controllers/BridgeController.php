<?php namespace App\Http\Controllers;
use Auth;
use App\Model\Wptoken;
use App\Model\Demotest;
use App\Model\Pp;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response; 
use Redirect;
use Input;
use Session;
use App\Helper\vuforiaclient;
use App\Model\User;
use App\Model\Video;
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
		$data=json_decode($request->get('data'));
		$target_id=$data->target_id;
		$webservice_name=$data->webservice_name;

		// Put all response to database for testing purpose
		// Will have to remove this later
		
	 	$demotest=new Demotest();
	 	$demotest->target_id=$target_id;
	 	$demotest->save();

		if($webservice_name=='')
		{
			$response['status']='failure';
			$response['messageCode']='R0001'; //Webservice name is missing
		}
		if($target_id=='')
		{
			$response['status']='failure';
			$response['messageCode']='R0002'; //Target ID is missing
		}
		
		$base_path=getenv('WEBSERVICE');
		$webservice_name=$webservice_name;
		$target_id=$target_id;

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

		$response= $this->post_to_url($url, $data);
		$json = json_decode($response, true);		

		return $response;		
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


	public function postChecktarget(Request $request)
	{	

		$target_id=$request->get('target_id');


		$logo=Logo::where('target_id',$target_id)->get()->first();		

		if($logo->reedemer_id)
		{
			$company_name=\App\Model\User::where('id',$logo->reedemer_id)->first()->company_name;
			$logo_name= $logo->logo_name;
			
			// get video links
            
            $video_list=\App\Model\Video::where('uploaded_by',$logo->reedemer_id)->get();

			$dataArr=array('company_name' => $company_name,'logo_image' => $logo_name, 'videos' => $video_list);
			$dataStr=json_encode($dataArr);


			$response['status']='success';
		 	$return['messageCode']="R1001";
		 	$return['data']=$dataStr;

		 	// Put all response to database for testing purpose
		 	// Will have to remove this later

		 	$pp=new Pp();
	 		$pp->val=$dataStr;
	 		$pp->save();
		}
		else
		{
			$response['status']='success';
		 	$return['messageCode']="R1002";
		}		
	 	
		return $return;
	}

	public function getSendmail()
	{
		$user_email="duser2@mailinator.com";
		$admin_email="dadmin2@mailinator.com";
		
		$user_name="vvv";
		$data = array('user_name' => 'rr', 'login_id' => 'rr', 'password' => 'rrr', 'user_email' => $user_email);
		\Mail::send('emails.nopartner', $data, function($message) use ($admin_email,$user_email,$user_name){ 
			$subject="Active your account in Redeemar";
			$message->from($admin_email, $user_name);
			$message->to($user_email)->subject($subject);
		}); 
	}
	

}
