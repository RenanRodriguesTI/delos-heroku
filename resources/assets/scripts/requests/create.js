if ( $('#form-requests').length ) {
    getCities('#form-requests #state_id', '#form-requests #city_id', '/cities/state/');
    getCities('#form-requests #second_state_id', '#form-requests #second_city_id', '/cities/state/');

    getCollaboratorsFromProject();
    updateTicketsOfReturnFromGoingFrom();
    updateDriverSelectFromCollaboratorsChoiced();
    updateCarFormFromCarType();

    datePickerForRequestDates();

    var datePickerToStart = [
        ['#going_arrival_date', '#back_arrival_date'],
        ['#withdrawal_date', '#return_date'],
        ['#check_in', '#checkout'],
        ['#food_start', '#food_finish']
    ];

    $.each(datePickerToStart, function (key, item) {
        startLinkedDatePicker(item[0], item[1]);
    });

    startTimePicker();
    validateExtraExpensesOthersBeforeSubmit();
}

function getCities(stateIdSelector, cityIdSelector, path) {
    $(stateIdSelector).change(function () {
        var url = path + $(this).val();

        $.getJSON(url, function (data) {

            var $select = $(cityIdSelector);

            $select.find('option').remove();

            $.each(data, function (key, value) {
                $select.append('<option value=' + key + '>' + value + '</option>');
            });
            $select.selectpicker('destroy');
            $select.selectpicker('show');
        });
    });
}

function datePickerForRequestDates() {
    var start  = $('#start'),
        finish = $('#finish');

    start.datetimepicker({
        format: 'DD/MM/YYYY',
        minDate: moment().subtract(1, 'd'),
        disabledDates: [moment().subtract(1, 'd')]
    });

    finish.datetimepicker({
        useCurrent: false,
        format: 'DD/MM/YYYY'
    });

    finish.on("dp.change", function (e) {
        updateProjectSelect();
        updateDatePicker('#start', e.date, 'maxDate');

        var date               = e.date.add(1, 'days'),
            datePickerToUpdate = [
                '#going_arrival_date', '#back_arrival_date', '#check_in', '#checkout', '#withdrawal_date', '#return_date', '#food_start', '#food_finish'
            ];

        $.each(datePickerToUpdate, function (key, item) {
            updateDatePicker(item, date, 'maxDate');
        });
    });
}

function startLinkedDatePicker(dateStart, dateFinish) {
    var dateStart  = $(dateStart),
        dateFinish = $(dateFinish);

    dateStart.datetimepicker({
        minDate: moment(),
        format: 'DD/MM/YYYY',
        useCurrent: false
    });

    dateFinish.datetimepicker({
        useCurrent: false,
        format: 'DD/MM/YYYY'
    });

    dateStart.on("dp.change", function (e) {
        dateFinish.data("DateTimePicker").minDate(e.date);
    });

    dateFinish.on("dp.change", function (e) {
        dateStart.data("DateTimePicker").maxDate(e.date);
    });
}

function startTimePicker(hour, minutes, seconds) {
    if ( hour === undefined ) {
        hour = 8;
    }

    if ( minutes === undefined ) {
        minutes = 0;
    }

    if ( seconds === undefined ) {
        seconds = 0;
    }

    var timePicker = $('.timepicker');

    timePicker.datetimepicker({
        format: 'LT',
        locale: 'en-US'
    });

    timePicker.on('dp.change', function (e) {
        if ( e.oldDate === null ) {
            $(this).data('DateTimePicker').date(new Date(e.date._d.setHours(hour, minutes, seconds)));
        }
    });
}

function updateProjectSelect() {
    var data = {};

    if ( $('#start').val() !== '' ) {
        data.start = moment($('#start').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');
    }

    if ( $('#finish').val() !== '' ) {
        data.finish = moment($('#finish').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');
    }

    $.ajax({
        dataType: "json",
        url: location.origin + '/projects',
        data: data,
        success: function (response) {
            $('#project_id').empty();

            $.each(response.data, function (key, item) {
                var html = "<option value=\"" + item.id + "\"\n data-subtext=\"" + item.description + "\">" + item.compiled_cod + "</option>";
                $('#project_id').append(html);
            });

            $('#project_id').selectpicker('refresh');
        }
    });
}

function getCollaboratorsFromProject() {
    $("#form-requests #project_id").change(function () {

        var url = '/projects/' + $(this).val() + '/members';

        $.getJSON(url, function (data) {
            var select = $('#form-requests #collaborators');
            select.find('option').remove();
            $.each(data, function (key, value) {
                select.append('<option value=' + key + '>' + value + '</option>');
            });
            select.selectpicker('refresh');
        });
    });
}

function updateTicketsOfReturnFromGoingFrom() {
    $(".going_from_airport_id").change(function () {
        var $dropdown = $(this);
        $('.back_to_airport_id').val($dropdown.val());
        $('.back_to_airport_id').selectpicker('val', $dropdown.val());
    });
}

function updateDriverSelectFromCollaboratorsChoiced() {
    $('#form-requests #collaborators').change(function () {
        var selectDriver = $('#first_driver_id');
        selectDriver.empty();

        $.each($(this).val(), function (key, value) {
            var name = $("#form-requests #collaborators option[value='" + value + "']").html();
            selectDriver.append('<option value=' + value + '>' + name + '</option>');
        });
        selectDriver.selectpicker('refresh');
    });
}

function updateCarFormFromCarType() {
    disableAndHide("#withdrawal-place-group");
    disableAndHide("#return-place-group");
    disableAndHide("#first-driver-group");
    disableAndHide("#withdrawal-date-group");
    disableAndHide("#return-date-group");
    disableAndHide("#withdrawal-hour-group");
    disableAndHide("#return-hour-group");
    disableAndHide("#car-client-pay-group");

    $('#car_type_id').change(function () {
        var self = $(this);
        if ( self.val() == "3" || self.val() == "2" ) {
            disableAndHide("#withdrawal-place-group");
            disableAndHide("#return-place-group");
            enableAndShow("#first-driver-group");
            enableAndShow("#withdrawal-date-group");
            enableAndShow("#return-date-group");
            enableAndShow("#withdrawal-hour-group");
            enableAndShow("#return-hour-group");
            disableAndHide("#car-client-pay-group");
        }
        if ( self.val() == "1" ) {
            enableAndShow("#withdrawal-place-group");
            enableAndShow("#return-place-group");
            enableAndShow("#first-driver-group");
            enableAndShow("#withdrawal-date-group");
            enableAndShow("#return-date-group");
            enableAndShow("#withdrawal-hour-group");
            enableAndShow("#return-hour-group");
            enableAndShow("#car-client-pay-group");
        }
    });
}

function disableAndHide(el) {
    $(el).hide();
    $(el + ' input').prop("disabled", true);
    $(el + ' select').prop("disabled", true);
    $(el + ' textarea').prop("disabled", true);
    $(el + ' select').selectpicker('refresh');
}

function enableAndShow(el) {
    $(el).show();
    $(el + ' input').prop("disabled", false);
    $(el + ' select').prop("disabled", false);
    $(el + ' textarea').prop("disabled", false);
    $(el + ' select').selectpicker('refresh');
}

function updateDatePicker(input, date, method) {
    if ( $(input).length ) {
        switch ( method ) {
            case 'minDate':
                $(input).data("DateTimePicker").minDate(date);
                break;
            case 'maxDate':
                $(input).data("DateTimePicker").maxDate(date);
                $(input).data("DateTimePicker").disabledDates([date]);
                break;
        }
    }
}

function validateExtraExpensesOthersBeforeSubmit() {
    $('#form-requests').submit(function (e) {
        if ( $('#other_description').length && $('#other_value').length ) {
            if ( $('#other_description').val().length > 0 && $('#other_value').val().length === 0 ) {
                alert('O campo descrição(Outros) é obrigatório quando valor(Outros) está presente.');
                e.preventDefault();
                return;
            } else if ( $('#other_value').val().length > 0 && $('#other_description').val().length === 0 ) {
                alert('O campo valor(Outros) é obrigatório quando descrição(Outros) está presente.');
                e.preventDefault();
                return;
            }
        }
    });
}