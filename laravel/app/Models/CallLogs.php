<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallLogs extends Model
{
    use HasFactory;
    protected $fillable = [
        'calldate',
        'cnam',
        'dst',
        'dcontext',
        'disposition',
        'duration'
    ];
}
