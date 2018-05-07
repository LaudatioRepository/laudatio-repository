<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoardMessage extends Model
{
    public function messageboard() {
        return $this->belongsTo(MessageBoard::class);
    }

    public function getStatus($statusInteger) {
        $statuses = array(
            1 => "Pending",
            2 => "Assigned",
            3 => "Done"
        );
        return $statuses[$statusInteger];
    }
}
