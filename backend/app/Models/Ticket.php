<?php
// app/Models/Ticket.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['platform','subject', 'message', 'created_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}