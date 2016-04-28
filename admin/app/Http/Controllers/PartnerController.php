<?php namespace App\Http\Controllers;
use Auth;
use App\Model\Logo;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Http\Response; 

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
		$logo_details=Logo::where('status',1)
					  ->orderBy('id','DESC')
					  ->get();
					 // dd($logo_details->toArray());
		$url=url();
		
		return view('partner.list',[
						'logo_details' =>$logo_details,
						'url' =>$url
				   ]);
	}

	public function getAdd($logo_id)
	{	
		$logo_details=Logo::where('id',$logo_id)->first();	
		//dd($logo_details->toArray());
		return view('partner.add',[
						'logo_id' =>$logo_id,
						'logo_details' =>$logo_details
				   ]);
	}

	public function postStore(Request $request)
	{
		//dd($request->get('company_name'));
		//dd($request->all());

		// Data Array
		$data = array(
			'company_name' => urlencode($request->get('company_name')),
			'address' => urlencode($request->get('address')),
			'email' => urlencode($request->get('user_email')),
			'web_address' => urlencode($request->get('web_address')),
			'password' => urlencode($request->get('user_password')),
			'owner' => urlencode('1'),
			'token_value' => '76EJVZh$Q$'
		);


		$url = 'http://localhost/reedemer/admin/public/redeemar/store';
		$result= $this->post_to_url($url, $data);
		$result_arr=json_decode($result);
		//print_r($kk);
		echo $result_arr->success."<br>";
		echo $result_arr->message."<br>";


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
