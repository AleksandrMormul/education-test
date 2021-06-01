<?php

namespace App\Mail;

use App\Models\Ad;
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
     */
    public $ads;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collection $ads)
    {
        $this->ads = $ads;
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
