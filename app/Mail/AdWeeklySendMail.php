<?php

namespace App\Mail;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Bus\Queueable;
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
     * @var Ad
     */
    protected $ads;

    /**
     * @var string
     */
    protected $unsubscribeUrl;

    //protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ad $ads, /*User $user,*/ string $unsubscribeUrl)
    {
        $this->ads = $ads;
        //$this->user = $user;
        $this->unsubscribeUrl = $unsubscribeUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): AdWeeklySendMail
    {
        //$this->unsubscribeUrl = URL::signedRoute('unsubscribe', ['user' => $this->user->id]);
        return $this->view('emails.ads.weekly');
    }
}
