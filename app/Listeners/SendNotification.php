<?php

namespace App\Listeners;

use App\Events\FCMNotificationEvent;
use App\Notifications\GeneralNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Exception;


class SendNotification implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\FCMNotificationEvent  $event
     * @return void
     */
    public function handle(FCMNotificationEvent $event)
    {

        foreach($event->recievers as $reciever)
        {
            try
            {
                $x=$reciever->notify(new GeneralNotification($event->title,$event->body,$event->image));
            }
            catch(Exception $e)
            {
                
            }
            
        }
    }
}
