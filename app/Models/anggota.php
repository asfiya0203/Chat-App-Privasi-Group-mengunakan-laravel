<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class anggota extends Model
{
    protected $fillable = ['percakapan_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
