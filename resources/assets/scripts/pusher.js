$(document).ready(function () {
    if (Cookies.get('APP_ENV') !== 'production') {
        Pusher.logToConsole = true;
    }

    var pusher = new Pusher('bdc6332ed106115c04f0', {
        cluster: 'us2',
        encrypted: true
    });

    var channel = pusher.subscribe('notifications');

    var eventName = Cookies.get('APP_ENV') == 'production' ? 'notificationsOnProduction' : 'notificationsOnLocal';

    channel.bind(eventName, function (data) {

        if (Cookies.get('user_logged') == data.userId) {
            $('.badge').css('display', '');

            iziToast.show({
                id: 'haduken',
                title: data.title.trim(),
                message: "<br>" + data.message.trim(),
                position: 'bottomRight',
                transitionIn: 'flipInX',
                transitionOut: 'flipOutX',
                progressBarColor: 'linear-gradient(to bottom, #24A830 0%, #fff 150%)',
                layout: 2,
                maxWidth: 500,
                timeout: 10000
            });

            var html = "<li class=\"new animated pulse\">\n" +
                "<a>\n" +
                "<span class=\"bold\">\n" +
                "<span>\n" +
                data.title + "\n" +
                "</span>\n" +
                "</span>\n" +
                "<br>\n" +
                "<span class=\"message\">\n" +
                data.message + "\n" +
                "</span>\n" +
                "</a>\n" +
                "</li>"

            $('.msg_list .scroll').prepend(html);

            setTimeout(function () {
                $('.msg_list .scroll li').removeClass('animated').removeClass('pulse');
            }, 1000);
        }
    });

    $('.info-number').click(function () {
        setTimeout(function () {
            $('.msg_list .scroll li').removeClass('new');
            $('.badge').css('display', 'none');
        }, 4000)
    });
});