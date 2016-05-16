<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\Logo;
use App\Model\Price;
use App\Model\Partnersetting;
use App\Model\Category;
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

	public function postShow(Request $request)
	{
		//dd($request->all());

		$id=Auth::user()->id;
		$created_by=Auth::user()->id;

		// Get current logged in user TYPE
		$type=Auth::user()->type;
		if($request[0]!="")
		{
			$id=$request[0];
			$user=User::where('status',1)
						  ->where('id',$id)						 
						  ->get();	
		}
		else
		{
			if($type==1)
			{	
				$user=User::where('type',2)->orderBy('id','DESC')->get();			
			}
			else
			{
				$user=User::where('id',$id)->orderBy('id','DESC')->get();	
			}
		}


		// $id=Auth::user()->id;
		// $type=Auth::user()->type;

		// dd($id);
		// if($type!=1)
		// {
		// 	$user=User::where('id',$id)->orderBy('id','DESC')->get();	
		// }
		// else
		// {
		// 	$user=User::where('type',2)->orderBy('id','DESC')->get();		
					
		// }
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
		//dd($request->all())	;
		//dd($request->input('address').'--'.$request->input('web_address').'--'.$request->input('company_name').'--'.$request->input('email').'--'.$request->input('password').'--'.$request->input('category_id'));
		// if($request->input('address')=='' || $request->input('web_address')=='' || $request->input('company_name')=='' || $request->input('email')=='' ||  $request->input('password')=='' ||  $request->input('category_id')=='')
		// {
		// 	return 'error';
		// 	exit;
		// }
		$c_c=strtolower($request->input('company_name'));
		$user_check = User::where('company_name',$c_c)->count();
		//dd($user_check);
		if($user_check >0)
		{
			return 'already_company_exists';
			exit;
		}
		if($request->input('address')=='' || $request->input('web_address')=='' || $request->input('company_name')=='' || $request->input('email')=='' ||  $request->input('password')=='' ||  $request->input('category_id')=='')
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
			return redirect()->back()
							 ->withInput($request->only('company_name'))
							 ->withErrors('Please insert all field');
			
			exit;	
		} else {
			// create the data for our user
			$user = new User();
			$user->company_name = $request->input('company_name');			
			$user->address 		= $request->input('address');
			$user->type 		= 2; // Type 2 for redeemar partner		
			$user->approve 		= 1; // Autometically approve redeemar
			$user->email 		= $request->input('email');
			$user->web_address 	= $request->input('web_address');
			$user->password 	= bcrypt($request->input('password'));
			$user->cat_id 		= $request->input('category_id');
			$user->subcat_id 	= $request->input('subcat_id');
			$user->save();
			//Get latest redeemar ID
			$user_id = $user->id;
			
			// Insert dummy data into Table: reedemer_partner_settings
			// $price = new Partnersetting();
			// $price->setting_val 	= env('DEFAULT_PRICE_SETTING_VAL');			
			// $price->price_range_id 	= env('DEFAULT_PRICE_RANGE');		
			// $price->status 			= 1;			
			// $price->created_by 		= $user_id;
			
			// $price->save();
				
			
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

		//echo "PP".$file_name;
		//die();
		$extension = pathinfo($file_name, PATHINFO_EXTENSION);
		$new_file_name = time()."_".rand(111111111,999999999).'.'.$extension; // renameing image

		$file_ori = $_FILES[ 'file' ][ 'tmp_name' ];
		
		move_uploaded_file($file_ori, "$original_path$new_file_name");
		
		//$obj->createThumbnail($original_path,$thumb_path,env('THUMB_SIZE'));
		//$obj->createThumbnail($original_path,$medium_path,env('MEDIUM_SIZE'));		
		
		return $new_file_name;

	}

	public function getVuforiarate($target_id,$logo_id,$contact_email)
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
		$logo->contact_email = $contact_email;

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

	public function getAddlogo($logo_text='',$image_name,$enhance_logo=0)
	{	
	
		$id=Auth::user()->id;
		$type=Auth::user()->type;		
		if($type==2)
		{
			$user_details=User::find($id);
			//dd($user_details->company_name);
			$reedemer_id=null;
			//dd()
			$status=0;
			$logo_text=$user_details->company_name;
		}
		else
		{
			$reedemer_id=null;
			$status=1;
			//$logo_text="";
				
		}

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
			$logo->reedemer_id 		= $reedemer_id;	
			$logo->target_id 		= $target_id;
			$logo->logo_name 		= $image_name;	
			$logo->logo_text 		= $logo_text;
			$logo->status 			= $status;			
			$logo->enhance_logo 	= $enhance_logo;
			$logo->uploaded_by 		= $id;
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


	public function postAddlogo(Request $request)
	{	
		//dd($request[0]['logo_text']);
		$logo_text=$request[0]['logo_text'];
		$enhance_logo=0;
		$image_name=$request[0]['image_name'];
		$cat_id=$request[0]['category_id'];
		$subcat_id=$request[0]['subcat_id'];
		$contact_email=$request[0]['contact_email'];
		
		$id=Auth::user()->id;
		$type=Auth::user()->type;		
		if($type==2)
		{
			$user_details=User::find($id);
			//dd($user_details->company_name);
			$reedemer_id=null;
			//dd()
			$status=0;
			$logo_text=$user_details->company_name;
		}
		else
		{
			$reedemer_id=null;
			$status=1;
			//$logo_text="";
				
		}

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
			$logo->reedemer_id 		= $reedemer_id;	
			$logo->target_id 		= $target_id;
			$logo->logo_name 		= $image_name;	
			$logo->logo_text 		= $logo_text;
			$logo->contact_email	= $contact_email;
			$logo->cat_id 			= $cat_id;
			$logo->subcat_id 		= $subcat_id;
			$logo->status 			= $status;			
			$logo->enhance_logo 	= $enhance_logo;
			$logo->uploaded_by 		= $id;
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

	public function getAlllogo()
	{
		$id=Auth::user()->id;
		$type=Auth::user()->type;		
		if($type==2)
		{
			$logo_details = Logo::orderBy('id','DESC')
						->where('status',1)
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

	public function getLogodetails($logo_id)
	{
		
		$logo_details = Logo::where('id',$logo_id)->get();
		//dd($logo_details);
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
						'target_id'=>$logo_details['target_id'],
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

	public function getRate()
	{
		
		 $rand=rand(1,5)	;
		return $rand;		
			
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
		 
		$response_arr=json_decode($response);

		$logo->delete();
		
		if($response_arr->result_code=="UnknownTarget")
		{
			return "UnknownTarget";
		}
		else
		{
			return 'success';
		}		
	}

	public function postUserdetails()
	{		
		$user_id=Auth::user()->id;
		$type=Auth::user()->type;
		$user_details=User::findOrFail($user_id);
		if($type==2)
		{
			if(Logo::where('reedemer_id',$user_details->id)->count() >0)
			{
				$logo_details=Logo::where('reedemer_id',$user_details->id)->first()->logo_name;
			}
			else
			{
				$logo_details="no_logo.gif";
			}
		}
		//dd($logo_details);
		$user_arr=array();
		$user_arr['company_name']=$user_details->company_name;
		$user_arr['email']=$user_details->email;
		$user_arr['type']=$user_details->type;
		if($type==2)
		{
			$user_arr['logo_image']=$logo_details;
		}
		
		return $user_arr;
	}
	
	public function postUpdatestatus(Request $request)
	{
		$id=$request->get('user_logo_id');
		$target_id=$request->get('user_logo_target_id');
		$reedemer_id=Auth::user()->id;
		//dd($target_id);
		//dd($reedemer_id);
		$logo = Logo::find($id);
		$logo->reedemer_id=$reedemer_id;
		if($logo->save())
		{
			return 'success';
		}
	}

	public function postEditredeemar(Request $request)
	{
		$user = User::find($request[0]['id']);		

		$company_name=$request[0]['company_name'];
		$web_address=$request[0]['web_address'];		
		$address=$request[0]['address'];
		$id=$request[0]['id'];
		
		if($request[0]['id']=="")
		{
			return 'invalid_id';
		}
		else if($company_name=="" || $web_address=="" || $address=="")
		{
			return 'error';
		}
		else
		{			
			
			$user->company_name 	= $company_name;			
			$user->web_address 	= $web_address;							
			$user->address 		= $address;	
			if($user->save())
			{
				return 'success';
			}
			else
			{
				return 'error';
			}			
		}
		
		
	}

	public function postCategory(Request $request)
	{
		//dd($request->all());
		if($request[0]['sub_cat'])
		{
			$category = Category::where('parent_id',$request[0]['parent_id'])
						->where('visibility',1)
						->orderBy('id','DESC')
						->get();
		}
		else
		{
			$id=null;
			if($request[0])
			{
				$id=$request[0];
				$category = Category::where('id',$id)
							->where('visibility',1)
							->orderBy('id','DESC')
							->get();
			}
			else
			{
				$category = Category::where('parent_id',0)
							->where('visibility',1)
							->orderBy('id','DESC')
							->get();
			}
		}
		//dd($category->toArray());
		return $category;
	}

	//Listing to show only 
	public function getCategory($parent_id='')
	{
		//dd($parent_id);
		//$id=null;
		if($parent_id)
		{
			//$id=$request[0];
			$category = Category::where('parent_id',$parent_id)
						->where('visibility',1)
						->get();
		}
		else
		{
			$category = Category::where('visibility',1)
						->orderBy('id','DESC')
						->get();
		}
		//dd($category->toArray());
		return $category;
	}

	public function getCategoryupdate($id,$approve)
	{	
	
		if($approve==1)
		{
			$new_status=0;
		}
		else
		{
			$new_status=1;	
		}
		$user = Category::find($id);
		$user->status=$new_status;
		$user->save();
		return $new_status;
	}

	public function postStorecategory(Request $request)
	{	
		//dd($request->all());
		$cat_name=$request->get('cat_name');
		if($request->get('parent_id'))
		{
			$parent_id=$request->get('parent_id');
		}
		else
		{
			$parent_id=0;
		}

		$category = new Category();
		$category->cat_name 		= $cat_name;	
		$category->parent_id 		= $parent_id;
		$category->status 		= 1;		
		if($category->save())
		{
			return 'success';
		}
		else
		{
			return 'error';
		}
		//dd(4)
		//dd($request->get('cat_name'));
	}

	public function postEditcategory(Request $request)
	{
		//dd($request[0]['id']);
		$category = Category::find($request[0]['id']);		

		$cat_name=$request[0]['cat_name'];
		//$web_address=$request[0]['web_address'];		
		//$address=$request[0]['address'];
		$id=$request[0]['id'];
		
		if($request[0]['id']=="")
		{
			return 'invalid_id';
		}
		else if($cat_name=="")
		{
			return 'error';
		}
		else
		{			
			
			$category->cat_name 	= $cat_name;		
			if($category->save())
			{
				return 'success';
			}
			else
			{
				return 'error';
			}			
		}
	}

	public function getDeletecategory($id)
	{
		$category = Category::find($id); 
		
		$chk_subcat=Category::where('parent_id',$category->id)
					->where('visibility','1')
					->count();
		//dd($chk_subcat);
		if($chk_subcat >0)
		{
			return 'subcat_exists';
		}
		else
		{
			$category->visibility = 0;
			if($category->save())
			{
				return 'success';
			}
			else
			{
				return 'error';
			}
		}
		//if($category->delete())
		//{
		//	return 'success';
		//}
	}

	
	//Listing to show only 
	public function getSubcategory($parent_id='')
	{	
		//dd($parent_id)	;
		if($parent_id!='')
		{
			//$id=$request[0];
			$category = Category::where('parent_id',$parent_id)
						->where('visibility',1)
						->get();
		}
		else
		{
			$category = Category::where('visibility',1)
						->orderBy('id','DESC')
						->get();
		}
		//dd($category->toArray());
		return $category;
	}
	
}
