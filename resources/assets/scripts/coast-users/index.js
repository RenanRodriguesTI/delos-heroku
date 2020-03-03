if ( $('#coast-users-table').length ) {
    // Verifica se existe cookie para o mês, caso não tenha defini no mês atual
    if ( Cookies.get('month_coast_users') == undefined ) {
        Cookies.set('month_coast_users', getMonth(new Date()));
    }

    // Verifica se existe cookie para o ano, caso não tenha defini no ano atual
    if ( Cookies.get('year_coast_users') == undefined ) {
        Cookies.set('year_coast_users', moment().format('Y'));
    }

    // Altera o cookie do mês conforme a aba exibida
    alterMonthCookieOnChangeTab();

    // Altera o cookie do ano conforme valor selecionado no select #year
    alterYearCookieOnSelectTab();

    // Selecione no select de anos o que está em cookie
    $('#year').val(Cookies.get('year_coast_users'));

    // Habilita o x-editable para alterar o valores
    editableInit();
}

function getMonth(date) {
    var monthNames = [
        "January", "February", "March",
        "April", "May", "June", "July",
        "August", "September", "October",
        "November", "December"
    ];

    var monthIndex = date.getMonth();

    return monthNames[monthIndex];
}

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function alterMonthCookieOnChangeTab() {
    $('#coast-users-tab a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
        Cookies.set('month_coast_users', capitalizeFirstLetter($(e.target).attr('href').replace('#', '')));
    });
}

function alterYearCookieOnSelectTab() {
    $('#year').change(function () {
        Cookies.set('year_coast_users', $(this).val());
        window.location.reload()
    });
}

function editableInit() {
    $('.editable-money').editable({
        emptytext:   'R$ ---',
        ajaxOptions: {
            type:     'put',
            dataType: 'json'
        },
        params:      function (params) {
            var data          = {};
            data['date']      = Cookies.get('month_coast_users');
            data['year']      = Cookies.get('year_coast_users');
            data['user_id']   = params.pk;
            data['_token']    = $("meta[name=csrf-token]").attr("content");
            data[params.name] = params.value;
            return data;
        },
        success:     function (response, newValue) {
            if ( response.status == 'error' ) return response.msg;
            iziToast.show({
                id:               'haduken',
                title:            "Sucesso",
                message:          'Campo atualizado com sucesso!',
                position:         'bottomRight',
                transitionIn:     'flipInX',
                transitionOut:    'flipOutX',
                progressBarColor: 'linear-gradient(to bottom, #24A830 0%, #fff 150%)',
                layout:           2,
                maxWidth:         500,
                timeout:          10000
            });
        }
    });

    $('.editable-money').on('shown', function () {
        $(this).data('editable').input.$input.maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
    });
}