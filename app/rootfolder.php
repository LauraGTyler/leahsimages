<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rootfolder extends Model
{
    protected $table='rootfolder';
    protected $primaryKey = 'divisionid';

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
