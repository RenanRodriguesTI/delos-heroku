var CURRENT_URL = window.location.href.split('?')[0],
    $BODY = $('body'),
    $LOGO = $('#sidebar-logo'),
    $LOGO_OWL = $('#sidebar-owl'),
    $MENU_TOGGLE = $('#menu_toggle'),
    $SIDEBAR_MENU = $('#sidebar-menu'),
    $SIDEBAR_FOOTER = $('.sidebar-footer'),
    $LEFT_COL = $('.left_col'),
    $RIGHT_COL = $('.right_col'),
    $NAV_MENU = $('.nav_menu'),
    $FOOTER = $('footer');

// Sidebar
$(document).ready(function() {
    
    // TODO: This is some kind of easy fix, maybe we can improve this
    var setContentHeight = function () {
        // reset height
        $RIGHT_COL.css('min-height', $(window).height());

        var bodyHeight = $BODY.outerHeight(),
            footerHeight = $BODY.hasClass('footer_fixed') ? 0 : $FOOTER.height(),
            leftColHeight = $LEFT_COL.eq(1).height() + $SIDEBAR_FOOTER.height(),
            contentHeight = bodyHeight < leftColHeight ? leftColHeight : bodyHeight;

        // normalize content
        contentHeight -= $NAV_MENU.height() + footerHeight;

        $RIGHT_COL.css('min-height', $(window).height());
    };

    $SIDEBAR_MENU.find('a').on('click', function(ev) {
        var $li = $(this).parent();

        if ($li.is('.active')) {
            $li.removeClass('active active-sm');
            $('ul:first', $li).slideUp(function() {
                setContentHeight();
            });
        } else {
            // prevent closing menu if we are on child menu
            if (!$li.parent().is('.child_menu')) {
                $SIDEBAR_MENU.find('li').removeClass('active active-sm');
                $SIDEBAR_MENU.find('li ul').slideUp();
            }

            $li.addClass('active');

            $('ul:first', $li).slideDown(function() {
                setContentHeight();
            });
        }
    });

    // toggle small or large menu
    $MENU_TOGGLE.on('click', function() {
        if (Cookies.get('menu-open') == 'true') {
            Cookies.set('menu-open', false);
        }else {
            Cookies.set('menu-open', true);
        }

        if ($BODY.hasClass('nav-md')) {
            $SIDEBAR_MENU.find('li.active ul').hide();
            $SIDEBAR_MENU.find('li.active').addClass('active-sm').removeClass('active');
                        $LOGO.css('display', 'none');
            $LOGO_OWL.css('display', 'initial');
        } else {
            $SIDEBAR_MENU.find('li.active-sm ul').show();
            $SIDEBAR_MENU.find('li.active-sm').addClass('active').removeClass('active-sm');
                        $LOGO.css('display', '-webkit-box');
            $LOGO_OWL.css('display', 'none');
        }

        $BODY.toggleClass('nav-md nav-sm');

        toggleSidebarLogo();

        setContentHeight();
    });

    toggleSidebarLogo();

    function toggleSidebarLogo() {
//        if ($BODY.hasClass('nav-md') && Cookies.get('menu-open') == 'true') {
//            $LOGO.css('display', '-webkit-box');
//            $LOGO_OWL.css('display', 'none');
//        } else {
//            $LOGO.css('display', 'none');
//            $LOGO_OWL.css('display', 'initial');
//        }
    }


    // check active menu
    $SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').parent('li').addClass('current-page');

    $SIDEBAR_MENU.find('a').filter(function () {
        return this.href == CURRENT_URL;
    }).parent('li').addClass('current-page').parents('ul').slideDown(function() {
        setContentHeight();
    }).parent().addClass('active');

    // recompute content when resizing
    $(window).smartresize(function(){
        setContentHeight();
    });

    setContentHeight();

    // fixed sidebar
    if ($.fn.mCustomScrollbar) {
        $('.menu_fixed').mCustomScrollbar({
            autoHideScrollbar: true,
            theme: 'minimal',
            mouseWheel:{ preventDefault: true }
        });
    }

    if (Cookies.get('menu-open') == 'true' && $(window).width() > 768) {
        if ($BODY.hasClass('nav-md')) {
            $SIDEBAR_MENU.find('li.active ul').hide();
            $SIDEBAR_MENU.find('li.active').addClass('active-sm').removeClass('active');
                        $LOGO.css('display', 'none');
            $LOGO_OWL.css('display', 'initial');
        } else {
            $SIDEBAR_MENU.find('li.active-sm ul').show();
            $SIDEBAR_MENU.find('li.active-sm').addClass('active').removeClass('active-sm');
                                    $LOGO.css('display', '-webkit-box');
            $LOGO_OWL.css('display', 'none');
        }

        $BODY.toggleClass('nav-md nav-sm');

        setContentHeight();
    }
});