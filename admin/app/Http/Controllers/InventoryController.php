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
use App\Model\Inventory;


class InventoryController extends Controller {
	
	

	public function postList()
	{		
		// Get current logged in user ID
		$created_by=Auth::user()->id;

		// Get current logged in user TYPE
		$type=Auth::user()->type;
		if($type==1)
		{	
			$inventory=Inventory::where('status',1)
					   ->orderBy('id','DESC')
					   ->get();		
		}
		else
		{
			$inventory=Inventory::where('status',1)
					  ->where('created_by',$created_by)
					  ->orderBy('id','DESC')
					  ->get();
		}
		return $inventory;	
	}

	public function getDelete($id = Null)
	{		
		$inventory = Inventory::find($id);		
		
		$thubm_path=env('UPLOADS')."/inventory/thumb/";
		$medium_path=env('UPLOADS')."/inventory/medium/";
		$original_path=env('UPLOADS')."/inventory/original/";

		if(file_exists($thubm_path.$inventory->campaign_image))
		{
			@unlink($thubm_path.$inventory->campaign_image);
		} 
		if(file_exists($medium_path.$inventory->campaign_image))
		{
			@unlink($medium_path.$inventory->campaign_image);
		}
		if(file_exists($original_path.$inventory->campaign_image))
		{
			@unlink($original_path.$inventory->campaign_image);
		}
		$inventory->delete();
		if($inventory->delete())
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
			$thumb_path= mkdir($folder_name."/inventory/thumb", 0777);
			$medium_path= mkdir($folder_name."/inventory/medium", 0777);
			$original_path= mkdir($folder_name."/inventory/original", 0777);
		}
		else
		{			
			$thumb_path= env('UPLOADS')."/inventory/thumb"."/";
			$medium_path= env('UPLOADS')."/inventory/medium"."/";
			$original_path= env('UPLOADS')."/inventory/original"."/";
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
		$inventory_name=$request->input('inventory_name');
		$sell_price=$request->input('sell_price');
		$cost=$request->input('cost');
		$inventory_image=$request->input('inventory_image');
		//dd("a");
		//dd($request->all());
		// Get current logged in user ID
		$created_by=Auth::user()->id;

		if($inventory_name=="" || $sell_price=="" || $cost=="")
		{
			return 'error';
		}
		else
		{
			$original_path= env('UPLOADS')."/inventory/original"."/".$inventory_image;
			if(file_exists($original_path))
			{
				$campaign = new Inventory();
				$campaign->inventory_name 		= $inventory_name;	
				$campaign->sell_price 		= $sell_price;
				$campaign->cost 		= $cost;	
				$campaign->inventory_image 		= $inventory_image;		
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
