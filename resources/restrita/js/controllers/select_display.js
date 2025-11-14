import $ from "jquery";

/**
 * 
 * Atributos usados:
 * 
 * - data-select-change-display="select-codigo"
 *   Usado no select. Identifica os elementos de um mesmo select.
 * 
 * - data-change-display="select-codigo"
 *   Usado no elemento. Seleciona os elementos de um mesmo select.
 * - data-change-display-value="1"
 *   Usado no elemento. O elemento vai ser escondido ou mostrado dependendo dessa opção.
 * 
 */
export default function selectDisplay() {

    let trataDisplaySelect = function(idSelect) {

        // esconde todos os elementos inicialmente
        $('[data-change-display="' + idSelect + '"]').each(function(index, el){
            $(el).parents('.form-group').hide();
        })
        
        // pega o valor do option selecionado do select
        let valueSelect = $('[data-select-change-display="' + idSelect + '"] option:selected').val();

        // mostra todos os elementos que devem ser mostrados
        $('[data-change-display="' + idSelect + '"][data-change-display-value="' + valueSelect + '"]').each(function(index, el){
            $(el).parents('.form-group').show();
        })
    }
    
    let initSelects = function() {
        // adiciona o evento de change nos selects
        $('[data-select-change-display]').on('change', function(){
            let idSelect = $(this).attr('data-select-change-display');
            trataDisplaySelect(idSelect);
        });

        // processa inicialmente todos os selects
        $('[data-select-change-display]').each(function(){
            let idSelect = $(this).attr('data-select-change-display');
            trataDisplaySelect(idSelect);
        });
    }

    initSelects();
}
