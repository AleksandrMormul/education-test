<?php

namespace App\Mail;

use App\Models\Ad;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

/**
 * Class AdWeeklySendMail
 * @package App\Mail
 */
class AdWeeklySendMail extends Mailable
{
    use Queueable;
    use SerializesModels;


    /**
     * @var Collection
     */
    public $ads;

    /**
     * @var string
     */
    public $unsubscribeUrl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collection $ads, string $unsubscribeUrl)
    {
        $this->ads = $ads;
        $this->unsubscribeUrl = $unsubscribeUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): AdWeeklySendMail
    {

        return $this->view('emails.ads.weekly');
    }
}
