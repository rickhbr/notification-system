<?php

require __DIR__.'/../vendor/autoload.php';

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\App;

$app = require_once __DIR__.'/../bootstrap/app.php';
App::setFacadeApplication($app);

$numRequests = 100;

$startTime = microtime(true);

for ($i = 0; $i < $numRequests; $i++) {
    $response = Http::post('http://localhost:8000/api/send-notification', [
        'payload' => [
            'message' => "Esta é uma mensagem de teste para o usuário $i"
        ],
        'endpoint' => 'http://localhost:8001/api/receive'
    ]);

    if ($response->failed()) {
        echo "Falha ao enviar a solicitação $i \n";
    } else {
        echo "Solicitação $i enviada com sucesso. \n";
    }
}

$endTime = microtime(true);

$totalTime = $endTime - $startTime;

echo "Tempo total para enviar $numRequests solicitações: " . $totalTime . " segundos.\n";
