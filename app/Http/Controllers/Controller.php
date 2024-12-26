<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  
    /**
     * throw a request->all() message
     *
     * @param [type] $message
     * @param integer $code
     * @return void
     */
    public function all()
    {
        return $this->res(request()->all());
    }

    /**
     * throw a custom response message
     *
     * @param [type] $message
     * @param integer $code
     * @return void
     */
    public function res($data)
    {
        return response()->json($data,201);
    }

    /**
     * throw a custom error message
     *
     * @param [type] $message
     * @param integer $code
     * @return void
     */
    public function error($message, $code = 401)
    {
        abort($code, $message);
    }

    /**
     * log user activites
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