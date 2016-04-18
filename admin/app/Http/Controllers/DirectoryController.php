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
		$directory = Directory::where('status',1)
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
		$directory = new Directory();
		$directory->directory_name 			= $directory_name;			
		$directory->directory_base_path 	= $base_dir."/".$directory_name;	
		$directory->status 					= $status;	
		$directory->created_by 				= $created_by;		
		if($directory->save())
		{
			return 'success';
		}
		else
		{
			return 'error';
		}
		
	}
}
