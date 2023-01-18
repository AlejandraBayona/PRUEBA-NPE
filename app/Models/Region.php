<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    /**
     * Get the regions for the manifold.
     */
    public function manifolds()
    {
        return $this->hasMany('App\Models\Manifold');
    }

   /**
     * Get the Departments for the Region.
     */
    public function departments()
    {
        return $this->hasMany('App\Models\Department');
    }
}
