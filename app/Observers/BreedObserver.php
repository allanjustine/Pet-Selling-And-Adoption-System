<?php

namespace App\Observers;

use App\Models\Breed;
use App\Services\ActivityLogsService;

class BreedObserver
{
    protected $service;

    public function __construct(ActivityLogsService $service)
    {
        $this->service = $service;
    }
    
    /**
     * Handle the Breed "created" event.
     *
     * @param  \App\Models\Breed  $breed
     * @return void
     */
    public function created(Breed $breed)
    {
        $this->service->log_activity(model:$breed, event:'added', model_name:'Breed', model_property_name: $breed->name);
    }

    /**
     * Handle the Breed "updated" event.
     *
     * @param  \App\Models\Breed  $breed
     * @return void
     */
    public function updated(Breed $breed)
    {
        $this->service->log_activity(model:$breed, event:'updated', model_name:'Breed', model_property_name: $breed->name);
    }

    /**
     * Handle the Breed "deleted" event.
     *
     * @param  \App\Models\Breed  $breed
     * @return void
     */
    public function deleted(Breed $breed)
    {
        $this->service->log_activity(model:$breed, event:'deleted', model_name:'Breed', model_property_name: $breed->name);
    }

    /**
     * Handle the Breed "restored" event.
     *
     * @param  \App\Models\Breed  $breed
     * @return void
     */
    public function restored(Breed $breed)
    {
        //
    }

    /**
     * Handle the Breed "force deleted" event.
     *
     * @param  \App\Models\Breed  $breed
     * @return void
     */
    public function forceDeleted(Breed $breed)
    {
        //
    }
}