<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionGranted extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'manager_id',
        'status',
    ];
}
