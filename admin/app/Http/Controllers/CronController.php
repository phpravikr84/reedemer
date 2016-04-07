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


class CronController extends Controller {	
	

	public function getUpdaterating($id = Null)
	{		
		//dd("A");
		$logo=Logo::where('tracking_rating','<','0')->get();
		$logo_details=json_decode($logo);

		$client = new vuforiaclient();
		foreach($logo_details as $logo)
		{
			$target_res_details=$client->getTarget($logo->target_id); 
			//echo $logo->target_id."<br>";
			dd($target_res_details->target_record);
		}
		//return $logo;

		//getVuforiarate
	}

	
}
