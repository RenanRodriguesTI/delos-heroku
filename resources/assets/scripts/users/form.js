/**
 * Created by allan on 29/03/17.
 */

if ($('#form-users').length) {
    function startDatePickerAdmission() {

        $("#admission").daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            },
            "singleDatePicker": true,
            'maxDate': moment()
        });
    }

    startDatePickerAdmission();
}