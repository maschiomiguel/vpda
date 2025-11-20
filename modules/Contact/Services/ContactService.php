<?php

namespace Modules\Contact\Services;

use Modules\Contact\Models\PageContact;

class ContactService
{
    private $page;

    public function __construct()
    {
        $this->page = PageContact::withTranslation()->firstOrCreate();
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getIframeLinks()
    {
        if (!$this->page->adresses) {
            return [];
        }

        $links = array_column(
            $this->page->adresses,
            'iframe_link',
        );

        $links = array_filter($links);

        return array_values($links);
    }

    public function getLink(string $field): ?string
    {      
        return $this->page->$field;
    }

    public function getSocial(string $social)
    {
        if (empty($this->page->social_networks)) {
            return '';
        }

        $socials = $this->page->social_networks[0];

        if (array_key_exists($social, $socials)) {
            return $socials[$social];
        }

        return '';
    }

    public function getSocialUsername(string $social)
    {
        if (empty($this->page->social_networks)) {
            return '';
        }

        $socials = $this->page->social_networks[0];

        $key = $social . '_username';

        if (array_key_exists($key, $socials)) {
            return $socials[$key];
        }

        return '';
    }

    public function getSocials()
    {
        if (empty($this->page->social_networks)) {
            return [];
        }

        return $this->page->social_networks[0];
    }

    public function getEmails()
    {
        if (empty($this->page->emails)) {
            return [];
        }

        return array_filter(
            $this->page->emails,
            fn ($e) => !empty($e['email']),
        );
    }

    public function getPhones()
    {
        if (empty($this->page->phones)) {
            return [];
        }

        return array_filter(
            $this->page->phones,
            fn ($e) => !empty($e['phone']),
        );
    }

    public function getWhatsapps()
    {
        if (empty($this->page->whatsapps)) {
            return [];
        }

        return array_filter(
            $this->page->whatsapps,
            fn ($e) => !empty($e['phone']),
        );
    }

    public function getAdresses()
    {
        if (empty($this->page->adresses)) {
            return [];
        }

        return array_filter(
            $this->page->adresses,
            fn ($e) => !empty($e['address']),
        );
    }

    public function getEmailsDestiny($form = 'form-destiny-contact')
    {
        $emails = [];

        if (empty($this->page->site_messages_destinies)) {
            return [];
        }

        foreach ($this->page->site_messages_destinies as $destiny) {
            if ($destiny['form'] === $form) {
                $emails[] = $destiny['email'];
            }
        }

        if (empty($emails) && $form !== 'form-destiny-contact') {
            $emails = $this->getEmailsDestiny('form-destiny-contact');
        }

        return $emails;
    }

    public function getFirstWhatsapp(): ?string
    {
        $whatsapp = $this->getWhatsapps()[0] ?? null;
        return $whatsapp ? $whatsapp['phone'] : null;
    }
}
