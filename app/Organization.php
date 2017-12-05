<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    /**
     * Get all of the owning Person models.
     */
    public function persons()
    {
        return $this->morphedByMany('\App\Person', 'organizable');
    }

    /**
     * Get all of the owning Editor models.
     */
    public function editors()
    {
        return $this->morphedByMany('\App\Editor', 'organizable');
    }

    /**
     * Get all of the owning Editor models.
     */
    public function authors()
    {
        return $this->morphedByMany('\App\Author', 'organizable');
    }
}
