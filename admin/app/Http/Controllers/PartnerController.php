<?php namespace App\Http\Controllers;
use Auth;
use App\Model\Logo;
use App\Model\Wptoken;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Http\Response; 
use Redirect;
use Session;


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
				return Redirect('partner/addlogo/'.$reedemer_id)->with('reedemer_id',$reedemer_id);
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

	public function getAddlogo($reedemer_id)
	{
		//getAddlogoecho $reedemer_id;
		 return view('partner.addlogo',[
		 				'reedemer_id' =>$reedemer_id
		 		   ]);
	}

	

}
