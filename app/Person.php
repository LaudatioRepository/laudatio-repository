<?php
/**
 * Created by PhpStorm.
 * User: rolfguescini
 * Date: 28.11.17
 * Time: 16:13
 */

namespace App;


abstract class Person extends Eloquent
{
    protected $foreName = null;
    protected $lastName = null;
    protected $role = null;

    /**
     * Get the post that owns the comment.
     */
    public function post()
    {
        return $this->belongsTo(Organization::class);
    }
}