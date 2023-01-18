<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    /**
    * Get the Region that owns the Department.
    */
   public function region()
   {
       return $this->belongsTo('App\Models\Region');
   }

   /**
     * Get the Municipalities for the Department.
     */
    public function municipalities()
    {
        return $this->hasMany('App\Models\Municipality');
    }
}
