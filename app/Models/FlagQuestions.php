<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlagQuestions extends Model
{
    protected $primaryKey = 'flag_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'flag_id', 'title', 'description', 'attachment'
    ];
}