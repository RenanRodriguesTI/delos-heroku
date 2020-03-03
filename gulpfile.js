/**
 * Created by Dhales on 11/10/16.
 */

var elixir = require('laravel-elixir');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

var vendors = './node_modules/';

var scripts = [
    vendors + 'jquery/dist/jquery.min.js',
    vendors + 'js-cookie/src/js.cookie.js',
    vendors + 'bootstrap/dist/js/bootstrap.min.js',
    // vendors + 'bootstrap-select/dist/js/i18n/defaults-pt_BR.min.js',
    vendors + 'bootstrap-toggle/js/bootstrap-toggle.min.js',
    vendors + 'moment/min/moment.min.js',
    vendors + 'moment/locale/pt-br.js',
    vendors + 'eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
    vendors + 'jquery-validation/dist/jquery.validate.js',
    vendors + 'jquery.inputmask/dist/jquery.inputmask.bundle.js',
    vendors + 'bootstrap-daterangepicker/daterangepicker.js',
    vendors + 'bootstrap-3-typeahead/bootstrap3-typeahead.min.js',
    vendors + 'pusher-js/dist/web/pusher.min.js',
    vendors + 'izitoast/dist/js/iziToast.min.js',
    vendors + 'lodash/lodash.js',
    vendors + 'jquery-mask-plugin/dist/jquery.mask.min.js',
    vendors + 'tablesorter/dist/js/jquery.tablesorter.min.js',
    vendors + 'card/dist/jquery.card.js',
    vendors + 'material-scrolltop/src/material-scrolltop.js',
    vendors + 'cropper/dist/cropper.min.js',
    vendors + 'fastclick/lib/fastclick.js',
    vendors + 'x-editable/dist/bootstrap3-editable/js/bootstrap-editable.js',
    vendors + 'bootstrap-select/dist/js/bootstrap-select.min.js',
    './resources/assets/scripts/jquery.maskMoney.js',
    './resources/assets/scripts/requests/index.js',
    './resources/assets/scripts/requests/index.js',
    './resources/assets/scripts/requests/create.js',
    './resources/assets/scripts/debit-memos/index.js',
    './resources/assets/scripts/debit-memos/show.js',
    './resources/assets/scripts/btn-upload.js',
    './resources/assets/scripts/projects/index.js',
    './resources/assets/scripts/projects/create.js',
    './resources/assets/scripts/users/form.js',
    './resources/assets/scripts/helpers.js',
    './resources/assets/scripts/sidebar.js',
    './resources/assets/scripts/preloader.js',
    './resources/assets/scripts/pusher.js',
    './resources/assets/scripts/notifications.js',
    './resources/assets/scripts/plans/createAndEdit.js',
    './resources/assets/scripts/clients/createAndEdit.js',
    './resources/assets/scripts/checkout/checkout.js',
    './resources/assets/scripts/reports/budgetedVsActual.js',
    './resources/assets/scripts/doubleScroll.js',
    './resources/assets/scripts/avatar.js',
    './resources/assets/scripts/jsgantt.js',
    './resources/assets/scripts/allocations/create.js',
    './resources/assets/scripts/allocations/index.js',
    './resources/assets/scripts/activities/create.js',
    './resources/assets/scripts/coast-users/index.js',
    './resources/assets/scripts/expenses/core.js',
    './resources/assets/scripts/core.js'
];

var styles = [
    vendors + 'bootstrap/dist/css/bootstrap.min.css',
    './resources/assets/styles/theme.css',
    vendors + 'bootstrap-select/dist/css/bootstrap-select.min.css',
    vendors + 'bootstrap-toggle/css/bootstrap-toggle.min.css',
    vendors + 'bootstrap-daterangepicker/daterangepicker.css',
    vendors + 'izitoast/dist/css/iziToast.min.css',
    vendors + 'animate.css/animate.min.css',
    vendors + 'tablesorter/dist/css/theme.default.min.css',
    vendors + 'material-scrolltop/src/material-scrolltop.css',
    vendors + 'cropper/dist/cropper.min.css',
    vendors + 'x-editable/dist/bootstrap3-editable/css/bootstrap-editable.css',
    vendors + 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
    './resources/assets/styles/btn-upload.css',
    './resources/assets/styles/modal.css',
    './resources/assets/styles/index_with_menu.css',
    './resources/assets/styles/preloader.css',
    './resources/assets/styles/contacts.css',
    './resources/assets/styles/notifications.css',
    './resources/assets/styles/pricing.css',
    './resources/assets/styles/checkout.css',
    './resources/assets/styles/jsgantt.css',
    './resources/assets/styles/core.css'
];

elixir(function (mix) {

    mix.scripts(scripts);

    mix.styles(styles);

    mix.copy('./resources/assets/images', 'public/images');

    mix.copy(vendors + 'bootstrap/dist/fonts', 'public/fonts');

    mix.copy(vendors + 'bootstrap/dist/fonts', 'public/build/fonts');

    mix.copy(vendors + 'material-scrolltop/src/icons', 'public/build/css/icons');

    mix.copy(vendors + 'x-editable/dist/bootstrap3-editable/img', 'public/build/img');

    mix.version([
        'css/all.css',
        'js/all.js'
    ]);
});