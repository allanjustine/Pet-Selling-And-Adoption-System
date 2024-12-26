<?php 

namespace App\Services;


class ActivityLogsService 
{
/**
 * handle system activity logs
 *
 * @param [type] $model
 * @param [type] $event
 * @param [type] $model_name
 * @param string $model_property_name
 * @param string $conjunction
 * @return void
 */
  public function log_activity($model, $event, $model_name, $model_property_name = '', $conjunction = 'a', $end_user = "Administrator")
  {
      $user = auth()->user();

      $name = $end_user ?? $user->full_name;
      activity()
      ->causedBy($user)
      ->performedOn($model)
      ->withProperties(['ip' => request()->ip()])
      ->log("$name has $event $conjunction $model_name - $model_property_name");
  }
  
}