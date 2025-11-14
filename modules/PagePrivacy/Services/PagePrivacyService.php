<?php

namespace Modules\PagePrivacy\Services;

use Modules\Contact\ContactServiceProvider;
use Modules\Contact\Models\PageContact;
use Modules\Contact\Services\ContactService;
use Modules\PagePrivacy\Models\PagePrivacy;

class PagePrivacyService
{
    private $page;

    public function __construct(private ContactService $contactService)
    {
        $this->page = PagePrivacy::withTranslation()->firstOrCreate();
    }

    public function getPage()
    {
        return $this->page;
    }

    public function processPrivacyText()
    {
        $phones = $this->contactService->getPhones();
        $address = $this->contactService->getAdresses();
        $email = $this->contactService->getEmails();

        $search = [
            '{{cnpj}}' => config('app.cnpj'),
            '{{nome}}' => config('app.name'),
            '{{razao_social}}' => config('app.corporate_reason'),
            '{{data}}' => now()->format('d/m/Y'),
            '{{telefone}}' => count($phones) ? $phones[0]['phone'] : '',
            '{{endereco}}' => count($address) ? $address[0]['address'] : '',
            '{{email}}' => count($email) ? $email[0]['email'] : '',
        ];

        return str_replace(array_keys($search), array_values($search), $this->page->text);
    }
}
