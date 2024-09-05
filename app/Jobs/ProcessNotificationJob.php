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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($payload, $endpoint)
    {
        $this->payload = $payload;
        $this->endpoint = $endpoint;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Enviar a solicitação HTTP para o endpoint com o payload
        Http::post($this->endpoint, $this->payload);
    }
}
