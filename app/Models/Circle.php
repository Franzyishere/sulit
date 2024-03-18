<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circle extends Model
{
    use HasFactory;

    protected $fillable = [
        'circle_name',
        'creator_circle',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_circle');
    }

    // public function members()
    // {
    //     return $this->belongsToMany(User::class, 'circle_members');
    // }
}