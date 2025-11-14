<?php

namespace App\Services;

use Illuminate\Support\Collection;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

class ScreensService
{
    private Collection $screens;

    private Collection $images_help;

    public function __construct()
    {
        $this->screens = collect();
    }

    private function loadFolder(string $folder)
    {
        $is_modules = substr($folder, -8) === '/modules';

        $directory = new RecursiveDirectoryIterator($folder);
        $iterator = new RecursiveIteratorIterator($directory);
        $php_files = new RegexIterator($iterator, '#.+Screen\.php$#i', RecursiveRegexIterator::GET_MATCH);

        foreach ($php_files as $php_file) {
            $file = $php_file[0];
            $file = str_replace('/', '\\', $file);
            
            // require_once $file;

            if ($is_modules) {
                $class_name = "\\Modules\\" . substr($file, strpos($file, "modules") + 8, -4);
            }
            else {
                $class_name = "\\App\\" . substr($file, strpos($file, "Orchid\\Screens"), -4);
            }
            
            $this->screens->push($class_name);
        }
    }

    private function loadScreens()
    {
        static $has_loaded = false;

        if (!$has_loaded) {
            $this->loadFolder(__DIR__ . '/../Orchid/Screens');
            $this->loadFolder(__DIR__ . '/../../modules');
            $has_loaded = true;
        }
    }

    public function screens() : Collection
    {
        $this->loadScreens();
        return $this->screens;
    }

    /**
     * Chama a função das screens para gerar rotas
     */
    public function routes()
    {
        foreach ($this->screens() as $screen) {
            if (method_exists($screen, 'routes')) {
                $screen::routes();
            }
        }
    }

    /**
     * Chama a função das screens para obter as permissões
     */
    public function permissions() : array
    {
        $permissions = [];

        foreach ($this->screens() as $screen) {
            if (method_exists($screen, 'permissions')) {
                $permissions[] = $screen::permissions();
            }
        }

        return $permissions;
    }

    /**
     * Busca em todos os arquivos blade os tamanho das imagens
     */
    private function loadImagesHelp()
    {
        if (!empty($this->images_help)) {
            return;
        }

        $this->images_help = collect([]);

        // pega todos os arquivos blade da pasta resources
        $folder = __DIR__ . '/../../resources';
        $directory = new RecursiveDirectoryIterator($folder);
        $iterator = new RecursiveIteratorIterator($directory);
        $php_files = new RegexIterator($iterator, '#.+blade\.php$#i', RecursiveRegexIterator::GET_MATCH);

        foreach ($php_files as $php_file) {
            $file_content = file_get_contents($php_file[0]);
            $this->parseContentToImageHelp($file_content);
        }
    }

    private function parseContentToImageHelp($content)
    {
        // retira quebras de linhas, 
        // pois o regex não funciona com elas
        $content = str_replace("\r", "", $content);
        $content = str_replace("\n", "", $content);

        // busca no formato
        // {{-- TAMANHO-IMAGEM: chave: texto --}}
        $regex = '{{--\s*TAMANHO-IMAGEM[^}]+}}';
        $match = preg_match_all("#$regex#", $content, $matches);

        if (!$match) {
            return;
        }

        foreach ($matches[0] as $match) {
            // tira a abertura e fechamento do comentário
            $match = str_replace('{{--', '', $match);
            $match = str_replace('--}}', '', $match);
            $this->parseStrToImageHelp($match);
        }
    }

    private function parseStrToImageHelp($string)
    {
        // a string está no formato
        // "TAMANHO-IMAGEM: chave: texto"

        // separa a string em partes
        $parts = explode(':', $string, 3);
        
        if (count($parts) !== 3) {
            return;
        }

        // tira espaços em branco de todas as partes
        $parts = array_map('trim', $parts);

        list($_unused, $key, $value) = $parts;

        $this->images_help->put($key, $value);
    }

    /**
     * 
     */
    public function getImageHelp(string $image_code)
    {
        $this->loadImagesHelp();

        if (!$this->images_help->has($image_code)) {
            // se está com debug ativado, exibe uma mensagem de aviso
            if (env('APP_DEBUG')) {
                return sprintf('<span style="color: yellow; background-color: red">Tamanho de imagem "%s" não encontrado</span>', $image_code);
            }
            return '';
        }

        return $this->images_help->get($image_code);
    }

    public function metricsQuery()
    {
        $query = [];

        foreach ($this->screens() as $screen) {
            if (method_exists($screen, 'metricsQuery')) {
                $screenQuery = $screen::metricsQuery();
                $query = array_merge($query, $screenQuery);
            }
        }

        return $query;
    }

    public function metricsLayout()
    {
        // Metrics Dashboard
        $layout = [];

        foreach ($this->screens() as $screen) {
            if (method_exists($screen, 'metricsLayout')) {
                $metricsLayout = $screen::metricsLayout();
                $layout = array_merge($layout, $metricsLayout);
            }
        }
        
        return $layout;
    }
}
