if ($('#nd-code').length > 0) {
    $('.nd-container').on('click', function () {
        $('#nd-code').css('display', 'none');
        $('#nd-input').css('display', '');
        $('#nd-input').focus();
    });

    $('#nd-input').blur(function () {
        $('#nd-code').css('display', '');
        $('#nd-input').css('display', 'none');

        $.ajax({
            url: $(location).attr('href').replace('show', 'edit'),
            type: 'PUT',
            data: {
                'number': $(this).val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            error: function(error){
                $('#nd-input').val($('#nd-code').html());
                alert(error.responseJSON.number[0]);
            },
            success: function(result) {
                var newNumber = pad(result.number, 4);
                $('#nd-code').html(newNumber);
            }
        });
    });

    function pad(value, length) {
        return (value.toString().length < length) ? pad("0"+value, length):value;
    }
}