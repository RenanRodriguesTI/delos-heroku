$(function() {
    $('#requests_index input[name="period"]').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        },
        autoApply: true,
        autoUpdateInput: false
    });
});

$('#requests_index input[name="period"]').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
});