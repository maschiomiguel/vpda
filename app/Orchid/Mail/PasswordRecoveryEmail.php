<?php

namespace App\Orchid\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use App\Models\User;

class PasswordRecoveryEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $link;

    public $minutes = 30;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
		public User $user,
	)
    {
        $this->link = URL::temporarySignedRoute(
            'platform.password.recover-password',
            now()->addMinutes($this->minutes),
            ['id' => $user->id],
        );
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('platform::password-recovery.email.recovery')
			->text('platform::password-recovery.email.recovery_plain');
    }
}
