<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Http\Response; 
use App\Model\User;
use Hash;
use Validator;
use App\Model\Logo;
use App\Helper\vuforiaclient;
use App\Helper\helpers;
use Auth; 
use Session ;
use App\Model\Directory;


class DirectoryController extends Controller {
	
	

	public function __construct( )
	{
		if($this->middleware('auth'))
		//if(!Auth::user()->id)
		{
			Auth::logout();
    		return redirect('auth/login');	
    	}
		
	}
	
	public function postShow()
	{
		$directory = Directory::where('directory_id',0)
					 ->orderBy('id','DESC')
					 ->get();
		return $directory;
	}

	public function getAlldirectory()
	{
		$created_by=Auth::user()->id;
		$directory = Directory::where('status',1)
					 ->where('created_by',$created_by)
					 ->where('directory',1)
					 ->orderBy('id','DESC')
					 ->get();
		return $directory;
	}

	public function getAlllisting($id)
	{
		$created_by=Auth::user()->id;
		$directory = Directory::where('status',1)					 
					 ->where('directory_id',$id)
					 ->orderBy('id','DESC')
					 ->get();
		return $directory;
	}

	public function postStore(Request $request)
	{
		$created_by=Auth::user()->id;
		$upload_dir = env('UPLOADS');

		$base_dir=$upload_dir."/".$created_by;
		$directory_name=$request->get('dir_name');
		if($request->get('new_dir_id'))
		{
			$directory_id=$request->get('new_dir_id');
		}
		else
		{
			$directory_id=0;
		}
		//check if base folder exists
		if(!file_exists($base_dir))
		{
			//create base folder
			mkdir($base_dir, 0777);
		}

		// check if folder exists
		if(!file_exists($base_dir."/".$directory_name))
		{	
			//create folder		
			mkdir($base_dir."/".$directory_name, 0777);
		}
		else
		{
			return 'folder_exists';
		}

		$status=1;	
		$directory_url=url()."/".$directory_name;

		$directory = new Directory();
		$directory->directory_id 		= $directory_id;			
		$directory->original_name 		= $directory_name;	
		$directory->file_name 		= $directory_name;				
		$directory->directory_base_path 		= $base_dir."/".$directory_name;	
		$directory->directory_url 		= $directory_url;
		$directory->directory = 1;
		$directory->status = $status;
		$directory->created_by = $created_by;



			
		//$directory = new Directory();
		//$directory->directory_name 			= $directory_name;			
		//$directory->directory_base_path 	= $base_dir."/".$directory_name;	
		//$directory->status 					= $status;	
		//$directory->created_by 				= $created_by;		
		if($directory->save())
		{
			return 'success';
		}
		else
		{
			return 'error';
		}
		
	}

	public function getDelete($id = Null)
	{		
		
		$directory = Directory::find($id);		
		//dd($directory->directory);
		// $thubm_path=env('UPLOADS')."/inventory/thumb/";
		// $medium_path=env('UPLOADS')."/inventory/medium/";
		// $original_path=env('UPLOADS')."/inventory/original/";

		// if(file_exists($thubm_path.$inventory->campaign_image))
		// {
		// 	@unlink($thubm_path.$inventory->campaign_image);
		// } 
		// if(file_exists($medium_path.$inventory->campaign_image))
		// {
		// 	@unlink($medium_path.$inventory->campaign_image);
		// }
		// if(file_exists($original_path.$inventory->campaign_image))
		// {
		// 	@unlink($original_path.$inventory->campaign_image);
		// }
		if($directory->directory==1)
		{
			if (is_dir($directory->directory_base_path)) 
			{
				rmdir($directory->directory_base_path);
			}
		}
		//$directory->delete();
		if($directory->delete())
		{
			return 'success';
		}		
		else{
			return 'error';
		}		
	}

	public function postUpload(Request $request)
	{
		$dir_id=$request->input('dir_id');
		$created_by=Auth::user()->id;
		if($dir_id)
		{
			$directory=Directory::find($dir_id);
			$dir_path=$directory->directory_base_path;
		}
		else
		{
			//$directory=Directory::find($dir_id);
			$dir_path=env('UPLOADS')."/".$created_by;
		}
		//dd($dir_path);
		$obj = new helpers();
		$folder_name=env('UPLOADS');
		$file_name=$_FILES[ 'image_file' ][ 'name' ];
		$temp_path = $_FILES[ 'image_file' ][ 'tmp_name' ];
		$request->input('dir_id');

		//$original_path= env('UPLOADS')."/42/Demo_1"."/";
		//dd($original_path);
		$original_path= $dir_path."/";
		//dd($original_path);

		//echo "PP".$file_name;
		//die();
		$extension = pathinfo($file_name, PATHINFO_EXTENSION);
		$new_file_name = time()."_".rand(111111111,999999999).'.'.$extension; // renameing image

		$file_ori = $_FILES[ 'image_file' ][ 'tmp_name' ];
		
		move_uploaded_file($file_ori, "$original_path$new_file_name");		
			
		$directory_url=url()."/".$original_path.$new_file_name;
		//dd($directory_url);

		$directory_save = new Directory();
		$directory_save->directory_id 		= $dir_id;			
		$directory_save->original_name 		= $_FILES[ 'image_file' ][ 'name' ];	
		$directory_save->file_name 		= $new_file_name;				
		$directory_save->directory_base_path 		= $dir_path;	
		$directory_save->directory_url 		= $directory_url;
		$directory_save->directory = 0;
		$directory_save->status = 1;
		$directory_save->created_by = $created_by;

		if($directory_save->save())
		{
			return 'success';
		}

		//echo $_FILES['image_file']['name']."---".$request->input('dir_id');
		//exit;
		//dd($request->all());
		//return $request;
	}

	public function getUpdatestatus($id)
	{
		$directory = Directory::find($id);
		if($directory->status ==0)
		{
			$new_status=1;
		}
		else
		{
			$new_status=0;
		}
		$directory->status = $new_status;			
		if($directory->save())
		{
			return 'success';
		}
	}
}
