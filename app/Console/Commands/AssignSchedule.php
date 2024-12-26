<?php

namespace App\Console\Commands;

use App\Models\Admin\Employee;
use Illuminate\Console\Command;

class AssignSchedule extends Command
{
    protected $signature = 'assign:schedule';


    protected $description = 'Assign Daily Attendance Schedule for the Employee';
  
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // get all employee
        foreach(Employee::with('schedules')->get() as $employee) {

            // get all schedule by employee
            foreach($employee->schedules as $schedule) {

                // get the today schedule and assign a attendance schedule
                // time in & time out are nulled 
                if ($schedule->day_type == date('l')) {
                    \App\Models\Employee\Attendance::create(['schedule_id' => $schedule->id]);
                }
            }
        }

        return 1;
    }
}
