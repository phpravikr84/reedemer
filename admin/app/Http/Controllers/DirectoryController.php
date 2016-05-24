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
use File; 
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
		$id=Auth::user()->id;
		// Get current logged in user TYPE
		$type=Auth::user()->type;
		if($type==1)
		{
			$directory = Directory::where('directory_id',0)
						 ->orderBy('id','DESC')
						 ->get();
		}
		else
		{
			$directory = Directory::where('directory_id',0)
						 ->where('created_by',$id)
						 ->orderBy('id','DESC')
						 ->get();
		}
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
		//dd("a");
		$created_by=Auth::user()->id;
		$upload_dir = env('UPLOADS');

		$base_dir=$upload_dir."/".$created_by;
		$directory_name=$request->get('dir_name');
		$dest_dir="../../filemanager/userfiles/".$created_by;
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
		if(!file_exists($dest_dir))
		{
			//create base folder
			mkdir($dest_dir, 0777);
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

		if(!file_exists($dest_dir."/".$directory_name))
		{	
			//create folder		
			mkdir($dest_dir."/".$directory_name, 0777);
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
		//dd($directory->directory_base_path);
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
		 if($directory->directory==1)
		 {
			$file=$directory->directory_base_path."/";
			File::deleteDirectory($file);
		 }
		 else
		 {
		 	$file=$directory->directory_base_path."/".$directory->file_name;
		 	if(file_exists($file))
			{
			 	//dd("M");
				unlink($file);
			}
		 }
		 
		 //dd($file);
		

		// if($directory->directory==1)
		// {
		// 	if (is_dir($directory->directory_base_path)) 
		// 	{
		// 		rmdir($directory->directory_base_path);
		// 	}
		// }
		//unlink();
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
		//dd("a");
		$created_by=Auth::user()->id;
		$upload_dir = env('UPLOADS');

		$base_dir=$upload_dir."/".$created_by;
		// $directory_name=$request->get('dir_name');
		// if($request->get('new_dir_id'))
		// {
		// 	$directory_id=$request->get('new_dir_id');
		// }
		// else
		// {
		// 	$directory_id=0;
		// }
		
		$dest_dir="../../filemanager/userfiles/".$created_by;
		//check if base folder exists
		if(!file_exists($base_dir))
		{
			//create base folder
			mkdir($base_dir, 0777);
		}
		if(!file_exists($dest_dir))
		{
			//create base folder
			mkdir($dest_dir, 0777);
		}
		//copy($base_dir, $destination.'/'.$file);
		//mkdir($dest_dir, 0777);
		//dd($base_dir);


		// // check if folder exists
		// if(!file_exists($base_dir."/".$directory_name))
		// {	
		// 	//create folder		
		// 	mkdir($base_dir."/".$directory_name, 0777);
		// }
		// else
		// {
		// 	return 'folder_exists';
		// }

		//dd($base_dir);
		//dd($request->all());
		$image_name=$request->input('image_name');
		$dir_id=$request->input('dir_id');
		$created_by=Auth::user()->id;
		//dd($image_name);
		$dir_name_c="";
		if($dir_id)
		{
			$directory=Directory::find($dir_id);
			//dd($directory);
			$dir_path=$directory->directory_base_path;
			$dir_name_c=$directory->original_name;
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
		
		$original_path= $dir_path."/";
		//dd($original_path);

		//echo "PP".$file_name;
		//die();
		$extension = pathinfo($file_name, PATHINFO_EXTENSION);
		if($image_name)
		{
			$new_file_name = $image_name.'.'.$extension;
		}
		else
		{
			$new_file_name = time()."_".rand(111111111,999999999).'.'.$extension; // renameing image
		}

		$directory_url=url()."/".$original_path.$new_file_name;
		$check_url=$original_path.$new_file_name;
		//$directory_url="../../".$original_path.$new_file_name;
		if (File::exists($check_url))		
		{
			return 'already_exists';
			echo "has";
		}
		
		//dd($directory_url);
		$file_ori = $_FILES[ 'image_file' ][ 'tmp_name' ];
		$copy_file_url=$dest_dir."/".$dir_name_c."/".$new_file_name;
		//dd($copy_file_url);
		copy($file_ori, $copy_file_url);	
		//dd($original_path.$new_file_name);
		move_uploaded_file($file_ori, $original_path.$new_file_name);		
			
		
		
		
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
