<?php

namespace App\Mail;

use App\Models\Ad;
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
     * @var Ad
     */
    public $ad;

    /**
     * @var Carbon
     */
    public $deletedAd;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ad $ad, Carbon $deletedAd)
    {
        $this->ad = $ad;
        $this->deletedAd = $deletedAd;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): AdDeleteByAuthorSendMail
    {
        return $this->view('emails.ads.delete-from-author');
    }
}
