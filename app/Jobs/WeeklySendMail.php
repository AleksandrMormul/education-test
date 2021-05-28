<?php

namespace App\Jobs;

use App\Mail\AdWeeklySendMail;
use App\Models\Ad;
use App\Models\User;
use App\Services\Api\SignedUrlService;
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
     * @var User
     */
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Collection $ads, User $user)
    {
        $this->ads = $ads;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $unsubscribedUrl = SignedUrlService::getSignedUrl($this->user);
        $email = new AdWeeklySendMail($this->ads, $unsubscribedUrl);
        Mail::to($this->user->email)->send($email);
    }
}
