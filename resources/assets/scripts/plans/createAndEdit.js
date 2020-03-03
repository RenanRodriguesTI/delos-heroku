$(document).ready(function () {
    if ($('#form-plan').length) {
        $('#value').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
    }
});