<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//use App\Presenters\DatePresenter;

class Offer extends Model  {

	//use DatePresenter;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'reedemer_offer';

	
	public function inventorys()
    {
        return $this->hasOne('App\Model\Inventory');
    }

	public function campaignDetails()
    {
        return $this->hasOne('App\Model\Campaign','id','campaign_id');
    }

    public function categoryDetails()
    {
        return $this->hasOne('App\Model\Category','id','cat_id');
    }

     public function subCategoryDetails()
    {
        return $this->hasOne('App\Model\Category','id','subcat_id');
    }

    // public function offerDetails()
    // {
    //     //return $this->hasMany('App\Model\cccc','offer_id','id');

    //      return $this->hasMany('App\Model\OfferDetail','offer_id','id');
    // }

     public function partnerSettings()
    {

    	 return $this->hasOne('App\Model\Partnersetting','created_by','created_by');
       
    }
    
    // public function offerDetail()
    // {
    //     return $this->morphToMany('App\Model\Inventory', 'App\Model\OfferDetail')->withPivot('inventory_id'

    //     	);
    // }
    public function offerDetail() {
        return $this->hasMany('App\Model\OfferDetail','offer_id','id');
    }
   
 	
}