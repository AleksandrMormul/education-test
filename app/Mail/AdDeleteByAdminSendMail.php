<?php

namespace App\Mail;

use App\Models\Ad;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class AdDeleteByAdminSendMail
 * @package App\Mail
 */
class AdDeleteByAdminSendMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var Ad
     */
    public $ad;
    /**
     * @var
     */
    public $deletedAd;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ad $ad, $deletedAd)
    {
        $this->ad = $ad;
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
