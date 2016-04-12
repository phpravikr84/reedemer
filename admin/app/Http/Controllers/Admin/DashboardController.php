<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\Logo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Hash;
use Validator; 
use Input; /* For input */
use App\Helper\helpers;
use Auth;
use App\Helper\vuforiaclient;
//use App\Helper\gettarget;
//use App\Helper\signaturebuilder;

class DashboardController extends Controller {

	//protected $dashboard;
	
	//public function __construct(  )
	//{
		//$this->dashboard = $dashboard;
	//	$this->middleware('auth');
	//	dd("Ag");
	//}	


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
		//dd("dashboard->show");
		//Auth::logout();

    	//return redirect()->back();
	}

	public function postShow()
	{
		$id=Auth::user()->id;
		$type=Auth::user()->type;

		//dd($id);
		if($type!=1)
		{
			$user=User::where('id',$id)->orderBy('id','DESC')->get();	
		}
		else
		{
			$user=User::where('type',2)->orderBy('id','DESC')->get();		
					
		}
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
		if($request->input('company_name')=='' || $request->input('email')=='' ||  $request->input('password')=='')
		{
			return 'error';
			exit;
		}
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
			return 'email_exists';		
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

	public function postUploadlogo(Request $request)
	{		
		$obj = new helpers();
		$folder_name=env('UPLOADS');
		$file_name=$_FILES[ 'file' ][ 'name' ];
		$temp_path = $_FILES[ 'file' ][ 'tmp_name' ];

		

		if (!file_exists($folder_name)) {
			$create_folder= mkdir($folder_name, 0777);
			$thumb_path= mkdir($folder_name."/thumb", 0777);
			$medium_path= mkdir($folder_name."/medium", 0777);
			$original_path= mkdir($folder_name."/original", 0777);
		}
		else
		{
			$thumb_path= env('UPLOADS')."/thumb"."/";
			$medium_path= env('UPLOADS')."/medium"."/";
			$original_path= env('UPLOADS')."/original"."/";
		}


		$extension = pathinfo($file_name, PATHINFO_EXTENSION);
		$new_file_name = time()."_".rand(111111111,999999999).'.'.$extension; // renameing image

		$file_ori = $_FILES[ 'file' ][ 'tmp_name' ];
		
		move_uploaded_file($file_ori, "$original_path$new_file_name");
		
		$obj->createThumbnail($original_path,$thumb_path,env('THUMB_SIZE'));
		$obj->createThumbnail($original_path,$medium_path,env('MEDIUM_SIZE'));

		
		//$user = new Logo();
		//$user->logo_name 		= $new_file_name;	
		//$user->logo_text 		= $request->input('logo_text');		
		//$user->status 			= 1;			
		//$user->uploaded_by 		= 1;
		//$user->save();

		//return 'success';		
	//	exit;	
		//echo "aaaaa:".$request->input('logo_name');
		//dd($request->all());
		//echo $_FILES[ 'file' ][ 'tmp_name' ]."A<br>";
		//echo $_FILES[ 'file' ][ 'name' ];
		//exit;
		   // $tempPath = $_FILES[ 'file' ][ 'tmp_name' ];
		   // $uploadPath = '../uploads' . DIRECTORY_SEPARATOR . $_FILES[ 'file' ][ 'name' ];
		  //  move_uploaded_file( $tempPath, $uploadPath );
		  //  $answer = array( 'answer' => 'File transfer completed' );
		  //  $json = json_encode( $answer );
		  //  echo $json;
		return $new_file_name;

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
		
		$logo = Logo::find($logo_id);

		$logo->tracking_rating = $tracking_rating;

		if($logo->save())
		{
			//$logo_id = $logo->id;
			return array('response'=>'success','rating'=>$tracking_rating);
		}
	}
	public function postLogo()
	{
		$id=Auth::user()->id;
		$type=Auth::user()->type;
		//dd($type);
		if($type!=1)
		{
			$logo_details = Logo::where('reedemer_id',$id)							
							->orderBy('id','DESC')
							->get();	
		}
		else
		{
			$logo_details = Logo::orderBy('id','DESC')
							->get();
				
		}

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
						'uploaded_by'=>Auth::user()->id,
						'created_at'=>$logo_details['created_at'],
						'updated_at'=>$logo_details['updated_at'],
					  );
		}
		$logo_json=json_encode($logo_arr);		
		return $logo_json;		
			
	}

	public function getAddlogo($logo_text,$image_name)
	{
		
		/*$rules = array(
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
		}*/


		$client = new vuforiaclient();
		$rand=rand(111111,999999);
		$send[0] = "Logo_".time()."_".$rand;
		$send[1] = '../uploads/original/'.$image_name;
		$send[2] = '../uploads/original/'.$image_name;
		$send[3] = 'Redeemar';
		$send[4] = 'Redeemar';		
		$response=$client->addTarget($send);
		$response_arr=json_decode($response);		

		if($response_arr->result_code=="TargetCreated")
		{
			//dd("A");
			$target_id=$response_arr->target_id;					
			$logo = new Logo();
			//$logo->reedemer_id 		= $company_id;	
			$logo->target_id 		= $target_id;
			$logo->logo_name 		= $image_name;	
			$logo->logo_text 		= $logo_text;
			$logo->status 			= 1;			
			$logo->uploaded_by 		= 1;
			if($logo->save())
			{
				$logo_id = $logo->id;
				return array('response'=>'success','target_id'=>$target_id,'logo_id'=>$logo_id);
			}			
		}
		else
		{
			return array('response'=>'image_problem','target_id'=>'');			
		}
	}

	public function getDeletereedemer($id)
	{
		$user = User::find($id); 		
		if($user->delete())
		{
			return 'success';
		}
	}

	public function getDeletelogo($id)
	{		
		$logo = Logo::find($id); 
		
		$client = new vuforiaclient();
			
		$response=$client->deleteTargets($logo->target_id);  
		//if($target_id=="deleted")
		//{ 
		$response_arr=json_decode($response);

		$logo->delete();
		//dd($response_arr->result_code);
		if($response_arr->result_code=="UnknownTarget")
		{
			return "UnknownTarget";
		}
		else
		{
			return 'success';
		}
		//if($logo->delete())
		//{
		//	return 'success';
		//}
		//}
	}

	public function postUserdetails()
	{
		//dd("a");
		$user_id=Auth::user()->id;
		$user_details=User::findOrFail($user_id);
		//dd($user_details->toArray());
		//dd($user_details->company_name);
		$user_arr=array();
		$user_arr['company_name']=$user_details->company_name;
		$user_arr['email']=$user_details->email;
		$user_arr['type']=$user_details->type;

		//dd($user_arr);
		return $user_arr;
	}


	
}
