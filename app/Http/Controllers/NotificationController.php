<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessNotificationJob;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function receive(Request $request)
    {
        // Valida os dados da solicitação
        $validatedData = $request->validate([
            'payload' => 'required|array',
            'endpoint' => 'required|url',
            'schedule_for' => 'nullable|date', // Hora marcada opcional
            'return_response' => 'nullable|boolean', // Se o endpoint quer retorno
        ]);

        // Verifica se o processamento será instantâneo ou agendado
        if (!empty($validatedData['schedule_for'])) {
            $scheduleAt = Carbon::parse($validatedData['schedule_for']);
            ProcessNotificationJob::dispatch($validatedData['payload'], $validatedData['endpoint'], $validatedData['return_response'])
                                  ->delay($scheduleAt); // Agendamento
        } else {
            ProcessNotificationJob::dispatch($validatedData['payload'], $validatedData['endpoint'], $validatedData['return_response']); // Instantâneo
        }

        return response()->json(['status' => 'Solicitação recebida.']);
    }
}
