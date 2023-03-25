<?php

namespace App\Listeners;

use App\Events\NewRequestEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendEmail;
use Carbon\Carbon;
use Artisan;

class SendNewRequestEmailListener
{
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
     * @param  NewRequestEvent  $event
     * @return void
     */
    public function handle(NewRequestEvent $event)
    {
         $details = ['email' => 'mod47387@yahoo.com','event' => $event];
         SendEmail::dispatch($details);

        // $emailJob = (new SendEmail($details))->delay(Carbon::now()->addMinutes(5));
        // dispatch($emailJob);
    }
}
