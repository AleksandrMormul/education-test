<?php

namespace App\Jobs;

use App\Mail\AdDeleteByAuthorSendMail;
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

    /**
     * @var array
     */
    private $adData;


    /**
     * @var array
     */
    private $user;

    private $deletedAt;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $adData, array $user, $deletedAt)
    {
        $this->adData = $adData;
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
        $email = new AdDeleteByAuthorSendMail($this->adData, $this->deletedAt);

        Mail::to($this->user['email'])->send($email);
    }
}
