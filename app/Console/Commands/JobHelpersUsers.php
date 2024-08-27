<?php

namespace App\Console\Commands;

use App\Events\FCMNotificationEvent;
use App\Models\Helpers;
use App\Models\Job;
use App\Models\Checkout;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class JobHelpersUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobsHour:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Helper User Jobs Update';

    /**
     * Create a new command instance.
     *
     * @return void
     */
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
        Log::info('every minute cron');
        $jobs =  Checkout::with('job', 'job.job_helpers', 'job.user', 'job.user.company')->where(['status' => 'pending'])->get();
        foreach ($jobs as $job) {
            $job_helpers = $job->total_helpers;
            $accpted_helper = count($job->job->job_helpers) - 1;
            if ($accpted_helper < $job_helpers) {
                $reciever = User::find($job->user_id);
                $start_date_time = strtotime($job->job->start_time);
                $current_date_time = time();
                $total_time = ($current_date_time - $start_date_time) / (60); //add 3600 instead 60 if hour 
                if ($total_time > 45 && $reciever) {
                    event(new FCMNotificationEvent("The Job '" . $job->name . "'" . " Is not with enough helper if you want to continue.....", "Job Pending", "https://grid.gograph.com/driver-in-front-of-school-bus-vector-art_gg57726891.jpg", [$reciever]));
                }
            }
        }
        return 0;
    }
}
