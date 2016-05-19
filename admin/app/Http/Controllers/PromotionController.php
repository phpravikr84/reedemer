<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Http\Response; 
use App\Model\User;
use App\Model\Video;
use App\Model\Offer;
use Hash;
use Validator;
use App\Model\Logo;
use App\Helper\vuforiaclient;
use App\Helper\helpers;
use Auth; 
use Session ;
use App\Model\Campaign;
use App\Model\Inventory;


class PromotionController extends Controller {	
	
	
	public function __construct( )
	{
		if($this->middleware('auth'))
		//if(!Auth::user()->id)
		{
			Auth::logout();
    		return redirect('auth/login');	
    	}
		
	}

	public function getIndex()
	{	
		//return view('welcome');
		dd("a");
	}

	public function postStoreoffer(Request $request)
	{	
		//return view('welcome');
		//dd($request->get('campaign_id'));
		$campaign_id=$request->get('campaign_id');
		$category_id=$request->get('category_id');
		$subcat_id=$request->get('subcat_id');
		$offer_description=$request->get('offer_description');
		$total_redeemar=$request->get('total_redeemar');
		$total_redeemar_price=$request->get('total_redeemar_price');
		$c_s_date=$request->get('c_s_date');
		$c_e_date=$request->get('c_e_date');
		$total_payment=$request->get('total_payment');
		if($total_payment==0.65)
		{
			$pay=1;
		}
		else
		{
			$pay=2;	
		}
		$what_you_get=$request->get('what_you_get');
		$more_information=$request->get('more_information');
		$created_by=Auth::user()->id;
		$pay_value=$request->get('pay_value');
		$retails_value=$request->get('retails_value');
		$include_product_value=$request->get('include_product_value');
		$discount=$request->get('discount');
		$value_calculate=$request->get('value_calculate');

		$offer = new Offer();
		$offer->campaign_id				= $campaign_id;			
		$offer->cat_id 					= $category_id;	
		$offer->subcat_id 				= $subcat_id;	
		$offer->offer_description 		= $offer_description;	
		$offer->max_redeemar 			= $total_redeemar;	
		$offer->price 					= $total_redeemar_price;	
		$offer->pay 					= $pay;	
		$offer->start_date 				= $c_s_date;
		$offer->end_date 				= $c_e_date;			
		$offer->what_you_get 			= $what_you_get;		
		$offer->more_information 		= $more_information;
		$offer->pay_value 				= $pay_value;
		$offer->retails_value 			= $retails_value;
		$offer->include_product_value 	= $include_product_value;
		$offer->discount 				= $discount;
		$offer->value_calculate 		= $value_calculate;
		$offer->created_by 				= $created_by;	
		if($offer->save())
		{
			return 'success';
		}
		else
		{
			return 'error';
		}
	}

	

	
}
