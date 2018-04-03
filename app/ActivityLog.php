<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }
}
