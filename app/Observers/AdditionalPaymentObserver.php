<?php

namespace App\Observers;

use App\Models\AdditionalPayment;
use App\Services\ActivityLogsService;

class AdditionalPaymentObserver
{
    protected $service;

    public function __construct(ActivityLogsService $service)
    {
        $this->service = $service;
    }
    
    
    /**
     * Handle the AdditionalPayment "created" event.
     *
     * @param  \App\Models\AdditionalPayment  $additionalPayment
     * @return void
     */
    public function created(AdditionalPayment $additionalPayment)
    {
        $this->service->log_activity(model:$additionalPayment, event:'added', model_name:'Additional Payment', model_property_name: $additionalPayment->transaction_no);
    }

    /**
     * Handle the AdditionalPayment "updated" event.
     *
     * @param  \App\Models\AdditionalPayment  $additionalPayment
     * @return void
     */
    public function updated(AdditionalPayment $additionalPayment)
    {
        $this->service->log_activity(model:$additionalPayment, event:'updated', model_name:'Additional Payment', model_property_name: $additionalPayment->transaction_no);
    }

    /**
     * Handle the AdditionalPayment "deleted" event.
     *
     * @param  \App\Models\AdditionalPayment  $additionalPayment
     * @return void
     */
    public function deleted(AdditionalPayment $additionalPayment)
    {
        $this->service->log_activity(model:$additionalPayment, event:'deleted', model_name:'Additional Payment', model_property_name: $additionalPayment->transaction_no);
    }

    /**
     * Handle the AdditionalPayment "restored" event.
     *
     * @param  \App\Models\AdditionalPayment  $additionalPayment
     * @return void
     */
    public function restored(AdditionalPayment $additionalPayment)
    {
        //
    }

    /**
     * Handle the AdditionalPayment "force deleted" event.
     *
     * @param  \App\Models\AdditionalPayment  $additionalPayment
     * @return void
     */
    public function forceDeleted(AdditionalPayment $additionalPayment)
    {
        //
    }
}