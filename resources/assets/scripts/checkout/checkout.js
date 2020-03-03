$(document).ready(function () {
    if ($('#form-checkout').length) {

        var paymentType = $('#payment_type');
        var cepInput = $('#postal_code');
        var documentInput = $('#document');
        var telephoneInput = $('#telephone');
        var __ret = telephoneMask(arguments);
        var masks = ['000.000.000-000', '00.000.000/0000-00'];
        var documentType = $('#document-type');

        $('form#form-checkout').card(cardOptions());

        changePaymentType(paymentType);

        paymentType.change(function () {
            changePaymentType($(this));
        });

        cepInput.keyup(function () {
            if ($(this).val().length >= 9) {
                changeAddress();
            }
        });

        if (documentInput[0].value.length > 14) {
            documentInput.mask(masks[1], options());
            documentType.val('CNPJ');
        }else {
            documentInput.mask(masks[0], options());
            documentType.val('CPF');
        }


        telephoneInput.mask(__ret.SPMaskBehavior, __ret.spOptions);
        cepInput.mask('00000-000');
    }

    function cardOptions() {
        return {
            container: '.card-wrapper',
            width: 280,

            formSelectors: {
                nameInput: 'input#name_printed',
                numberInput: 'input#credit_card_number',
                expiryInput: 'input#validity',
                cvcInput: 'input#security_code'
            },

            placeholders: {
                number: '•••• •••• •••• ••••',
                name: 'Nome',
                expiry: '••/••',
                cvc: '•••'
            },

            masks: {
                cardNumber: '•'
            }
        };
    }

    function telephoneMask(arguments) {
        var SPMaskBehavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            spOptions = {
                onKeyPress: function (val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };
        return {SPMaskBehavior: SPMaskBehavior, spOptions: spOptions};
    }

    function options() {
        return {
            onKeyPress: function (cpf, ev, el, op) {

                if (cpf.length > 14) {
                    var mask = masks[1];
                    documentType.val('CNPJ');
                }else {
                    var mask = masks[0];
                    documentType.val('CPF');
                }

                el.mask(mask, op);
            }
        };
    }

    function changeAddress() {
        var cep = $('#postal_code').val();

        var url = 'https://viacep.com.br/ws/';
        url += cep + '/json';
        
        $.get(url, function (response) {
            $('#district').val(response.bairro);
            $('#city').val(response.localidade);
            $('#address').val(response.logradouro);
            $('#state').val(response.uf);
            $('#residential_number').focus();
        });
    }

    function changePaymentType(paymentType) {
        switch (paymentType.val()) {
            case ('credit-card'):
                $('#credit-card-container').css('display', 'block');
                $('#bank-slip-container').css('display', 'none');
                $('#bank-slip-container input').attr('disabled', 'disabled');
            break;
            case ('bank-slip'):
                $('#bank-slip-container').css('display', 'block');
                $('#credit-card-container').css('display', 'none');
                $('#credit-card-container input').attr('disabled', 'disabled');
            break;
            default:
                $('#bank-slip-container').css('display', 'none');
                $('#bank-slip-container input').attr('disabled', 'disabled');
                $('#credit-card-container').css('display', 'none');
                $('#credit-card-container input').attr('disabled', 'disabled');
            break;
        }
    }

});