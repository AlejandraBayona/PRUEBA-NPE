<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
     /**
    * Get the Department that owns the Municipality.
    */
   public function departament()
   {
       return $this->belongsTo('App\Models\Departament');
   }
}
