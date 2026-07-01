<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportMessage extends Model
{
    protected $fillable = ['name', 'email', 'subject', 'message', 'category', 'status', 'attachment_path', 'is_notified'];
}