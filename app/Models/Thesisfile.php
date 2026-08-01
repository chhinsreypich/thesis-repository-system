<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thesisfile extends Model
{
    /** @use HasFactory<\Database\Factories\ThesisfileFactory> */
    use HasFactory;
    protected $fillable = [
        'thesis_id',
        'file_path',
    ];
    
    public function thesis()
    {
        return $this->belongsTo(Thesis::class, 'thesis_id');
    }

}
