<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hod extends Model
{
    /** @use HasFactory<\Database\Factories\HodFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'dept_id',
        'username',
        'year',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id', 'id');
    }
}
