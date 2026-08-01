<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thesis extends Model
{
    /** @use HasFactory<\Database\Factories\ThesisFactory> */
    use HasFactory;
    protected $fillable = [
        'title',
        'dept_id',
        'abstract',
        'description',
        'posted_by',
        'verify_by',
        'submission_date',
        'image',
    ];

    public function file()
    {
        return $this->hasOne(Thesisfile::class, 'thesis_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function hod()
    {
        return $this->belongsTo(Hod::class, 'verify_by');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id', 'id');
    }
}
