<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class UpdateUserActivity implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $userId;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->userId = Auth::id();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::find(Auth::id());

        if (auth()->check()) {
            $user->last_activity = date('y-m-d', 'h:m:s');
            $user->update();
            // } else {
            //     // Handle the case where there is no authenticated user
            //     // or the user ID does not match the authenticated user.
            //     // You can log this event or perform any other desired action.
            //     Log::info("User with ID {$this->userId} not found or not authenticated.");
        }
    }
}
