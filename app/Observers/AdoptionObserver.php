<?php

namespace App\Observers;

use App\Models\Adoption;
use App\Services\ActivityLogsService;

class AdoptionObserver
{
    protected $service;

    public function __construct(ActivityLogsService $service)
    {
        $this->service = $service;
    }
    
    /**
     * Handle the Adoption "created" event.
     *
     * @param  \App\Models\Adoption  $adoption
     * @return void
     */
    public function created(Adoption $adoption)
    {
        $this->service->log_activity(model:$adoption, event:'added', model_name:'Pet for Adoption', model_property_name: $adoption->pet_name);
    }

    /**
     * Handle the Adoption "updated" event.
     *
     * @param  \App\Models\Adoption  $adoption
     * @return void
     */
    public function updated(Adoption $adoption)
    {
        $this->service->log_activity(model:$adoption, event:'updated', model_name:'Pet for Adoption', model_property_name: $adoption->pet_name);
    }

    /**
     * Handle the Adoption "deleted" event.
     *
     * @param  \App\Models\Adoption  $adoption
     * @return void
     */
    public function deleted(Adoption $adoption)
    {
        $this->service->log_activity(model:$adoption, event:'deleted', model_name:'Pet for Adoption', model_property_name: $adoption->pet_name);
    }

    /**
     * Handle the Adoption "restored" event.
     *
     * @param  \App\Models\Adoption  $adoption
     * @return void
     */
    public function restored(Adoption $adoption)
    {
        //
    }

    /**
     * Handle the Adoption "force deleted" event.
     *
     * @param  \App\Models\Adoption  $adoption
     * @return void
     */
    public function forceDeleted(Adoption $adoption)
    {
        //
    }
}