<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $host, $action, $requests;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($host = null, $action = null, $requests = [])
    {
        $this->host = $host;
        $this->action = $action;
        $this->requests = $requests;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 这里就是异步队列了，请按照你的业务来写。

        return;
    }
}
