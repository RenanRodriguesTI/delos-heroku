var cookieName = 'tab-budgeted-vs-actual-index';

$(document).ready(function() {

    if ($('#budgeted-vs-actual').length) {
        tabSingleton();

        $('.tablesorter').tablesorter(getTableSorterOptions());
        $('.form-user-value').submit(formUserValueOptions);
        $('.btn-edit-user-value').click(showModalFormOptions);
    }
    $('.table-details tr td:not(.has-btn-group)').click(getTableDetailsOptions);

});

function triggerToast(response) {
    iziToast.show({
        id: 'haduken',
        message: "<br>" + response.message + "<br><br> A página irá atualizar automaticamente",
        position: 'bottomRight',
        transitionIn: 'flipInX',
        transitionOut: 'flipOutX',
        progressBarColor: 'linear-gradient(to bottom, #24A830 0%, #fff 150%)',
        layout: 2,
        maxWidth: 500,
        timeout: 9990
    });

    setTimeout(function() {
        location.reload();
    }, 10000);
}

function formExtraExpenseOptions(elem) {
    event.preventDefault();

    var data = serialize(elem);
    var id = $(elem).attr('data-id');

    $.ajax({
        url: $(elem).attr('data-route'),
        data: data,
        type: 'PUT',
        success: function(response) {
            $(elem).parent().children('form.form-update-extra-expenses').css('display', 'none');
            $(elem).parent().children('span:nth-child(2)').css('display', 'inline-block');

            $('.extra-expenses-' + id).each(function(key, item) {
                $(item).empty();
                $(item).html(data.extra_expenses);
            });

            triggerToast(response);
        },
        error: function(response) {
            alert("Valor incorreto, tente novamente");
        }
    });
}

function showModalFormOptions() {
    $('#modal-' + $(this).attr('id')).modal('toggle');
}

function formUserValueOptions(event) {
    event.preventDefault();

    var data = serialize(this);
    var id = $(this).attr('data-id');

    $.ajax({
        url: $(this).attr('data-route'),
        data: data,
        type: 'PUT',
        success: function(response) {

            $('a#user-' + id + ' .price').html(data.value);
            $('#modal-user-' + id).modal('toggle');

            triggerToast(response);
        },
        error: function(response) {
            alert("Valor incorreto, tente novamente");
        }
    });
}

function serialize(elem) {
    return $(elem).serializeArray().reduce(function(obj, item) {
        obj[item.name] = item.value;
        return obj;
    }, {});
}

function tabSingleton() {
    var linksTab = $("ul[role='tablist'] li[role='presentation'] a");
    var index = getTabIndex();

    $(linksTab[index]).tab('show');

    linksTab.on('shown.bs.tab', function() {
        $(this).parent().parent().children().each(function(key, elem) {
            if ($(elem).hasClass('active')) {
                Cookies.set(cookieName, key);
            }
        });
    });
}

function getTableSorterOptions() {
    return {
        sortReset: true
    };
}

function getTableDetailsOptions() {
    var row = $(this).parent();
    var html = "<ul class=\"list-group\">";
    var title = 'Detalhes de ';

    $.each(row[0].cells, function(key, item) {
        var thead = $(item).parent().parent().parent().children('thead').children('tr');

        if (!$(thead[0].cells[key]).html()) {
            title += $(item).html();
            return true;
        }

        var divDescription = $(item).children('div');
        if (divDescription.hasClass('description')) {
            $.each(divDescription.children('div'), function(key, item) {
                html += "<li class=\"list-group-item\"><span style='color: #1f8128;'>" + $(item).children('span.name').html() + ": </span>" + $(item).children('span.value').html() + "</li>";
            });

            return;
        }

        html += "<li class=\"list-group-item\"><span style='color: #1f8128;'>" + $(thead[0].cells[key]).html() + ": </span>" + $(item).html() + "</li>";
    });

    html += "</ul>";

    if (title == 'Detalhes de ') {
        title += row[0].cells[0].innerHTML;
    }

    var modalBody = $('#modal-table-details .modal-body');
    var modalTitle = $('#modal-table-details .modal-title');

    modalBody.empty();
    modalTitle.empty();

    modalBody.append(html);
    modalTitle.append(title);

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

    $('#modal-table-details').modal('show')
}

function getTabIndex() {
    var index = Cookies.get(cookieName) ? Cookies.get('tab-budgeted-vs-actual-index') : 0;
    return index;
}

function showFormUpdateExtraExpenses(elem) {
    $(elem).parent().children('form.form-update-extra-expenses').css('display', 'inline-block');
    applyMaskMoney('input#value, input.value', "R$");
    $(elem).parent().children('span:nth-child(2)').css('display', 'none');
}