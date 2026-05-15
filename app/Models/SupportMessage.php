<?php
// app/Models/SupportMessage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'subject', 'message', 'status'
    ];

    protected $casts = [
        'status' => 'string',
    ];
}