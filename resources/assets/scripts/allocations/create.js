$(document).ready(function () {
    if ( $('#form-allocation').length ) {
        //Caso haja projeto selecionado aplicar alterações para seus respectivos inputs
        if ( $('#project_id').val() ) {
            changeInputsOfProjects();
        }

        //Adiciona o valor do user_id no user_id_old
        $('#user_id').change(function () {
            $('#user_id_old').val($(this).val());
        });

        //Adiciona o valor do task_id no task_id_old
        $('#task_id').change(function () {
            $('#task_id_old').val($(this).val());
        });

        //Date picker início da alocação
        $('#start').datetimepicker({
            format: 'L',
        });

        //Date picker fim da alocação da alocação
        $('#finish').datetimepicker({
            format:        'L',
            useCurrent:    false,
            minDate:       moment().subtract(1, 'days'),
            disabledDates: [
                moment().subtract(1, 'days')
            ]
        });

        // A data de inicío será a data mínima
        $("#start").on("dp.change", function (e) {
            $('#finish').data("DateTimePicker").minDate(e.date);
        });

        // A data de fim será a data máxima
        $("#finish").on("dp.change", function (e) {
            $('#start').data("DateTimePicker").maxDate(e.date);
        });

        // Scripts quando o select de projeto for alterado o valor
        $('#project_id').change(function (event) {
            changeInputsOfProjects(event);
        });

        // Exibe modal para detalhamento das alocações diárias
        $('#form-allocation').submit(function (event) {

            if ( !$("#daily-allocation-details").is(':visible') ) {
                event.preventDefault();
                
                $('.info').hide();

                var data = {
                    'start':      $('#start').val(),
                    'finish':     $('#finish').val(),
                    'user_id':    $('#user_id').val(),
                    'project_id': $('#project_id').val(),
                    'hours':      $('#hours').val()
                };

                var query = $.param(data);
                $.getJSON('/allocations/check-period-hours?' + query)
                .done(function (response) {

                    $('.modal-result').empty();

                    $.each(response.possibles, function (key, item) {
                        var checkDailyHours = (item.actual_hours + item.hours_to_add) > 24;

                        var html = "<tr>" +
                            "<td>" + response.user.name + "</td>" +
                            "<td>" + item.date + "</td>" +
                            "<td>" + response.project.full_description + "</td>" +
                            "<td class='text-center'>" + item.actual_hours + "</td>" +
                            "<td class='text-center'>" + item.hours_to_add + "</td>" +
                            "</tr>";

                        $('.modal-result').append(html);

                        if ( checkDailyHours ) {
                            $('.modal-result tr td:last-child').addClass('alert-danger');
                            $('.info').show();
                            $('.daily-submit-form').attr('disabled', true);
                        } else {
                            $('.daily-submit-form').attr('disabled', false);
                        }
                    });

                    $("#daily-allocation-details").modal('toggle');
                });
            }
        });

        $('.daily-submit-form').click(function () {
            var count      = 8;
            var button     = $(this);

            button.html('Habilitará em ' + count);
            button.attr('disabled', true);

            var timeOut = setInterval(function () {
                button.html('Habilitará em ' + count);
                button.attr('disabled', true);
                count--;
            }, 1000);

            setTimeout(function () {
                button.html(beforeHtml);
                button.removeAttr('disabled');
                window.clearTimeout(timeOut);
            }, 9000);
            
            $('#form-allocation').submit();
        });
    }
});

function changeInputsOfProjects() {

    // Adicionar os membros do projeto no select
    $.getJSON('/projects/' + $('#project_id').val() + '/members', function (response) {
        $('#user_id').empty();
        $.each(response, function (key, item) {
            if ( key == $('#user_id_old').val() ) {
                $('#user_id').append("<option value='" + key + "' selected='selected'>" + item + "</option>");
            } else {
                $('#user_id').append("<option value='" + key + "'>" + item + "</option>");
            }
            $('#user_id').selectpicker('refresh');
        });
    });

    // Adicionar as tarefas do projeto no select
    $.getJSON('/projects/' + $('#project_id').val() + '/tasks', function (response) {
        $('#task_id').empty();
        $.each(response, function (key, item) {
            if ( key == $('#task_id_old').val() ) {
                $('#task_id').append("<option value='" + key + "' selected='selected'>" + item + "</option>");
            } else {
                $('#task_id').append("<option value='" + key + "'>" + item + "</option>");
            }
            $('#task_id').selectpicker('refresh');
        });
    });

    // Alterar a data máxima da alocação de acordo com a data de finalização do projeto
    $.getJSON('/projects/' + $('#project_id').val() + '/show', function (response) {
        var date = moment(response.finish, 'YYYY-MM-DD');
        $('#finish').data("DateTimePicker").maxDate(date.add(1, 'days').format('DD/MM/YYYY'));
        $('#finish').data("DateTimePicker").disabledDates([date.add(1, 'days').format('DD/MM/YYYY')]);
    });
}