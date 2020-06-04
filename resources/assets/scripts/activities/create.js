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

$('#allProjectActivity').change(function(){
    var codExpense = $('#request_selected').val() ?'&cod'+$('#request_selected').val():'';
    var formatUSA = 'YYYY-MM-DD';


    var url = location.origin +'/activities?showall='+$(this).prop('checked')+codExpense;
   
    $.getJSON(url, function(data, status) {
        $('#activities-project_id').empty();
        var select = $('#activities-project_id');
        $.each(data, function(index, value) {
            var html = "<option value='" + index + "' data-subtext='" + value + "' class='option-dynamic'>" + value + "</option>";
            select.append(html);
        });
        $('#activities-project_id').selectpicker('destroy');
        $('#activities-project_id').selectpicker(); 
    });
})