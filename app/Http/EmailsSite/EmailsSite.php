<?php

namespace App\Http\EmailsSite;

use Modules\Contact\Services\ContactService;
use Illuminate\Mail\Mailable;
use Livewire\Component;

abstract class EmailsSite
{
	public function __construct(protected Component $livewireComponent)
	{
		
	}

	public abstract function getValidator() : array;

	public abstract function getMailable() : Mailable;

	public abstract function getSubject() : string;

	public abstract function getFormName() : string;

	public abstract function getFormSlug() : string;

	public abstract function getEmailsDestinies(ContactService $contact) : array;

	public function getViewOptions() : array
	{
		return [
            'input_name' => true,
            'input_email' => true,
            'input_phone' => true,
            'input_message' => true,
            'input_accept' => true,
            'button_send_form' => true,
            'flash_messages' => true,
        ];
	}
}
