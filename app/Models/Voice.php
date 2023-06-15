<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voice extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=[
      'user_id',
      'voice'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}