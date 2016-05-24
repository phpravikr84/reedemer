<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Illuminate\Http\Response; 
use App\Model\User;
use App\Model\Video;
use App\Model\Directory;
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
		//dd("a");
		$html='<div>AAAA</div>';

		return $html;

	}

	public function postImageid(Request $request)
	{
		$user_id=Auth::User()->id;
		//dd($user_id);
		//dd($request->get('file_name'));
		$str=explode("filemanager/userfiles/",$request->get('file_name'));
		$str_value=explode("/",$str[1]);		
		// Get name of image
		$image_name=array_pop($str_value);

		//$last_ele_len=strlen($image_name);
		//$base_dir=substr($str[1], 0, $last_ele_len-4);
		//$base=env('UPLOADS')."/".$base_dir;
		//dd($str[1]);
		$str_wot_name=rtrim(str_replace($image_name, '', $str[1]),"/");
		$base=env('UPLOADS')."/".$str_wot_name;
		//dd($base);
		$directory=Directory::where('created_by',$user_id)
		   		   ->where('file_name',$image_name)
		 		   ->where('directory_base_path',$base)
		 		   ->first();
		$id=$directory->id;
		//dd($id);
		return $id;
	}

	public function postStoreoffer(Request $request)
	{	
		//return view('welcome');
		//dd($request->get('campaign_id'));
		$user_id=Auth::User()->id;

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
		$product_id_str=$request->get('product_id_str');

		$camp_img_id=$request->get('camp_img_id');

		
		$choose_image=$request->get('choose_image');

		$logo=Logo::where('reedemer_id',$user_id)->first();
		if($choose_image==1)
		{
			$directory=Directory::find($camp_img_id);

			
			$directory_base_path=$directory->directory_base_path;

			$logo_image_path=env("UPLOADS")."/thumb/".$logo->logo_name;
			$offer_image_old=$directory->file_name;
			$offer_image_path_old=$directory_base_path."/".$offer_image_old;

			$ext = pathinfo($offer_image_path_old, PATHINFO_EXTENSION);

			$source_file=$offer_image_path_old;
			$offer_image_name="offer_".time().rand(99,99999).$user_id.".".$ext;

			$output_file_path="../uploads/offer/".$offer_image_name;

			// dd($offer_image_old);
			$this->watermark($source_file, $output_file_path, $logo_image_path);

			$offer_image=$offer_image_name;
			$offer_image_path=env("IMAGE_URL")."uploads/offer/".$offer_image;
			// $output_file_path=$directory->directory_url;
		}
		else
		{
			
		
			
			//dd($logo->logo_name);
			//return $logo->logo_name;

			$offer_image=$logo->logo_name;
			$offer_image_path=env("IMAGE_URL")."uploads/original/".$offer_image;

			//$thumb=$this->create_thumb($src, $dest, $desired_width);
			
		}
		//dd($offer_image);
		//die();
		//dd($directory->toArray());
		// $stamp="/var/www/html/reedemer/admin/uploads/original/1462173863_896650352.jpg"; // Logo
		// $image="/var/www/html/reedemer/admin/uploads/original/1462188492_947739140.jpg"; //Image
		// $newcopy='/var/www/html/reedemer/filemanager/userfiles/aa.jpg';

		// $watermark=$this->watermark($image, $stamp, $newcopy);
		//dd($watermark);

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
		$offer->offer_image 			= $offer_image;	
		$offer->offer_image_path 		= $offer_image_path;	
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

	function watermark($source_file_path, $output_file_path, $stamp)
	{
		define('WATERMARK_OVERLAY_IMAGE', $stamp);
		define('WATERMARK_OVERLAY_OPACITY', 80);
		define('WATERMARK_OUTPUT_QUALITY', 90);

		list($source_width, $source_height, $source_type) = getimagesize($source_file_path);
	    if ($source_type === NULL) {
	        return false;
	    }
	    switch ($source_type) {
	        case IMAGETYPE_GIF:
	            $source_gd_image = imagecreatefromgif($source_file_path);
	            break;
	        case IMAGETYPE_JPEG:
	            $source_gd_image = imagecreatefromjpeg($source_file_path);
	            break;
	        case IMAGETYPE_PNG:
	            $source_gd_image = imagecreatefrompng($source_file_path);
	            break;
	        default:
	            return false;
	    }
	    $overlay_gd_image = imagecreatefromjpeg(WATERMARK_OVERLAY_IMAGE);
	     $overlay_width = imagesx($overlay_gd_image);
	     $overlay_height = imagesy($overlay_gd_image);
	    //$overlay_width = 100;
	    //$overlay_height = 100;
	    imagecopymerge(
	        $source_gd_image,
	        $overlay_gd_image,
	        10,  //x position
	        10,  //y position
	        0,
	        0,
	        $overlay_width,
	        $overlay_height,
	        WATERMARK_OVERLAY_OPACITY
	    );
	    imagejpeg($source_gd_image, $output_file_path, WATERMARK_OUTPUT_QUALITY);
	    imagedestroy($source_gd_image);
	    imagedestroy($overlay_gd_image);
	}

	

	public function getFolderid()
	{
		
		$id=Auth::User()->id;

		return $id;
	}

	public function postLogolist()
	{
		$user_id=Auth::User()->id;
		
		$logo=Logo::where('reedemer_id',$user_id)->first();
		//dd($logo->logo_name);
		return $logo->logo_name;
	}
	

	
}
