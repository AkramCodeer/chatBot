<?php
// ----------------------------------------------------------------

namespace App\Http\Controllers\Api\V2\Auth;

use App\Http\Controllers\Controller; // Correct namespace for the base Controller
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V2\Ticket\CreateTicketRequest;

class CreateTicketController extends Controller 
{
    public function __invoke(LoginRequest $request): Response|Error
    {

        $ticket = Ticket::create([
            'subject' => $request->subject,
            'platform' => $request->platform,
            'message' => $request->message,
            'created_by' => auth()->id(),
        ]);

        return response()->json($ticket, 201);
    }
}