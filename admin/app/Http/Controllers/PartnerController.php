<?php namespace App\Http\Controllers;
use Auth;
//use App\Model\Logo;
use App\Model\Wptoken;
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

class PartnerController extends Controller {

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
	public function getIndex()
	{
		//echo $search;
		$logo_details=Logo::where('status',1)
					  ->orderBy('id','DESC')
					  ->get();					 
		$url=url();
		
		return view('partner.list',[
						'logo_details' =>$logo_details,
						'url' =>$url
				   ]);
	}

	public function postSearch(Request $request)
	{
		//dd($request->all());
		//exit;
		$logo_details=Logo::where('status',1)
					  ->orderBy('id','DESC')
					  ->get();					 
		$url=url();
		
		return view('partner.list',[
						'logo_details' =>$logo_details,
						'url' =>$url
				   ]);
	}

	public function getAdd($logo_id)
	{	
		$logo_details=Logo::where('id',$logo_id)->first();			
		return view('partner.add',[
						'logo_id' =>$logo_id,
						'logo_details' =>$logo_details
				   ]);
	}

	public function postStore(Request $request)
	{		
		$wptoken=$this->getWptoken();
		$logo_id=$request->get('logo_id');
		
		// Data Array
		$data = array(
			//'logo_id' => urlencode($request->get('logo_id')),
			'company_name' => urlencode($request->get('company_name')),
			'address' => urlencode($request->get('address')),
			'email' => urlencode($request->get('user_email')),
			'web_address' => urlencode($request->get('web_address')),
			'password' => urlencode($request->get('user_password')),
			'confirm_user_password' => urlencode($request->get('confirm_user_password')),
			'owner' => urlencode($request->get('owner')),
			'create_offer_permission' => urlencode($request->get('create_offer_permission')),
			'token_value' => $wptoken->token_value
		);

		
		$url = getenv('WEBSERVICE_PATH');
		$result= $this->post_to_url($url, $data);
		$result_arr=json_decode($result);
		
		if($result_arr->success=='false')
		{
			return redirect()->back()	
					->withInput($request->only('company_name','address','user_email', 'web_address'))								
					->withErrors([
						'message' => $result_arr->message,
					]);
		}
		else
		{
			$reedemer_id = $result_arr->reedemer_id;

			if($logo_id==0)
			{
				//dd("a");
				//redirect()->route('login');
				if (Auth::attempt(['email' => $request->get('user_email'), 'password' => $request->get('user_password')]))
        		{
         			return view('partner.addlogo',[
						 'reedemer_id' =>$reedemer_id,
						 'logo_text' =>$request->get('company_name')
				     ]);

					//return Redirect('partner/addlogo/'.$reedemer_id)->with('reedemer_id',$reedemer_id);
				}
			}
			else
			{
				

				$logo=Logo::find($logo_id);
				$logo->reedemer_id 	= $reedemer_id;	
				$logo->save();
				
				Session::flash('message', $result_arr->message);

				return Redirect::back();
			}
		}

		


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

	public function getWptoken() {
		$wptoken=Wptoken::first();
		//dd($wptoken->toArray());
		return $wptoken;
	}

	public function postAddlogo(Request $request)
	{
		if($_FILES['logo_image']['name']!="")
		{
			$destinationPath ='../uploads/original/'; // upload path			
			$extension = Input::file('logo_image')->getClientOriginalExtension(); // getting image extension
			$fileName = time()."_".rand(111111111,999999999).'.'.$extension;
			Input::file('logo_image')->move($destinationPath, $fileName); // uploading file to given path
		}


		$client = new vuforiaclient();
		//$rand=rand(111111,999999);
		$send[0] = $fileName;
		$send[1] = '../uploads/original/'.$fileName;
		$send[2] = '../uploads/original/'.$fileName;
		$send[3] = 'Redeemar';
		$send[4] = 'Redeemar';		
		$response=$client->addTarget($send);
		$response_arr=json_decode($response);		
		//echo $response_arr->target_id;
		//dd($response_arr);
		//if($response_arr->result_code=="TargetCreated")
		//{

		//echo $fileName;
		//echo $request;
		//exit;
		$reedemer_id = $request->get('reedemer_id');
		$target_id = $response_arr->target_id;
		$logo_text = $request->get('logo_text');

		//dd($request->get('reedemer_id'));
		 $logo = new Logo();
		 $logo->reedemer_id=$reedemer_id;
		 $logo->logo_name=$fileName;
		 $logo->logo_text=$logo_text;
		 $logo->status=0;
		 $logo->target_id=$target_id;
		 $logo->tracking_rating=-1;
		 if($logo->save())
		 {
		 	Session::flash('message', "Your account created successfully. We will notify you via email after it activated.");

			return Redirect::to('partner/msg');
		 }
		 else
		 {

			return redirect()->back()	
					->withInput()								
					->withErrors([
						'message' => 'Unable to upload your logo. Please try again',
					]);
		 }
	}


	public function getVuforiarate($target_id,$logo_id)
	{
		//dd($logo_id);
		$client = new vuforiaclient();
		//$target_id=$target_id->target_id;

		$target_res_details=$client->getTarget($target_id); 
		//$response_arr=json_decode($target_res_details);
		$response_arr=json_decode($target_res_details);
		$tracking_rating=$response_arr->target_record->tracking_rating;
		
		return $tracking_rating;
		// $logo = Logo::find($logo_id);

		// $logo->tracking_rating = $tracking_rating;

		// if($logo->save())
		// {
		// 	//$logo_id = $logo->id;
		// 	return array('response'=>'success','rating'=>$tracking_rating);
		// }
	}

	public function getMsg()
	{
		//$this->getVuforiarate();
		return view('partner.msg');
	}
	

}
