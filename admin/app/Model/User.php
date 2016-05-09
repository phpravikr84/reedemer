<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//use App\Presenters\DatePresenter;

class User extends Model  {

	//use DatePresenter;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

 	public function profile()
	{
		return $this->hasOne('App\Model\Logo');
	}

  
	 //self::deleting(function($user) { // before delete() method call this
        //     $user->photos()->delete();
             // do the rest of the cleanup...
      //  });
	//

}