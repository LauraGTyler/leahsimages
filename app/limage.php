<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class limage extends Model
{
protected $table='image';

   /**
	 * Overide set the value of "created at"
	 *
	 * @param  mixed  $value
	 * @return void
	 */
	public function setCreatedAt($value)
	{
		//do nothing
	}

	/**
	 * Overide set the value of the "updated at"
	 *
	 * @param  mixed  $value
	 * @return void
	 */
	public function setUpdatedAt($value)
	{
		//do nothing
	}
        
        public function usesTimestamps()
        {
            return false;
        }
    
}

?>