<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ThesisRequest extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'user_id',
        'dept_id',
        'title',
        'abstract',
        'description',
        'submission_date',
        'image',
        'pdf_file',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }
}
