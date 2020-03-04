/*
 |--------------------------------------------------------------------------
 | Core Script DCT
 |--------------------------------------------------------------------------
 |
 | Todas as propriedades em relação a script estão aqui
 |
 */

$(function() {
    $(document).ready(function() {

        $("form button[type='submit']:first").click(function() {
            var form = $(this).parents('form');

            if (form[0].checkValidity()) {

                var beforeHtml = $(this).html();
                var count = 8;
                var button = $(this);

                button.html('Habilitará em ' + count);
                button.attr('disabled', true);

                var timeOut = setInterval(function() {
                    button.html('Habilitará em ' + count);
                    button.attr('disabled', true);
                    count--;
                }, 1000);

                setTimeout(function() {
                    button.html(beforeHtml);
                    button.removeAttr('disabled');
                    window.clearTimeout(timeOut);
                }, 9000);
                form.submit();
            }
        });

        $('.table-responsive').doubleScroll();
        $('body').materialScrollTop();

        if (Cookies.get('has_bank_slip') == '1') {
            $('#signatures').popover({
                container: 'body',
                'placement': 'right',
                'title': 'Seu boleto foi gerado',
                'content': 'Acesse Minha Assinatura para visualiza-lo'
            }).popover('show');

            setTimeout(function() {
                $('#signatures').popover('hide');
            }, 7000);
        }

        select = $('select');

        $.each(select, function(key, item) {
            if (!$(item).hasClass('selectpicker')) {
                $(item).addClass('selectpicker');
            }
            $(item).attr('data-live-search', 'true');
            $(item).attr('data-size', 9);
            $(item).selectpicker('destroy');
            $(item).selectpicker();
        });

        if (!$("form.form-inline input[name='search']").attr('placeholder')) {
            $("form.form-inline input[name='search']").attr('placeholder', 'Digite sua pesquisa')
        }

        var form = $('form');
        if (form.length > 0) {
            $.each($('input'), function(key, item) {
                if ($(item).attr('required') == 'required') {
                    var label = $('label[for="' + $(item).attr('id') + '"]');

                    if (label.length > 0 && $(label).children('span').length == 0) {
                        label.append("<span class='asterisk-required'> *</span>");
                    }
                }
            });

            $.each($('select'), function(key, item) {
                if ($(item).attr('required') == 'required') {
                    var label = $('label[for="' + $(item).attr('id') + '"]');

                    if (label.length > 0) {
                        label.append("<span class='asterisk-required'> *</span>");
                    }
                }
            });

            $.each($('textarea'), function(key, item) {
                if ($(item).attr('required') == 'required') {
                    var label = $('label[for="' + $(item).attr('id') + '"]');

                    if (label.length > 0) {
                        label.append("<span class='asterisk-required'> *</span>");
                    }
                }
            });
        }

        $("form.form-inline button[type='submit']").click(function() {
            if ($("input[name='search']").val().indexOf(',') !== -1) {
                var newValue = $("input[name='search']").val().replace(',', '.');
                $("input[name='search']").val(newValue);
            }
        });
    });

    $('[data-toggle="tooltip"]').tooltip();
    $('.tooltip-active').tooltip();
    $('body').tooltip({
        selector: '.black-tooltip'
    });

    if (!$('.panel-body').attr('data-without-height')) {
        $('.panel-body').last().css('min-height', ($(window).height() / 1.5));
    }

    if ($('#text').length) {
        if ($(window).width() <= 768) {
            $('#text').attr('rows', 4);
        }

        var text_max = 255;

        var textarea_lenght = $('#text').val().length;

        $('.count_message').html(textarea_lenght + ' / ' + text_max);

        $('#text').keyup(function() {
            var text_length = $('#text').val().length;

            $('.count_message').html(text_length + ' / ' + text_max);
        });
    }

    if ($('#description').length) {
        if ($(window).width() <= 768) {
            $('#description').attr('rows', 4);
        }

        var text_max = 255;

        var textarea_lenght = $('#description').val().length;

        $('.count_message.description').html(textarea_lenght + ' / ' + text_max);

        $('#description').keyup(function() {
            var text_length = $('#description').val().length;

            $('.count_message.description').html(text_length + ' / ' + text_max);
        });
    }

    if ($('#note').length) {
        if ($(window).width() <= 768) {
            $('#note').attr('rows', 4);
        }

        var text_max = 255;

        var textarea_lenght = $('#note').val().length;

        $('.count_message.note').html(textarea_lenght + ' / ' + text_max);

        $('#note').keyup(function() {
            var text_length = $('#note').val().length;

            $('.count_message.note').html(text_length + ' / ' + text_max);
        });
    }

    // Mostra apenas o calendario
    $('.datepicker').datetimepicker({
        format: 'DD/MM/YYYY',
    });
    $('.takeadayoff').datetimepicker({
        format: 'DD/MM/YYYY',
        minDate: moment().add(1, 'days'),
        daysOfWeekDisabled: [0, 6]
    });

    $('.takeaday').datetimepicker({
        format: 'DD/MM/YYYY',
        maxDate: moment(),
        daysOfWeekDisabled: [0, 6]
    });

    $('.datepicker1').datetimepicker({
        format: 'DD/MM/YYYY',
        maxDate: moment(),
    });

    $('.datepickerdom').datetimepicker({
        useCurrent: false, //Importante
        defaultDate: false,
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [1, 2, 3, 4, 5, 6],
        maxDate: moment()
    });
    $('.datepickersabdom').datetimepicker({
        useCurrent: false, //Importante
        defaultDate: false,
        format: 'DD/MM/YYYY',
        daysOfWeekDisabled: [1, 2, 3, 4, 5],
        maxDate: moment()
    });

    // Mostra apenas o relogio
    $('.timepicker').datetimepicker({
        format: 'LT'
    });

    // Mostra p calendario e o relogio
    $('.datetimepicker').datetimepicker();

    $('.start_datetimepicker').datetimepicker({
        format: 'DD/MM/YYYY',
        useCurrent: false, //Importante
        maxDate: moment()
    });

    // Para data final
    $('.finsh_datetimepicker').datetimepicker({
        format: 'DD/MM/YYYY',
        useCurrent: false, //Importante
        maxDate: moment()
    });


    // Data inicial nao pode ser maior em relação a data final
    $(".start_datetimepicker").on("dp.change", function(e) {
        $('.finsh_datetimepicker').data("DateTimePicker").minDate(e.date);
    });

    // Data final nao pode ser menor em relação a data inicial
    $(".finsh_datetimepicker ").on("dp.change", function(e) {
        $('.start_datetimepicker').data("DateTimePicker").maxDate(e.date);
    });


    $('.start_datetimepicker_1').datetimepicker({
        format: 'DD/MM/YYYY',
        //minDate: moment()
    });

    // Para data final
    $('.finsh_datetimepicker_1').datetimepicker({
        format: 'DD/MM/YYYY',
        useCurrent: false //Importante
    });


    // Data inicial nao pode ser maior em relação a data final
    $(".start_datetimepicker_1").on("dp.change", function(e) {
        $('.finsh_datetimepicker_1').data("DateTimePicker").minDate(e.date);
    });

    // Data final nao pode ser menor em relação a data inicial
    $(".finsh_datetimepicker_1 ").on("dp.change", function(e) {
        $('.start_datetimepicker_1').data("DateTimePicker").maxDate(e.date);
    });

    $(".initialDate").focus().blur();

    $('.initialDate1').datetimepicker({
        format: 'L',
        minDate: moment() - 1

    });
    $('.finalDate1').datetimepicker({
        format: 'L',
        minDate: moment() - 1
    });

    $(".initialDate1").focus().blur();


    $(".initialDate1").on("dp.change", function(e) {
        $('.finalDate1').data("DateTimePicker").minDate(e.date);
    });

    $(".finalDate1").on("dp.change", function(e) {
        $('.initialDate1').data("DateTimePicker").maxDate(e.date);
    });

    $('.initialDate2').datetimepicker({
        format: 'DD/MM/YYYY',
        minDate: moment() - 1

    });
    $('.finalDate2').datetimepicker({
        format: 'DD/MM/YYYY',
        useCurrent: false,
        minDate: moment() - 1
    });

    $(".initialDate2").focus().blur();


    $(".initialDate2").on("dp.change", function(e) {
        $('.finalDate2').data("DateTimePicker").minDate(e.date);
    });

    $(".finalDate2").on("dp.change", function(e) {
        $('.initialDate2').data("DateTimePicker").maxDate(e.date);
    });

    $(".input-taxi, .input-outros, .input-combustivel, .input-pedagio").inputmask('Regex', { regex: "^[0-9]+" });
});

$(function() {

    // Desabilita todos os Inputs do form
    $("#form-tickets :input").prop("disabled", true);
    $("#form-cars :input").prop("disabled", true);
    $("#form-lodgings :input").prop("disabled", true);
    $("#form-extras :input").prop("disabled", true);

    // Mantem o Toggle sempre habilitado
    $(".toggle-tf").prop("disabled", false);
    $(".toggle-tc").prop("disabled", false);
    $(".toggle-th").prop("disabled", false);
    $(".toggle-ttaxi").prop("disabled", false);
    $(".toggle-tpedadio").prop("disabled", false);
    $(".toggle-toutros").prop("disabled", false);
    $(".toggle-tcombustivel").prop("disabled", false);

    $(".toggle-alim").prop("disabled", false);

    // Mantem o btn de submit sempre habilitado
    $(".btn-dct").prop("disabled", false);

    if ($('.toggle-tf').prop('checked') || $('.toggle-tc').prop('checked') || $(".toggle-th").prop('checked')) {
        $("#form-tickets :input").prop("disabled", false);
        $("#form-cars :input").prop("disabled", false);
        $("#form-lodgings :input").prop("disabled", false);

        $('#car_type_id').selectpicker('destroy');
        $('#car_type_id').selectpicker('render');
        $('#car_type_id').change();

    }

    $('.type_ticket').change();

    if ($(".toggle-ttaxi").prop("checked")) {
        $(".input-taxi").prop('disabled', false);
    }
    if ($(".toggle-alim").prop("checked")) {
        $(".input-alim").prop('disabled', false);
    }

    if ($(".toggle-tpedadio").prop("checked")) {
        $(".input-pedagio").prop('disabled', false);
    }

    if ($(".toggle-toutros").prop("checked")) {
        $(".input-outros").prop('disabled', false);
        $(".input-espec").prop('disabled', false);
    }
    if ($(".toggle-tcombustivel").prop("checked")) {
        $(".input-combustivel").prop('disabled', false);
    }

    if ($(".toggle-topc").prop("checked")) {
        $(".opc :input").prop("disabled", false);
        $(".toggle-topc").prop("disabled", false);
    } else {
        $(".opc :input").prop("disabled", true);
        $(".toggle-topc").prop("disabled", false);
    }

    // Quando clica no Togle Habilita / desavilita os Inputs
    $('.toggle-tf').change(function() {

        // Se o toggle estiver habilitado
        if ($(this).prop('checked')) {
            $("#form-tickets :input").prop("disabled", false);
            $("#form-tickets :input").selectpicker('destroy');
            $("#form-tickets :input").selectpicker('render');
        }

        // Se o toggle nao estiver habilitado
        else {

            $("#form-tickets :input").prop("disabled", true);
            $(".toggle-tf").prop("disabled", false);
            $(".btn-dct").prop("disabled", false);
            $('.toggle.btn.btn-dct').addClass("off btn-default active").removeClass("btn-dct");
        }
    })
    $('.toggle-tc').change(function() {

        // Se o toggle estiver habilitado
        if ($(this).prop('checked')) {
            $("#form-cars :input").prop("disabled", false);
            $("#form-cars :input").selectpicker('destroy');
            $("#form-cars :input").selectpicker('render');

            if ($("#car_type_id").val() == '1') {
                $("#form-cars input[name='client_pay']").prop("disabled", false);
            } else {
                $("#form-cars input[name='client_pay']").prop("disabled", true);
            }
        }

        // Se o toggle nao estiver habilitado
        else {
            $("#form-cars :input").prop("disabled", true);
            $(".toggle-tc").prop("disabled", false);
            $(".btn-dct").prop("disabled", false);
            $("#form-cars input[name='client_pay']").prop("disabled", true);
        }
    })
    $(".toggle-tc").change();
    $('.toggle-th').change(function() {

        $("#form-cars :input").selectpicker('destroy');
        $("#form-cars :input").selectpicker('render');

        // Se o toggle estiver habilitado
        if ($(this).prop('checked')) {
            $("#form-lodgings :input").prop("disabled", false);
            $(".opc :input").prop("disabled", true);
            $(".toggle-topc").prop("disabled", false);
            $('button.dropdown-toggle.disabled').removeClass('disabled');
        }

        // Se o toggle nao estiver habilitado
        else {
            $('button.dropdown-toggle.disabled').removeClass('disabled');
            $("#form-lodgings :input").prop("disabled", true);
            $(".toggle-th").prop("disabled", false);
            $(".btn-dct").prop("disabled", false);
            $(".toggle-topc").prop("checked", false);
            $('.toggle.btn.btn-dct').addClass("off btn-default active").removeClass("btn-dct");
        }
    })
    $('.toggle-th').change();
    $('.toggle-topc').change(function() {

        // Se o toggle estiver habilitado
        if ($(this).prop('checked')) {
            $(".opc :input").prop("disabled", false);
            $(".toggle-topc").prop("disabled", false);
            $("#form-tickets :input").selectpicker('destroy');
            $("#form-tickets :input").selectpicker('render');
        }

        // Se o toggle nao estiver habilitado
        else {
            $(".opc :input").prop("disabled", true);
            $(".toggle-th").prop("disabled", false);
            $(".btn-dct").prop("disabled", false);
            $(".toggle-topc").prop("disabled", false);
        }
    })
});

$(".going_from_state_id").change(function() {
    var $dropdown = $(this);

    $.getJSON("/requests/airports/" + $dropdown.val(), function(data) {
        var $select = $('.going_from_airport_id');
        $select.find('option').remove();
        $.each(data, function(key, value) {
            $select.append('<option value=' + key + '>' + value + '</option>');
        });
        $select.selectpicker('destroy');
        $select.selectpicker('show');
    });

    $('.back_to_state_id').val($dropdown.val());
    $(".back_to_state_id").change()

});

$(".going_from_airport_id").change(function() {
    var $dropdown = $(this);
    $('.back_to_airport_id').val($dropdown.val());
    $('.back_to_airport_id').selectpicker('val', $dropdown.val());
});

$(".going_to_state_id").change(function() {
    var $dropdown = $(this);

    $.getJSON("/requests/airports/" + $dropdown.val(), function(data) {
        var $select = $('.going_to_airport_id');
        $select.find('option').remove();
        $.each(data, function(key, value) {
            $select.append('<option value=' + key + '>' + value + '</option>');
        });
        $select.selectpicker('destroy');
        $select.selectpicker('show');
    });
    $('.back_from_state_id').val($dropdown.val());
    $('.back_from_state_id').change();
});

$('.going_to_airport_id').change(function() {
    var $dropdown = $(this);
    $('.back_from_airport_id').val($dropdown.val());
    $('.back_from_airport_id').selectpicker('val', $dropdown.val());
})

$(".back_from_state_id").change(function() {
    var $dropdown = $(this);

    $.getJSON("/requests/airports/" + $dropdown.val(), function(data) {
        var $select = $('.back_from_airport_id');
        $select.find('option').remove();
        $.each(data, function(key, value) {
            $select.append('<option value=' + key + '>' + value + '</option>');
        });
        $select.selectpicker('destroy');
        $select.selectpicker('show');
    });
});

$(".back_to_state_id").change(function() {
    var $dropdown = $(this);

    $.getJSON("/requests/airports/" + $dropdown.val(), function(data) {
        var $select = $('.back_to_airport_id');
        $select.find('option').remove();
        $.each(data, function(key, value) {
            $select.append('<option value=' + key + '>' + value + '</option>');
        });
        $select.selectpicker('destroy');
        $select.selectpicker('show');
    });
});

$('#car_type_id').change(function() {
    var ticket = $(this);
    if (ticket.val() == "3") {
        $(".pri-condutor").prop("disabled", false).show();
        $(".seg-condutor").prop("disabled", false).show();
        $(".dates :input, .dates").prop("disabled", false).show();
        $(".retirada").removeAttr('required');
        $(".retirada").prop("disabled", true).hide();
        $(".devolucao").prop("disabled", true).hide();
        $(".devolucao").removeAttr('required');
    }
    if (ticket.val() == "2") {
        $(".retirada").removeAttr('required');
        $(".retirada").prop("disabled", true).hide();
        $(".devolucao").prop("disabled", true).hide();
        $(".devolucao").removeAttr('required');
        $(".pri-condutor").prop("disabled", true).hide();
        $(".pri-condutor").removeAttr('required');
        $(".seg-condutor").prop("disabled", true).hide();
        $(".seg-condutor").removeAttr('required');
        $(".dates :input, .dates").prop("disabled", true).hide();
    }
    if (ticket.val() == "1") {
        $(".retirada").prop("disabled", false).show();
        $(".devolucao").prop("disabled", false).show();
        $(".pri-condutor").prop("disabled", false).show();
        $(".seg-condutor").prop("disabled", false).show();
        $(".dates :input, .dates").prop("disabled", false).show();
    }
    if (ticket.val() == "") {
        $(".retirada").prop("disabled", true).hide();
        $(".devolucao").prop("disabled", true).hide();
        $(".pri-condutor").prop("disabled", true).hide();
        $(".seg-condutor").prop("disabled", true).hide();
        $(".dates :input, .dates").prop("disabled", false).hide();
    }
});

$(".toggle-ttaxi").change(function() {
    if ($(this).prop('checked')) {
        $(".input-taxi").prop('disabled', false);
    } else {
        $(".input-taxi").prop('disabled', true);
    }
});


$(".toggle-alim").change(function() {
    if ($(this).prop('checked')) {
        $(".input-alim").prop('disabled', false);
    } else {
        $(".input-alim").prop('disabled', true);
    }
});

$(".toggle-tcombustivel").change(function() {
    if ($(this).prop('checked')) {
        $(".input-combustivel").prop('disabled', false);
    } else {
        $(".input-combustivel").prop('disabled', true);
    }
});

$(".toggle-tpedadio").change(function() {
    if ($(this).prop('checked')) {
        $(".input-pedagio").prop('disabled', false);
    } else {
        $(".input-pedagio").prop('disabled', true);
    }
});

$(".toggle-toutros").change(function() {
    if ($(this).prop('checked')) {
        $(".input-outros").prop('disabled', false);
        $(".input-espec").prop('disabled', false);
    } else {
        $(".input-outros").prop('disabled', true);
        $(".input-espec").prop('disabled', true);
    }
});

$(".groups-select").change(function() {
    var $dropdown = $(this);
    $.getJSON("/clients/group/" + $dropdown.val(), function(data) {
        var $select = $('.clientes-select');
        $select.find('option').remove();
        $.each(data, function(key, value) {
            $select.append('<option value=' + key + '>' + value + '</option>');
        });
        $select.selectpicker('destroy');
        $select.selectpicker('show');
    });
});

$(".cities").change(function() {
    var $dropdown = $(this);
    var cidade = $dropdown.attr("id");
    $.getJSON("/cities/state/" + $dropdown.val(), function(data) {
        var $select = $("." + cidade);
        $select.find('option').remove();
        $.each(data, function(key, value) {
            $select.append('<option value=' + key + '>' + value + '</option>');
        });
        $select.selectpicker('destroy');
        $select.selectpicker('show');
    });
});

$(".confirmdata").click(function() {
    $("#modalConfirm").modal("show");
});

$(".canceldata").click(function() {
    $("#modalcancel").modal("show");
});

$("#form-lodgings").submit(function() {
    var title = $(".modal-title");
    var menssage = $(".alertMessages");

    var cidade1 = $("select.cidade1").val();
    var cidade2 = $("select.cidade2").val();

    if ($(".toggle-topc").prop('checked')) {
        if (cidade1 == cidade2) {

            title.html("Ops...");
            menssage.html("Os campos de 'Cidade' devem ser diferentes");

            $("#modalAlert").modal("show");
            return false
        }
    }
});

$(".distroy").click(function() {

    var distroyitem = $(this).attr('id');

    var title = $(".modal-title");
    var menssage = $(".alertMessages");

    title.html("Atenção!");
    menssage.html("Deseja mesmo finalizar esse projeto!");
    $('.alert-footer').find('.btn-danger').remove();
    $('.alert-footer').append('<a class="btn btn-danger" href="' + distroyitem + '"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Finalizar</a>');

    $("#modalAlert").modal("show");
});

$('.save-this').click(function() {
    var count = 8;
    var button = $(this);

    button.html('Habilitará em ' + count);
    button.attr('disabled', true);

    var timeOut = setInterval(function() {
        button.html('Habilitará em ' + count);
        button.attr('disabled', true);
        count--;
    }, 1000);

    setTimeout(function() {
        button.html(beforeHtml);
        button.removeAttr('disabled');
        window.clearTimeout(timeOut);
    }, 9000);

    $('#form-create-hours').submit();
})

$('.report-xlsx').click(function() {
    var pathname = window.location.pathname; // Returns path only
    var params = { report: "xlsx" };
    var url = window.location.search;
    url = url.replace("?", ''); // remove the ?
    $(".reports").attr("src", "");
    $(".reports").attr("src", pathname + "?report=xlsx&" + url);
});

$(".delete").click(getModalDelete);

function getModalDelete(elem) {
    if ($('#modal-table-details').hasClass('in')) {
        $('#modal-table-details').modal('toggle');
    }

    var distroyitem = $(this).attr('id');

    if (this === this.window) {
        distroyitem = $(elem).attr('id');
    }

    var title = $("#modalAlert .modal-title");
    var menssage = $("#modalAlert .alertMessages");

    title.html("Atenção!");
    menssage.html("Deseja mesmo remover este Item?");

    $('#modalAlert .alert-footer').find('.btn-danger').remove();
    $('#modalAlert .alert-footer').append('<a class="btn btn-danger" href="' + distroyitem + '" id="btn-confirm-exclude"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Remover</a>');

    $("#modalAlert").modal("show");
}


$(".hours").click(getModalHours);

function getModalHours(elem) {
    if ($('#modal-table-details').hasClass('in')) {
        $('#modal-table-details').modal('toggle');
    }

    var updateitem = $(this).attr('id');
    var hoursstatus = $(this).attr('data-hours');

    if (this === this.window) {
        updateitem = $(elem).attr('id');
    }

    var title = $("#modalAlert .modal-title");
    var menssage = $("#modalAlert .alertMessages");

    title.html("Atenção!");

    if (hoursstatus === '0') {
        $('#modalAlert .alert-footer').find('.btn-success').remove();
        menssage.html("Deseja mesmo permitir o prestador de serviço cadastrar horas?");
        $('#modalAlert .alert-footer').append('<a class="btn btn-success" href="' + updateitem + '" id="btn-confirm-add"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar</a>');

    } else {
        $('#modalAlert .alert-footer').find('.btn-danger').remove();
        menssage.html("Deseja mesmo não permitir o prestador de serviço cadastrar horas?");
        $('#modalAlert .alert-footer').append('<a class="btn btn-danger" href="' + updateitem + '" id="btn-confirm-exclude"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Remover</a>');
    }


    $("#modalAlert").modal("show");
}


$(".save-activities").click(function() {
    var $inputs = $('#form-create-hours :input');
    var values = {};

    var task_id = $(".task_id option:selected").text();
    var user_id = $(".user_id option:selected").text();
    var start_date = $(".start_date").val();


    var title = $(".modal-title");
    var menssage = $(".alertMessages");

    if (user_id == "" || user_id == "Selecione um ou mais colaboradores") {
        title.html("Campo obrigatório!");
        menssage.html("Selecione um ou mais colaboradores");
        $("#modalAlert").modal("show");
        return false;
    }
    if (start_date == "") {
        title.html("Campo obrigatório!");
        menssage.html("Selecione uma data");
        $("#modalAlert").modal("show");
        return false;
    }
    if (task_id == "Selecione uma tarefa" || task_id == "") {
        title.html("Campo obrigatório!");
        menssage.html("Selecione uma tarefa");
        $("#modalAlert").modal("show");
        return false;
    }

    $inputs.each(function() {
        values[this.name] = $(this).val();
    });

    var query = $.param(values)
    $.getJSON('/other-activities/list-possible-hours?' + query, function(data) {
        var table = $('.modal-result');
        var dia = $('.data');
        var tarefa = $('.tarefa');
        var local = $('.local');
        var sum = 0;

        table.find('tr,td').remove();

        $.each(data, function(key, value) {
            dia.text(value.date);
            tarefa.text(value.task);
            local.text(value.place);
            sum += value.hours_can_be_added;
            table.append('<tr class="' + key + '"> <td>' + value.collaborator + '</td> <td>' + value.date + '</td> <td>' + value.added_hours + '</td> <td>' + value.requested_hours + '</td> </tr>');

        });
        if (sum == 0) {
            $('.save_hours').prop("disabled", true);
        } else {
            $('.save_hours').prop("disabled", false);
        }
    });

    $("#createActivities").modal("show");
});

function paginate() {
    var input = $("#page").val();
    var title = $(".modal-title");
    var menssage = $(".alertMessages");

    if (input <= 0 || input == "") {
        title.html("Atenção!");
        menssage.html("Digite um valor valido.");
        $("#modalAlert").modal("show");
    } else {
        window.location.replace("?page=" + input);
    }
}

$('#page').keypress(function(e) {
    if (e.which == 13) {
        paginate();
    }
});


$(".reprove").click(function() {
    $("#modalAlert2").modal("show");
})
$(".recusar-btn").click(function() {
    $('#requestsRefuse').submit();
})


// Mantém os inputs em cache:
var inputs = $('#textarea');

// Chama a função de verificação quando as entradas forem modificadas
// Usei o 'change', mas 'keyup' ou 'keydown' são também eventos úteis aqui
inputs.on('keyup', verificarInputs);

function verificarInputs() {
    var preenchidos = true; // assumir que estão preenchidos
    inputs.each(function() {
        // verificar um a um e passar a false se algum falhar
        // no lugar do if pode-se usar alguma função de validação, regex ou outros
        if (!this.value) {
            preenchidos = false;
            // parar o loop, evitando que mais inputs sejam verificados sem necessidade
            return false;
        }
    });
    // Habilite, ou não, o <button>, dependendo da variável:
    $('.recusar-btn').prop('disabled', !preenchidos);
}

$(".project_id").change(function() {
    var $dropdown = $(this);

    $.getJSON("/requests/members/" + $dropdown.val(), function(data) {
        var $select = $('.collaborators_list');
        $select.find('option').remove();
        $.each(data, function(key, value) {
            $select.append('<option value=' + key + '>' + value + '</option>');
        });
        $select.selectpicker('destroy');
        $select.selectpicker('show');

        $('#form-projects select.collaborators_list').on('shown.bs.select', function(e) {
            $('.dropup.btn-translate').css({ 'z-index': -1 });
        });

        $('#form-projects select.collaborators_list').on('hidden.bs.select', function(e) {
            $('.dropup.btn-translate').css({ 'z-index': "" });
        });
    });
});


$('#btn-import').click(function() {
    $('#file').click();
});

$('#file').change(function() {
    if ($(this).val() != '') {
        $('#preloader').show();
        $('#status').show();
        /// $('#form-import').submit();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var form = new FormData($("form[name='form-import']")[0]);

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: '/import/upload',
            data: form,
            contentType: 'multipart/form-data',
            success: function(res) {
                console.log(res)
            },
            error: function(err) {
                console.log(err);
            },
            processData: false
        });
    }

});