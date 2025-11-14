<?php

/*
|--------------------------------------------------------------------------
| Funções úteis
|--------------------------------------------------------------------------
*/

use App\Services\LanguagesService;
use App\Services\ScreensService;
use App\Services\LogsService;
use App\Models\Language;
use Modules\Contact\Services\ContactService;
use Illuminate\Support\Facades\Auth;

/**
 * Deixa somente caracteres numéricos
 */
function onlyNumbers(string|int|null $str): string
{
    return preg_replace("/[^0-9]/", '', $str);
}

/**
 * Deixa somente caracteres numéricos
 */
function only_numbers(string|int|null $str): string
{
    return onlyNumbers($str);
}

/**
 * number_format padrao
 */
function nf(float|int|string $valor): string
{
	return number_format($valor, 2, ',', '.');
}

/**
 * limita os caracteres de uma string
 */
function max_c($str, $max = 999999): string
{
	if(!is_string($str))
		$str = strval($str);
	
	return substr($str, 0, $max);
}

/**
 * Função para facilitar o acesso ao serviço de idiomas
 */
function languages() : LanguagesService
{
	return app(LanguagesService::class);
}

/**
 * Função para facilitar o acesso ao serviço de screens
 */
function screens() : ScreensService
{
	return app(ScreensService::class);
}

/**
 * Função para facilitar o acesso ao serviço de logs da restrita
 */
function logsRestrita() : LogsService
{
	return app(LogsService::class);
}

/**
 * Gera uma URL usando o idioma atual
 */
function route_lang(string $name, array $parameters = [], bool $absolute = true)
{
	$language = languages()->getCurrentLanguage();
	return route_for_lang($name, $language, $parameters, $absolute);
}

/**
 * Gera uma URL usando o idioma passado por parâmetro
 */
function route_for_lang(string $name, Language|string $language, array $parameters = [], bool $absolute = true)
{
	if (is_string($language)) {
		$code = $language;
		$language = languages()->getByCode($code);

		if (!$language) {
			throw new \Exception("Não existe idioma com o código '{$code}'");
		}
	}

	// rotas pt-BR não usam o prefixo
	if ($language->code !== 'pt') {
		$name = "{$language->code}.$name";
	}

	return route($name, $parameters, $absolute);
}

/**
 * Coloca tags html nos textos entre asteriscos
 * Útil para colocar em negrito certas partes de uma frase
 * Exemplo: lorem *ipsum* -> lorem <spam>ipsum</span>
 */
function geraTextoSpan($str, $tag_open = '<span>', $tag_close = '</span>')
{
	$regex = '\*([^\*]*)(\*|$)';
	return preg_replace("#$regex#", "$tag_open$1$tag_close", $str);
}

function geraTextoComClasse($str, $tag_classe = '', $tag_open = '<p>')
{
	$text = str_replace($tag_open, $tag_classe, $str);

	return $text;
}

/**
 * Checa se um usuário logado na restrita tem permissão
 * Se $abort for true, irá gerar um erro 403
 */
function checkAuth(string $permissao, bool $abort = true)
{
	$tem_permissao = Auth::user()->hasAccess($permissao);

	if (!$tem_permissao && $abort) {
		abort(403);
	}

	return $tem_permissao;
}

/**
 * Checa se um usuário logado na restrita tem permissão
 * Retorna true ou false
 */
function hasAuth(string $permissao)
{
	return checkAuth($permissao, false);
}

/**
 * Retorna a URL da imagem padrão do site
 */
function defaultImage()
{
	return url(config('app.default_image'));
}

/**
 * Retorna a URL da primeira imagem
 * se não tiver imagens, retorna a URL da imagem padrão
 */
function imageUrlOrDefault($image)
{
	if ($image->count()) {
		return $image->first()->url();
	}
	return defaultImage();
}

function firstWhatsAppUrl()
{
	$whatsapp = app(ContactService::class)->getFirstWhatsapp();
	if (!$whatsapp) {
		return null;
	}
	return 'https://wa.me/' . onlyNumbers($whatsapp);
}
