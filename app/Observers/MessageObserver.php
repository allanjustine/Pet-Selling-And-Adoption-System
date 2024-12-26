<?php

namespace App\Observers;

use App\Models\Message;
use App\Services\ActivityLogsService;

class MessageObserver
{
    protected $service;

    public function __construct(ActivityLogsService $service)
    {
        $this->service = $service;
    }
    
    /**
     * Handle the Message "created" event.
     *
     * @param  \App\Models\Message  $message
     * @return void
     */
    public function created(Message $message)
    {
        $this->service->log_activity(model:$message, event:'sent', model_name:'Message', model_property_name: $message->message . "to" . $message->recipient->full_name);
    }

    /**
     * Handle the Message "updated" event.
     *
     * @param  \App\Models\Message  $message
     * @return void
     */
    public function updated(Message $message)
    {
        $this->service->log_activity(model:$message, event:'updated', model_name:'Message', model_property_name: $message->message . "to" . $message->recipient->full_name);
    }

    /**
     * Handle the Message "deleted" event.
     *
     * @param  \App\Models\Message  $message
     * @return void
     */
    public function deleted(Message $message)
    {
        $this->service->log_activity(model:$message, event:'deleted', model_name:'Message', model_property_name: $message->message . "to" . $message->recipient->full_name);
    }

    /**
     * Handle the Message "restored" event.
     *
     * @param  \App\Models\Message  $message
     * @return void
     */
    public function restored(Message $message)
    {
        //
    }

    /**
     * Handle the Message "force deleted" event.
     *
     * @param  \App\Models\Message  $message
     * @return void
     */
    public function forceDeleted(Message $message)
    {
        //
    }
}