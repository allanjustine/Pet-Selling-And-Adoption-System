<?php

namespace App\Observers;

use App\Models\Comment;
use App\Services\ActivityLogsService;

class CommentObserver
{
    protected $service;

    public function __construct(ActivityLogsService $service)
    {
        $this->service = $service;
    }
    
    /**
     * Handle the Comment "created" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function created(Comment $comment)
    {
        $this->service->log_activity(model:$comment, event:'added', model_name:'Comment', model_property_name: $comment->comment . "to pet" . $comment->pet->name);
    }

    /**
     * Handle the Comment "updated" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function updated(Comment $comment)
    {
        $this->service->log_activity(model:$comment, event:'updated', model_name:'Comment', model_property_name: $comment->comment . "to pet" . $comment->pet->name);
    }

    /**
     * Handle the Comment "deleted" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function deleted(Comment $comment)
    {
        $this->service->log_activity(model:$comment, event:'deleted', model_name:'Comment', model_property_name: $comment->comment . "to pet" . $comment->pet->name);
    }

    /**
     * Handle the Comment "restored" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function restored(Comment $comment)
    {
        //
    }

    /**
     * Handle the Comment "force deleted" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function forceDeleted(Comment $comment)
    {
        //
    }
}