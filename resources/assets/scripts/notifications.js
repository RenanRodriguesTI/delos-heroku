$(document).ready(function () {
    if ($('.mail_list_column').length) {
        $('.mail_list_column').css('height', $(window).height() - 139);
        $('.mail_view').css('height', $(window).height() - 139);

        $('.mail_list_column>a').first().addClass('active');
        $('.mail').fadeOut(300);

        changeActiveView($(".mail_list_column>a[class='active']"));

        $('.mail_list_column>a').click(function () {
            $('.mail').fadeOut(300);
            changeActiveView($(this));
        });

        function changeActiveView(elem) {
            $('.active').removeClass('active');
            elem.addClass('active');
            var activeId = elem.attr('id').split('related-')[1];
            setTimeout(function () {
                $('#related-view-' + activeId).fadeIn(300);
            }, 300);
        }
    }
});