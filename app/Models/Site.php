<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'domain', 'php_version', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
