<?php

namespace App\Jobs;

use App\Mail\AdDeleteByAuthorSendMail;
use App\Models\Ad;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

/**
 * Class DeletedByAuthorSendEmail
 * @package App\Jobs
 */
class DeletedByAuthorSendEmail implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $ad;


    /**
     * @var User
     */
    protected $user;

    protected $deletedAt;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($ad, User $user, $deletedAt)
    {
        $this->ad = $ad;
        $this->user = $user;
        $this->deletedAt = $deletedAt;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('blalala');
        $email = new AdDeleteByAuthorSendMail($this->ad, $this->deletedAt);
        Mail::to($this->user->email)->send($email);
    }
}
