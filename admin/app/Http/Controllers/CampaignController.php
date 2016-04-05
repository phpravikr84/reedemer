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


class campaignController extends Controller {
	
	

	public function getList($id = Null)
	{
		//dd("a");
		$campaign=Campaign::where('status',1)->get();
		//dd($campaign->toArray());	
		return $campaign;	
	}

	public function getDelete($id = Null)
	{
		$campaign = Campaign::find($id);

		$campaign->delete();
		
		
		if($campaign->delete())
		{
			return 'success';
		}	
	}

	
}
