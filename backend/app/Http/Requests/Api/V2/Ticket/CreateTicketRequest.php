<?php
// app/Models/Ticket.php

namespace App\Http\Requests\Api\V2\Ticket;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreateTicketRequest extends Model
{
    use HasFactory;

    protected $fillable = ['platform','subject', 'message', 'created_by'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}