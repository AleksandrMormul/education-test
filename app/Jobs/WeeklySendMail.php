<?php

namespace App\Jobs;

use App\Mail\AdWeeklySendMail;
use App\Models\Ad;
use App\Models\User;
use App\Services\SubscriptionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

/**
 * Class WeeklySendMail
 * @package App\Jobs
 */
class WeeklySendMail implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var Ad
     */
    protected $ads;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Collection $ads)
    {
        $this->ads = $ads;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ads = $this->ads;
        User::getSubscribedUsers()->chunkById(15, function ($user) use ($ads) {
            $unsubscribedUrl = SubscriptionService::getSignedUrl($user);
            $email = new AdWeeklySendMail($ads, $unsubscribedUrl);

            Mail::to($user)->send($email);
        });
    }
}
