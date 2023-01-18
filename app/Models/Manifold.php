<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manifold extends Model
{

    /**
    * Get the Manifold that owns the Service.
    */
    public function entity()
    {
        return $this->belongsTo('App\Models\Entity');
    }

    /**
     * The users that belong to the role.
     */
    public function services()
    {
        return $this->belongsToMany(service::class, 'service_manifold');
    }

    /**
     * Get the Regions for the Manifold.
     */
    public function region()
    {
        return $this->belongsTo('App\Models\Region');
    }

}
