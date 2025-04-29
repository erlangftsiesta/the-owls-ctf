<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAnswers extends Model
{
    protected $fillable = [
        'username',
        'flag',
        'status',
        'points',
    ];

    protected $casts = [
        'status' => 'boolean',
        'points' => 'integer',
    ];

    // Relasi ke model User (asumsi modelnya bernama User, dan username adalah primary)
    public function user()
    {
        return $this->belongsTo(Users::class, 'username', 'username');
    }
}