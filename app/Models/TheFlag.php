<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TheFlag extends Model
{
    protected $fillable = [
        'flag_id', 'the_flag'
    ];

    public function flagQuestion()
    {
        return $this->belongsTo(FlagQuestion::class, 'flag_id', 'flag_id');
    }
}
