<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = ['event_id', 'participant_name', 'email'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
