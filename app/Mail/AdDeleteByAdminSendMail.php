<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

/**
 * Class AdDeleteByAdminSendMail
 * @package App\Mail
 */
class AdDeleteByAdminSendMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var array
     */
    public $adData;

    /**
     * @var Carbon
     */
    public $deletedAd;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $adData, Carbon $deletedAd)
    {
        $this->adData = $adData;
        $this->deletedAd = $deletedAd;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): AdDeleteByAdminSendMail
    {
        return $this->view('emails.ads.delete-by-admin');
    }
}
