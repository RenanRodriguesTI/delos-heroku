if ($('#nd-code').length > 0) {
    $('.nd-container').on('click', function() {
        $('#nd-code').css('display', 'none');
        $('#nd-input').css('display', '');
        $('#nd-input').focus();
    });

    $('#nd-input').blur(function() {
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
            error: function(error) {
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
        return (value.toString().length < length) ? pad("0" + value, length) : value;
    }
}


$(document).ready(function() {
    $('a[data-href]').bind('click', function() {
        var url = new URL($(this).attr('data-href'));
        var path = url.pathname.split('/');
        var urlSecond = url.origin + '/images/invoices/' + path[(path.length - 1)];
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

});