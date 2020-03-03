/**
 * Created by allan on 16/07/17.
 */
$(window).on('load', function() {
    $('#status').fadeOut();
    $('#preloader').delay(350).fadeOut('slow');
    $('body').delay(350).css({'overflow':'visible'});
    $('body').delay(350).css({'overflow-x':'hidden'});
});
