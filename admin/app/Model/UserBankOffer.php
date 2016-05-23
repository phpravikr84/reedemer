<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//use App\Presenters\DatePresenter;

class UserBankOffer extends Model  {

	//use DatePresenter;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'reedemer_user_bank_offer';

 	
 	 public function userDetail() {
        return $this->hasMany('App\Model\UserBankOffer','offer_id','id')->select('id');
    }

}