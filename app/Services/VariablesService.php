<?php

namespace App\Services;

use Modules\Contact\Services\ContactService;
use Modules\PagePrivacy\Services\PagePrivacyService;

class VariablesService
{
    public array $variables;
    private $contactService;

    public function __construct() {

        $this->contactService = new ContactService;
        $this->variables = [
            'help_text' => 'Para atualizar os dados da empresa automáticamente copiar e inserir no texto as variáveis abaixo:<br>
            {{nome}} - Nome da empresa simplificado.<br>
            {{razao_social}} - Razão social.<br>
            {{nome_fantasia}} - Nome fantasia.<br>
            {{cnpj}} - CNPJ da empresa.<br>
            {{dominio}} - Domínio do site. ex: www.amazon.com.br.<br>
            {{telefone_1}} - Primeiro telefone no cadastro de telefones.<br>
            {{telefone_2}} - Segundo telefone no cadastro de telefones.<br>
            {{whatsapp}} - Primeiro Whatsapp cadastrado.<br>
            {{endereco}} - Endereço cadastrado.<br>
            {{email_1}} - Primeiro email no cadastro de emails.<br>
            {{email_2}} - Segundo email no cadastro de emails.<br>
        '];
    }

    public function getVariables(){
        return $this->variables;
    }

    public function processText(string $text)
    {
        $phones = array_values($this->contactService->getPhones());
        $address = array_values($this->contactService->getAdresses());
        $emails = array_values($this->contactService->getEmails());
        $whatsapp = array_values($this->contactService->getWhatsapps());
        $arrayReplace = [
            '{{nome}}' => config('app.simplified_name'),
            '{{razao_social}}' => config('app.corporate_reason'),
            '{{nome_fantasia}}' => config('app.fantasy_name'),
            '{{cnpj}}' => config('app.cnpj'),
            '{{dominio}}' => config('app.url'),
            '{{telefone_1}}' => count($phones) ? $phones[0]['phone'] : '',
            '{{telefone_2}}' => count($phones) > 1 ? $phones[1]['phone'] : '',
            '{{whatsapp}}' => count($whatsapp) ? $whatsapp[0]['phone'] : '',
            '{{endereco}}' => count($address) ? $address[0]['address'] : '',
            '{{email_1}}' => count($emails) ? $emails[0]['email'] : '',
            '{{email_2}}' => count($emails) > 1 ? $emails[1]['email'] : '',
        ];

        return str_replace(array_keys($arrayReplace), array_values($arrayReplace), $text);
    }
}
