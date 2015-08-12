<?php

namespace App\Jobs;

use App\Jobs\Job;

use App\Services\PaymentService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ExecutePayment extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    protected  $order;

    /**
     * Create a new job instance.
     * @param $order
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @param PaymentService $Paypal
     */
    public function handle(PaymentService $Paypal)
    {
        $response = $Paypal->executePayment($this->order->payKey);
        Log::info('Paypal execute payment job started. PayKey:'.$this->order->payKey.' OrderID: '.$this->order->id);
        if($response['Ack'] == 'Success' && $response['PaymentExecStatus'] == 'COMPLETED'){
            Log::info('OrderID: '.$this->order->id.' Execute payment: Paypal Response is okay.');
        }
        else{
            Log::info('Job runned, but something happened to PayPal, ERROR');
        }
        //Log::info($response);
    }
}
