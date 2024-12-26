<?php

namespace App\Observers;

use App\Models\Like;
use App\Services\ActivityLogsService;

class LikeObserver
{
    protected $service;

    public function __construct(ActivityLogsService $service)
    {
        $this->service = $service;
    }
    
    /**
     * Handle the Like "created" event.
     *
     * @param  \App\Models\Like  $like
     * @return void
     */
    public function created(Like $like)
    {
        $this->service->log_activity(model:$like, event:'submitted', model_name:'Like', model_property_name: $like->comment . "to pet" . $like->pet->name);
    }

    /**
     * Handle the Like "updated" event.
     *
     * @param  \App\Models\Like  $like
     * @return void
     */
    public function updated(Like $like)
    {
        $this->service->log_activity(model:$like, event:'updated', model_name:'Like', model_property_name: $like->comment . "to pet" . $like->pet->name);
    }

    /**
     * Handle the Like "deleted" event.
     *
     * @param  \App\Models\Like  $like
     * @return void
     */
    public function deleted(Like $like)
    {
        $this->service->log_activity(model:$like, event:'deleted', model_name:'Like', model_property_name: $like->comment . "to pet" . $like->pet->name);
    }

    /**
     * Handle the Like "restored" event.
     *
     * @param  \App\Models\Like  $like
     * @return void
     */
    public function restored(Like $like)
    {
        //
    }

    /**
     * Handle the Like "force deleted" event.
     *
     * @param  \App\Models\Like  $like
     * @return void
     */
    public function forceDeleted(Like $like)
    {
        //
    }
}