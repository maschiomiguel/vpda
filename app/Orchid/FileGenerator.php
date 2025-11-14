<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Attachment\Engines\Generator;

class FileGenerator extends Generator
{
    public function extension(): string
    {
        /**
         * Correção para o compressor de imagens que converte para webp
         * Mas como a extensão do arquivo não é alterada pelo compressor,
         * o Orchid originalmente coloca a extensão original ao invés de 'webp'
         * Nesses casos o mimetype sempre vai retornar 'image/webp', pois o compressor alterou
         * 
         * Além de gerar nome e extensão, esse método é usado para obter o 
         * mime type da imagem no método parent::mime()
         * 
         * Para demais casos, o comportamento padrão é mantido
         */
        if ($this->file->getMimeType() === 'image/webp') {
            return 'webp';
        }
        return parent::extension();
    }
}
