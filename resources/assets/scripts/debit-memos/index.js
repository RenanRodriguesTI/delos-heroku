if ($('#debit-memo-table').length > 0) {

    $("#search button[type='submit']").click(function () {
        var input = $('#search input');
        var value = input.val();

        $('#search input').val(value.replace(/\b0+/g, ''));
    });

    function pad_with_zeroes(number, length) {

        var my_string = '' + number;
        while (my_string.length < length) {
            my_string = '0' + my_string;
        }

        return my_string;

    }

    var val = $('#search input').val();

    if (val.length > 0) {
        $('#search input').val(pad_with_zeroes(val, 4));
    }
}