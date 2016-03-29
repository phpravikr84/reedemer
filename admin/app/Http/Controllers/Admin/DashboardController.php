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
		if($user->save())
		{
			return 'success';
		}*/

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
			return 'error';		
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

	public function getLogo()
	{

		$logo = Logo::orderBy('id','DESC')->get();	
		
		return $logo;		
			
	}

	public function getAddlogo($company_id,$logo_text,$image_name)
	{

		//dd($request->all());
		$user = new Logo();
		$user->reedemer_id 		= $company_id;	
		$user->logo_name 		= $image_name;	
		$user->logo_text 		= $logo_text;		
		$user->status 			= 1;			
		$user->uploaded_by 		= 1;
		if($user->save())
		{
			return 'success';
		}
	}

	public function getDeletereedemer($id)
	{
		$user = User::find($id);  
		//$logo = Logo::where($id);    
		if($user->delete())
		{
			return 'success';
		}
	}

	public function getDeletelogo($id)
	{
		//dd($id);
		$logo = Logo::find($id);  
		//$logo = Logo::where($id);    
		if($logo->delete())
		{
			return 'success';
		}
	}

	


	
}
