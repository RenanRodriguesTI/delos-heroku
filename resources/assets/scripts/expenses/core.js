/**
 * Created by delos on 31/01/2017.
 */
if ($('#form-expenses').length) {
    var formatUSA = 'YYYY-MM-DD';
    var currentBaseUrl = document.location.origin;

    function startDatePickerIssue(maxDate, minDate, selected) {
        if (!selected) {
            selected = maxDate;
        }

        $(".issue_date_calendar").daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            },
            "singleDatePicker": true,
            "startDate": selected,
            'maxDate': maxDate,
            'minDate': minDate
        }, function(start) {
            var dateUrl = start.format('YYYY-MM-DD');
            var dateVal = start.format('DD/MM/YYYY');

            $("input[name='issue_date']").val(dateVal);

            $('#requestable_id').find('.option-dynamic').remove();
            $('#requestable_id').selectpicker('destroy');
            $('#requestable_id').selectpicker();

            var url = currentBaseUrl + '/expenses/' + dateUrl + '/date';

            $.get(url, function(data, status) {
                $.each(data, function(index, value) {

                    var description = value.split('*');

                    if (index.indexOf('- project') >= 0) {
                        var html = "<option value='" + index + "' data-subtext='" + description[1] + "' class='option-dynamic'>" + description[0] + "</option>";
                        var select = $("#requestable_id optgroup[label='Projetos']");

                    } else {
                        var html = "<option value='" + index + "' data-subtext='" + description[1] + "' class='option-dynamic'>" + description[0] + "</option>";
                        var select = $("#requestable_id optgroup[label='Solicitações']");
                    }


                    select.append(html);
                    $('#requestable_id').selectpicker('destroy');
                    $('#requestable_id').selectpicker();
                });

                $.each(data[1], function(index, value) {
                    var hiddenInput = $('<input/>', {
                        type: 'hidden',
                        class: 'requests-owner-or-co-owner',
                        value: value
                    });

                    $('div.user').append(hiddenInput);
                });
            });
        });
    }

    function getAllDescriptions(url) {
        return $.get(url, function(success) {
            return success;
        });
    }

    function startTypeAHead(id) {
        $('#description, #description_mobile').typeahead('destroy');
        var url = currentBaseUrl + '/expense-types/' + id + '/descriptions';

        getAllDescriptions(url).done(function(success) {
            var array = [];

            array['data'] = Object.keys(success.data).map(function(_) {
                return success.data[_];
            });

            $('#description, #description_mobile').typeahead({
                'source': array['data']
            });
        });

    }

    $('#payment_type_id').change(function() {
        var selectedPayment = this.value;
        if (selectedPayment.length == 0) {
            $('#description, #description_mobile').typeahead('destroy');
            return false;
        }
        startTypeAHead(selectedPayment);
    });

    $("#requestable_id").change(function() {
        var requestId = $(this).val();

        $.ajax({
            url: "/expenses/users/" + requestId,
            success: function(result) {

                var select = $("#user_id");
                select.find('option').remove();
                select.append('<option value="">Selecione um colaborador</option>');

                $.each(result, function(key, value) {
                    if (countObject(result) == 1) {
                        select.append('<option value=' + key + ' selected>' + value + '</option>');
                    } else {
                        select.append('<option value=' + key + '>' + value + '</option>');
                    }

                });
                select.selectpicker('destroy');
                select.selectpicker();
            }
        });
    });

    function applyMaskIn(selector, mask) {
        $(selector).inputmask(mask);

        $(selector).inputmask({ "placeholder": "" });
        $(selector).focus(function() {
            $(selector).inputmask({ "placeholder": "" });
        });
    }

    function iniciateFormsWhenAccessPage(day) {
        var url = currentBaseUrl + '/expenses/' + day + '/date';
        var requestSelected = $('#request_selected').val();
        var ExistsError = $('#_old_input_requestable_id').val();

        $.get(url, function(data, status) {
            $.each(data, function(index, value) {
                var description = value.split('*');

                if (index == requestSelected || index == ExistsError) {
                    if (index.indexOf('- project') >= 0) {
                        var html = "<option value='" + index + "' data-subtext='" + description[1] + "' class='option-dynamic' selected>" + description[0] + "</option>";
                        var select = $("#requestable_id optgroup[label='Projetos']");

                    } else {
                        var html = "<option value='" + index + "' data-subtext='" + description[1] + "' class='option-dynamic' selected>" + description[0] + "</option>";
                        var select = $("#requestable_id optgroup[label='Solicitações']");
                    }

                    if (index == ExistsError) {
                        startColaborator(index);
                    }

                } else {
                    if (index.indexOf('- project') >= 0) {
                        var html = "<option value='" + index + "' data-subtext='" + description[1] + "' class='option-dynamic'>" + description[0] + "</option>";
                        var select = $("#requestable_id optgroup[label='Projetos']");

                    } else {
                        var html = "<option value='" + index + "' data-subtext='" + description[1] + "' class='option-dynamic'>" + description[0] + "</option>";
                        var select = $("#requestable_id optgroup[label='Solicitações']");
                    }

                }

                select.append(html);
                $('#requestable_id').selectpicker('destroy');
                $('#requestable_id').selectpicker();
            });

            $.each(data[1], function(index, value) {
                var hiddenInput = $('<input/>', { type: 'hidden', class: 'requests-owner-or-co-owner', value: value });

                $('div.user').append(hiddenInput);
            });
        });
    }

    function modalLoadWhenSubmitForm() {
        $("#form-expenses").submit(function() {
            $('#myModal').modal({ backdrop: 'static', keyboard: false });
        });
    }

    function startColaborator(requestId) {
        var whenExists = $('#_old_input_user_id').val();

        $.ajax({
            url: "/expenses/users/" + requestId,
            success: function(result) {

                var select = $("#user_id");
                select.find('option').remove();
                select.append('<option value="">Selecione um colaborador</option>');
                $.each(result, function(key, value) {
                    if (whenExists == key) {
                        select.append('<option value=' + key + ' selected>' + value + '</option>');
                    } else {
                        select.append('<option value=' + key + '>' + value + '</option>');
                    }

                });
            }
        });
    }

    function countObject(obj) {
        var count = 0;
        for (var k in obj) {
            ++count;
        }
        return count;
    }

    function isReceipt() {
        $('#isReceipt').on('change', function() {
            if ($(this).prop('checked')) {
                $("input[name='invoice']").remove();
                var html = "<input class='form-control receipt' required='required' readonly='readOnly' name='invoice' type='text' value='RECIBO' id='invoice'>";
                $(".invoice-container").append(html);
            } else {
                $("input[name='invoice']").remove();

                var html = "<input class='form-control' required='required' name='invoice' type='text' id='invoice'>";
                $(".invoice-container").append(html);
                applyMaskIn('#invoice', '9999');
            }
        });
    }

    if ($('.name_invoice').val().length > 0) {
        $("#invoice-file").attr('required', false);
    }

    var date = $('#issue_date').val();

    iniciateFormsWhenAccessPage(moment(date, 'DD/MM/YYYY').format(formatUSA));

    applyMaskIn('#invoice', '9999');
    startDatePickerIssue(date, '01/03/2017');
    modalLoadWhenSubmitForm();
    isReceipt();
}


$('.toview').click(function() {
    let url = new URL($(this).attr('data-href'));
    let path = url.pathname.split('/');
    let urlSecond = url.origin + '/images/invoices/' + path[(path.length - 1)];
    console.log('url', url.href);
    console.log('urlSecond', urlSecond);
    $.ajax({
        async: false,
        type: 'GET',
        url: url.href,
        dataType: 'json',
        error: function(err) {
            console.log(err);
            if (err.status == 200) {
                window.open(url.href);
            } else {
                $.ajax({
                    async: false,
                    type: 'GET',
                    url: urlSecond,
                    dataType: 'json',
                    error: function() {
                        window.open(urlSecond);
                    }
                });
            }


        }
    });
});