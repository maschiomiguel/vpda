<?php

namespace App\Modules;

use Illuminate\Support\Facades\Log;

class ModulesPass
{

	/**
	 * Url base da API de login
	 */
	public $base_url = 'https://www.ellitedigital.com.br/pass_cert';

	/**
	 * Código do cliente cadastrado no sistema
	 */
	private $codigo_cliente;

	/**
	 * Senha inserida no formulário de login
	 * A senha não pode estar criptografada
	 */
	private $senha;

	/**
	 * Logger
	 */
	private $logger;

	/**
	 * Construtor
	 */
	public function __construct($codigo_cliente, $senha)
	{
		$this->codigo_cliente = $codigo_cliente;
		$this->senha = $senha;

		$this->logger = Log::build([
			'driver' => 'single',
			'path' => storage_path('logs/ModulesPass.php.log'),
		]);
	}

	/*
	 * Retorna true se o codigo e senha podem fazer login no sistema
	 * Caso contrário, retorna false
	 */
	public function autorizar()
	{

		// criptografa a senha usando OPENSSL
		$public_key = $this->getCertificado();
		if (!$public_key) {
			$this->colocarLog('Falha ao buscar certificado de chave pública');
			return false;
		}

		$senha_base_64 = base64_encode($this->senha);

		$sucesso = openssl_public_encrypt(
			$senha_base_64,
			$senha_criptografada,
			$public_key,
			OPENSSL_PKCS1_OAEP_PADDING
		);

		if (!$sucesso) {
			$this->colocarLog('Falha ao criptografar senha');
			return false;
		}

		// monta o array para o POST para enviar ao servidor de autenticação
		$server = $_SERVER;
		unset($server['HTTP_COOKIE']); // retira alguns dados que não são necessários

		$dados = array(
			'versao' => 1,
			'cliente' => $this->codigo_cliente,
			'senha' => base64_encode($senha_criptografada),
			'dados' => array(
				'caminho_classe' => __FILE__,
				'server' => $_SERVER,
				'versao_php' => phpversion(),
			),
		);

		$dados['dados']['dominio'] = env('APP_URL');

		$dados['dados']['mysql'] = array(
			'ip' => env('DB_HOST'),
			'user' => env('DB_DATABASE'),
			'db' => env('DB_USERNAME'),
		);

		// envia a requisição
		$retorno = $this->curlRequest("{$this->base_url}/login.php", $dados);
		$this->colocarLog("Retorno CURL: $retorno");

		if (!$retorno) {
			return false;
		}

		$retorno = @json_decode($retorno);

		if (!$retorno) {
			return false;
		}

		if (!$retorno->autorizar) {
			return false;
		}

		return true;
	}

	public function curlRequest($url, $post = false)
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		if ($post) {
			curl_setopt($ch, CURLOPT_POST, 1);
			if (is_array($post)) {
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
			}
		}

		// desativa a verificação de certificado no ambiente de desenvolvimento
		// sites com o env.php
		if (env('APP_ENV') === 'local') {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		}

		$raw = curl_exec($ch);

		if (curl_errno($ch)) {
			$this->colocarLog("Curl error: " . curl_errno($ch) . " - " . curl_error($ch));
		}

		curl_close($ch);
		return $raw;
	}

	public function getCertificado()
	{
		$url_certificado = "{$this->base_url}/cert.pem";

		$certificado = $this->curlRequest($url_certificado);

		return $certificado;
	}

	public function colocarLog($mensagem)
	{
		$this->logger->info($mensagem);
	}
}
