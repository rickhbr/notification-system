<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ProcessNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $payload;
    protected $endpoint;
    protected $returnResponse;

    /**
     * Cria uma nova instância do Job.
     *
     * @return void
     */
    public function __construct($payload, $endpoint, $returnResponse = false)
    {
        $this->payload = $payload;
        $this->endpoint = $endpoint;
        $this->returnResponse = $returnResponse;
    }

    /**
     * Executa o Job.
     *
     * @return void
     */
    public function handle()
    {
        // Envia a solicitação para o endpoint com o payload
        $response = Http::post($this->endpoint, $this->payload);

        // Se o endpoint quer o retorno, envia de volta
        if ($this->returnResponse) {
            Http::post($this->endpoint, [
                'status' => 'processed',
                'response_code' => $response->status(),
                'response_body' => $response->body()
            ]);
        }
    }
}
