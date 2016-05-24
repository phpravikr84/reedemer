<?php namespace App\Http\Controllers;
use Auth;
use DB;
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
use App\Model\UserPassedOffer;
use App\Model\UserBankOffer;
use App\Model\Offer;
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

		case "showoffers":
			$url=$base_path."offerlist";
		break;	
		case "offerdetail":
			$url=$base_path."offerdetail";
		break;
		case "myoffer":
			$url=$base_path."myoffer";
		break;	

		case "mypassedoffer":
			$url=$base_path."mypassedoffer";
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

	// Show Offer List

	public function postOfferlist(Request $request)
	{

		$data=json_decode($request->get('data'));
		$reedemer_id=$data->reedemer_id;
        
		$user_id=$data->user_id;
		$now=date('Y-m-d h:i:s');

		if($user_id>0)
		{
			// Get passed users list offer

			$userbankoffer=UserBankOffer::where('user_id',$user_id)->with('userDetail')->lists('offer_id');

			$userpassedoffer=UserPassedOffer::where('user_id',$user_id)->with('userDetail')->lists('offer_id');

			$offer_list=Offer::select(array('*',DB::raw('DATEDIFF(CAST(end_date as char), NOW()) AS expires')))->where('created_by',$reedemer_id)->where('end_date','>=',$now)->whereNotIn('id',$userbankoffer)->whereNotIn('id',$userpassedoffer)->with('offerDetail.inventoryDetails','campaignDetails','categoryDetails','subCategoryDetails','partnerSettings','companyDetail')->orderBy('created_at','desc')->get();

                $datalist['messageCode']="R01001";
		
	}
	else
	{

		$offer_list=Offer::select(array('*',DB::raw('DATEDIFF(CAST(end_date as char), NOW()) AS expires')))->where('created_by',$reedemer_id)->where('end_date','>=',$now)->with('offerDetail.inventoryDetails','campaignDetails','categoryDetails','subCategoryDetails','partnerSettings','companyDetail')->orderBy('created_at','desc')->get();

		 $datalist['messageCode']="R01002";

	}

	     $datalist['data']=$offer_list;

		return $datalist;

	}

    // Show User Bank Offer

	public function postMyoffer(Request $request)
	{

			// Get passed users list offer

		   $data=json_decode($request->get('data'));

		   $reedemer_id=$data->reedemer_id;

		    $user_id=$data->user_id;

			$userbankoffer=UserBankOffer::where('user_id',$user_id)->with('userDetail')->lists('offer_id');


			$offer_list=Offer::select(array('*',DB::raw('DATEDIFF(CAST(end_date as char), NOW()) AS expires')))->where('created_by',$reedemer_id)->whereIn('id',$userbankoffer)->with('offerDetail.inventoryDetails','campaignDetails','categoryDetails','subCategoryDetails','partnerSettings','companyDetail')->orderBy('created_at','desc')->get();

			$datalist['messageCode']="R01001";

			$datalist['data']=$offer_list;

			return $datalist;

	}

	// Show User Passed Offer

	public function postMypassedoffer(Request $request)
	{

			// Get passed users list offer

		  $data=json_decode($request->get('data'));

		   $reedemer_id=$data->reedemer_id;

		    $user_id=$data->user_id;

			$userpassedoffer=UserPassedOffer::where('user_id',$user_id)->with('userDetail')->lists('offer_id');

			$offer_list=Offer::select(array('*',DB::raw('DATEDIFF(CAST(end_date as char), NOW()) AS expires')))->where('created_by',$reedemer_id)->whereIn('id',$userpassedoffer)->with('offerDetail.inventoryDetails','campaignDetails','categoryDetails','subCategoryDetails','partnerSettings','companyDetail')->orderBy('created_at','desc')->get();

			$datalist['messageCode']="R01001";

			$datalist['data']=$offer_list;

			return $datalist;

	}

   // Show Offer Details

	public function postOfferdetail(Request $request)
	{

			$data=json_decode($request->get('data'));
		    $offer_id=$data->offer_id;
		    $user_id=$data->user_id;
		    $now=date('Y-m-d h:i:s');

			$offer_list=Offer:: select(array('*',DB::raw('DATEDIFF(CAST(end_date as char), NOW()) AS expires')))->where('end_date','>=',$now)->where('id',$offer_id)->with('offerDetail.inventoryDetails','campaignDetails','categoryDetails','subCategoryDetails','partnerSettings','companyDetail')->orderBy('created_at','desc')->get();

			$datalist['data']=$offer_list;

		return $datalist;

	}


	public function postChecktarget(Request $request)
	{	

		$target_id=$request->get('target_id');


		$logo=Logo::where('target_id',$target_id)->get()->first();	

		//dd(count($logo));	
        
		if($logo->reedemer_id)
		{
			$company_name=User::where('id',$logo->reedemer_id)->first()->company_name;
			$logo_name= $logo->logo_name;
			
			// get video links 
            
            $video_list=Video::where('uploaded_by',$logo->reedemer_id)->orderBy('default_video','desc')->get();

			$dataArr=array('reedemer_id'=>$logo->reedemer_id,'companyName' => $company_name,'logoImage' => $logo_name, 'videoList' => $video_list);
			$dataStr=json_encode($dataArr);


			$response['status']='success';
		 	$return['messageCode']="R01001";
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
		 	$return['messageCode']="R01002";
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
