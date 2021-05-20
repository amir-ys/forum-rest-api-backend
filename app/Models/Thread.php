<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function channel()
    {
        $this->belongsTo(Channel::class);
    }

    public function answers()
    {
        $this->hasMany(Answer::class);
    }
}
