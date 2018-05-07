<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoardMessage extends Model
{
    public function messageboard() {
        return $this->belongsTo(MessageBoard::class);
    }
}
