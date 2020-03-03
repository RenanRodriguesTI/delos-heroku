if ( $('#form-create-hours').length ) {
    $("#activities-project_id").change(function() {
        var projectId = $(this).val();

        $.ajax({
            url: "/projects/" + projectId + '/members',

            success: function(result) {

                var select = $("#user_id");
                select.find('option').remove();
                $.each(result, function (key, value) {
                    select.append('<option value=' + key +'>' + value + '</option>');
                });

                select.selectpicker('refresh');
            }
        });

        $.ajax({
            url: '/projects/' + projectId + '/tasks',

            success: function (result) {
                var select = $("#task_id");
                select.find('option').remove();
                $.each(result, function (key, value) {
                    select.append('<option value=' + key +'>' + value + '</option>');
                });

                select.selectpicker('refresh');
            }
        });

        $.getJSON('/projects/' + projectId + '/show', function (response) {
            var dateStart = moment(response.start, 'YYYY-MM-DD');
            $('#start_date').data("DateTimePicker").minDate(dateStart.format('DD/MM/YYYY'));
        });
    });
}