<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;

class ActivityLogController extends Controller
{
    public function __invoke()
    {
        if(request()->ajax())
        {
            return DataTables::of(Activity::latest()->get())
            ->addIndexColumn()
            ->make(true);
        }
        
        return view('admin.activitylog.index');  
    }
}