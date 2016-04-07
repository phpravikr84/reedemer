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
		$logo=Logo::where('tracking_rating','<','0')->get()->toArray();
		dd($logo['id']);
		//return $logo;

		//getVuforiarate
	}

	
}
