<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    /**
     * Get the comments for the blog post.
     */
    public function persons()
    {
        return $this->hasMany(Person::class);
    }
}
