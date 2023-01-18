<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectorSite extends Model
{
    /**
    * Get the CollectorSite that owns the Entity.
    */
    public function entity()
    {
        return $this->belongsTo('App\Models\Entity');
    }
}
