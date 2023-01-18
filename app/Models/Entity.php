<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    /**
     * Get the Transactions for the Entity.
     */
    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    /**
     * Get the Manifolds for the Entity.
     */
    public function manifolds()
    {
        return $this->hasMany('App\Models\Manifold');
    }

     /**
     * Get the CollectorSites for the Entity.
     */
    public function collectorSites()
    {
        return $this->hasMany('App\Models\CollectorSite');
    }
}
