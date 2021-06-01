<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

/**
 * Class AdDeleteByAuthorSendMail
 * @package App\Mail
 */
class AdDeleteByAuthorSendMail extends Mailable
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
    public function build(): AdDeleteByAuthorSendMail
    {
        return $this->view('emails.ads.delete-by-author');
    }
}
