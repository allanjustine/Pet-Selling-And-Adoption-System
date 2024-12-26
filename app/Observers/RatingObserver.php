<?php

namespace App\Observers;

use App\Models\Rating;
use App\Services\ActivityLogsService;

class RatingObserver
{
    protected $service;

    public function __construct(ActivityLogsService $service)
    {
        $this->service = $service;
    }
    
    /**
     * Handle the Rating "created" event.
     *
     * @param  \App\Models\Rating  $rating
     * @return void
     */
    public function created(Rating $rating)
    {
        $this->service->log_activity(model:$rating, event:'sent', model_name:'Rating', model_property_name: $rating->comment . "to" . $rating->receiver->full_name);
    }

    /**
     * Handle the Rating "updated" event.
     *
     * @param  \App\Models\Rating  $rating
     * @return void
     */
    public function updated(Rating $rating)
    {
        $this->service->log_activity(model:$rating, event:'updated', model_name:'Rating', model_property_name: $rating->comment . "to" . $rating->receiver->full_name);
    }

    /**
     * Handle the Rating "deleted" event.
     *
     * @param  \App\Models\Rating  $rating
     * @return void
     */
    public function deleted(Rating $rating)
    {
        $this->service->log_activity(model:$rating, event:'deleted', model_name:'Rating', model_property_name: $rating->comment . "to" . $rating->receiver->full_name);
    }

    /**
     * Handle the Rating "restored" event.
     *
     * @param  \App\Models\Rating  $rating
     * @return void
     */
    public function restored(Rating $rating)
    {
        //
    }

    /**
     * Handle the Rating "force deleted" event.
     *
     * @param  \App\Models\Rating  $rating
     * @return void
     */
    public function forceDeleted(Rating $rating)
    {
        //
    }
}