<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessNotificationJob;

class NotificationController extends Controller
{
    public function receive(Request $request)
    {
        $validatedData = $request->validate([
            'payload' => 'required|array',
            'endpoint' => 'required|url',
        ]);

        ProcessNotificationJob::dispatch($validatedData['payload'], $validatedData['endpoint']);

        return response()->json(['status' => 'Solicitação processada.']);
    }
}
