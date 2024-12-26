<?php

namespace App\Observers;

use App\Models\Pet;
use App\Services\ActivityLogsService;

class PetObserver
{
    protected $service;

    public function __construct(ActivityLogsService $service)
    {
        $this->service = $service;
    }
    
    /**
     * Handle the Pet "created" event.
     *
     * @param  \App\Models\Pet  $pet
     * @return void
     */
    public function created(Pet $pet)
    {
        $this->service->log_activity(model:$pet, event:'added', model_name:'Pet', model_property_name: $pet->name);
    }

    /**
     * Handle the Pet "updated" event.
     *
     * @param  \App\Models\Pet  $pet
     * @return void
     */
    public function updated(Pet $pet)
    {
        $this->service->log_activity(model:$pet, event:'updated', model_name:'Pet', model_property_name: $pet->name);
    }

    /**
     * Handle the Pet "deleted" event.
     *
     * @param  \App\Models\Pet  $pet
     * @return void
     */
    public function deleted(Pet $pet)
    {
        $this->service->log_activity(model:$pet, event:'deleted', model_name:'Pet', model_property_name: $pet->name);
    }

    /**
     * Handle the Pet "restored" event.
     *
     * @param  \App\Models\Pet  $pet
     * @return void
     */
    public function restored(Pet $pet)
    {
        //
    }

    /**
     * Handle the Pet "force deleted" event.
     *
     * @param  \App\Models\Pet  $pet
     * @return void
     */
    public function forceDeleted(Pet $pet)
    {
        //
    }
}