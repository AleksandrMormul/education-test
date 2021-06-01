<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
     * @var string
     */
    public $ads;
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
