<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//use App\Presenters\DatePresenter;

class UserPassedOffer extends Model  {

	//use DatePresenter;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'reedemer_user_passed_offer';

 	 public function userDetail() {
        return $this->hasMany('App\Model\UserBankOffer','offer_id','id')->select('id');
    }

}