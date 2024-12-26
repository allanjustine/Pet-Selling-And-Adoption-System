<?php

namespace App\Observers;

use App\Models\SellerAccount;
use App\Services\ActivityLogsService;

class SellerAccountObserver
{
    protected $service;

    public function __construct(ActivityLogsService $service)
    {
        $this->service = $service;
    }
    
    /**
     * Handle the SellerAccount "created" event.
     *
     * @param  \App\Models\SellerAccount  $sellerAccount
     * @return void
     */
    public function created(SellerAccount $sellerAccount)
    {
        $this->service->log_activity(model:$sellerAccount, event:'added', model_name:'Seller Account', model_property_name: $sellerAccount->business_name);
    }

    /**
     * Handle the SellerAccount "updated" event.
     *
     * @param  \App\Models\SellerAccount  $sellerAccount
     * @return void
     */
    public function updated(SellerAccount $sellerAccount)
    {
        $this->service->log_activity(model:$sellerAccount, event:'updated', model_name:'Seller Account', model_property_name: $sellerAccount->business_name);
    }

    /**
     * Handle the SellerAccount "deleted" event.
     *
     * @param  \App\Models\SellerAccount  $sellerAccount
     * @return void
     */
    public function deleted(SellerAccount $sellerAccount)
    {
        $this->service->log_activity(model:$sellerAccount, event:'deleted', model_name:'Seller Account', model_property_name: $sellerAccount->business_name);
    }

    /**
     * Handle the SellerAccount "restored" event.
     *
     * @param  \App\Models\SellerAccount  $sellerAccount
     * @return void
     */
    public function restored(SellerAccount $sellerAccount)
    {
        //
    }

    /**
     * Handle the SellerAccount "force deleted" event.
     *
     * @param  \App\Models\SellerAccount  $sellerAccount
     * @return void
     */
    public function forceDeleted(SellerAccount $sellerAccount)
    {
        //
    }
}