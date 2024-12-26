<?php

namespace App\Observers;

use App\Models\PaymentMethod;
use App\Services\ActivityLogsService;

class PaymentMethodObserver
{
    protected $service;

    public function __construct(ActivityLogsService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle the PaymentMethod "created" event.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return void
     */
    public function created(PaymentMethod $paymentMethod)
    {
        $this->service->log_activity(model:$paymentMethod, event:'added', model_name:'Payment Method', model_property_name: $paymentMethod->name);
    }

    /**
     * Handle the PaymentMethod "updated" event.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return void
     */
    public function updated(PaymentMethod $paymentMethod)
    {
        $this->service->log_activity(model:$paymentMethod, event:'updated', model_name:'Payment Method', model_property_name: $paymentMethod->name);
    }

    /**
     * Handle the PaymentMethod "deleted" event.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return void
     */
    public function deleted(PaymentMethod $paymentMethod)
    {
        $this->service->log_activity(model:$paymentMethod, event:'deleted', model_name:'Payment Method', model_property_name: $paymentMethod->name);
    }

    /**
     * Handle the PaymentMethod "restored" event.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return void
     */
    public function restored(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Handle the PaymentMethod "force deleted" event.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return void
     */
    public function forceDeleted(PaymentMethod $paymentMethod)
    {
        //
    }
}