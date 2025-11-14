/**
 * Máscaras para inputs
 * sempre utilizar o divisor - entre palavras
 *
 * Exemplo: mask-cnpj
 *
 */

var telefoneMask = function (val) {
    return val.replace(/\D/g, "").length === 11
        ? "(00) 00000-0000"
        : "(00) 0000-00009";
};

var telefoneOptions = {
    onKeyPress: function (val, e, field, options) {
        field.mask(telefoneMask.apply({}, arguments), options);
    },
    clearIfNotMatch: true,
};

$(".mask-telefone").mask(telefoneMask, telefoneOptions);

$(".mask-cpf").mask("000.000.000-00");

$(".mask-cnpj").mask("00.000.000/0000-00");

$(".mask-data").mask("00/00/0000");

$(".mask-horario").mask("00:00:00");

$(".mask-cep").mask("00000-000");

$(".mask-porcentagem").mask("##0,00%", { reverse: true });

var PersonCertificationMask = function (val) {
    var cleanedVal = val.replace(/\D/g, "");
    if (cleanedVal.length <= 11) {
        return "000.000.000-009";
    } else {
        return "00.000.000/0000-00";
    }
};

var PersonCertificationOptions = {
    onKeyPress: function (val, e, field, options) {
        field.mask(PersonCertificationMask.apply({}, arguments), options);
    },
    clearIfNotMatch: false, // Allow partial input without clearing
    reverse: true           // Optionally, reverse input to match masks from the end
};

$(document).ready(function () {
    $(".mask-cpf-cnpj").mask(PersonCertificationMask, PersonCertificationOptions);
});
