<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//use App\Presenters\DatePresenter;

class Logo extends Model  {

	//use DatePresenter;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'reedemer_logo';

 	/*public function reedemer()
	{
		return $this->belongsTo('App\User');
	}*/

	public function reedemer()
	{
		return $this->hasOne('App\User');
	}

}