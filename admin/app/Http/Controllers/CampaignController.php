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
use App\Model\Campaign;


class CampaignController extends Controller {
	
	

	public function postList()
	{		
		// Get current logged in user ID
		$created_by=Auth::user()->id;

		// Get current logged in user TYPE
		$type=Auth::user()->type;
		
		if($type==1)
		{
			$campaign=Campaign::where('status',1)
					  ->orderBy('id','DESC')
					  ->get();		
		}
		else
		{
			$campaign=Campaign::where('status',1)
					  ->where('created_by',$created_by)
					  ->orderBy('id','DESC')
					  ->get();		
		}
		return $campaign;	
	}

	public function getDelete($id = Null)
	{		
		$campaign = Campaign::find($id);		
		
		$thubm_path=env('UPLOADS')."/campaign/thumb/";
		$medium_path=env('UPLOADS')."/campaign/medium/";
		$original_path=env('UPLOADS')."/campaign/original/";

		if(file_exists($thubm_path.$campaign->campaign_image))
		{
			unlink($thubm_path.$campaign->campaign_image);
		} 
		if(file_exists($medium_path.$campaign->campaign_image))
		{
			unlink($medium_path.$campaign->campaign_image);
		}
		if(file_exists($original_path.$campaign->campaign_image))
		{
			unlink($original_path.$campaign->campaign_image);
		}
		$campaign->delete();
		if($campaign->delete())
		{
			return 'success';
		}	
	}

	public function postUploadlogo(Request $request)
	{		
		$obj = new helpers();
		$folder_name=env('UPLOADS');
		$file_name=$_FILES[ 'file' ][ 'name' ];
		$temp_path = $_FILES[ 'file' ][ 'tmp_name' ];

		

		if (!file_exists($folder_name)) {			
			$create_folder= mkdir($folder_name, 0777);
			$thumb_path= mkdir($folder_name."/campaign/thumb", 0777);
			$medium_path= mkdir($folder_name."/campaign/medium", 0777);
			$original_path= mkdir($folder_name."/campaign/original", 0777);
		}
		else
		{			
			$thumb_path= env('UPLOADS')."/campaign/thumb"."/";
			$medium_path= env('UPLOADS')."/campaign/medium"."/";
			$original_path= env('UPLOADS')."/campaign/original"."/";
		}


		$extension = pathinfo($file_name, PATHINFO_EXTENSION);
		$new_file_name = time()."_".rand(111111111,999999999).'.'.$extension; // renameing image

		$file_ori = $_FILES[ 'file' ][ 'tmp_name' ];
		
		move_uploaded_file($file_ori, "$original_path$new_file_name");
		
		$obj->createThumbnail($original_path,$thumb_path,env('THUMB_SIZE'));
		$obj->createThumbnail($original_path,$medium_path,env('MEDIUM_SIZE'));		
		
		return $new_file_name;

	}

	
	public function postAddlogo(Request $request)
	{

		$campaign_name=$request->input('c_name');
		$start_date=$request->input('c_s_date');
		$end_date=$request->input('c_e_date');
		$campaign_image=$request->input('campaign_image');

		// Get current logged in user ID
		$created_by=Auth::user()->id;

		if($campaign_name=="" || $start_date=="" || $end_date=="" || $campaign_image=="")
		{
			return 'error';
		}
		else
		{

			$original_path= env('UPLOADS')."/campaign/original"."/".$campaign_image;
			if(file_exists($original_path))
			{
				$campaign = new Campaign();
				$campaign->campaign_name 	= $campaign_name;	
				$campaign->campaign_image 	= $campaign_image;
				$campaign->start_date 		= $start_date;	
				$campaign->end_date 		= $end_date;		
				$campaign->status 			= 1;			
				$campaign->created_by 		= $created_by;
				if($campaign->save())
				{
					return 'success';
				}
				else
				{
					return 'error';
				}
			}
			else
			{
				return 'image_not';
			}
		}
		
	}
}
