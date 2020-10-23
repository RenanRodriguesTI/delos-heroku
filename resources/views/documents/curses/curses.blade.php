<div id="curses" class="panel panel-dct  tab-pane fade">
    <div class="panel-heading">
        <h3 class="panel-title bold">Cursos</h3>
    </div>
    <div class="panel-body">

        <a href="{{route('documents.index')}}?curse=1" class="btn btn-default">
            <span class="glyphicon glyphicon-arrow-left"></span>
            Voltar
        </a>

        <div class="pull-right">
            <!-- <button id="addCurse" class="btn btn-dct" data-toggle='modal' data-target="#curse-form">Adicionar</button> -->
        </div>

    </div>

    @include("documents.curses.search")

    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="curse-table">
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Data de Conclusão</th>
                        <th>Data de Renovação</th>
                        <th style="display: none;">Arquivo</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($curses as $key=> $curse)
                    <tr class="curse-{{$curse->id}}">
                        <td>{{$curse->name}}</td>
                        <td>{{$curse->end_date ? $curse->end_date->format('d/m/Y') : "Não especificado"}}</td>
                        <td>{{$curse->renewal_date ? $curse->renewal_date->format('d/m/Y') : "Não especificado"}}</td>
                        <td style="display:none">{{$curse->filename}}</td>
                        <td>
                            <div class="btn-group {{$key<=3 ? 'dropdown':'dropup'}}">
                                <button type="button" class="btn {{$curse->expired? 'btn-warning':'btn-dct'}} btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="btn-options-users-{{$key}}">
                                    <span class="glyphicon glyphicon-cog"></span>
                                    @lang('buttons.options') &nbsp;<span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">

                                    <li class="divider"></li>


                                    @if($curse->file_s3)
                                    <li>
                                        <a href="{{$curse->file_url}}" target="_blank">
                                            <span class="glyphicon glyphicon-eye-open"></span> Visualizar Termo
                                        </a>
                                    </li>

                                    <li class="divider"></li>
                                    @endif
                                </ul>

                            </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    <div class="panel-footer">
        <div class="text-right">
            {{$curses->render()}}
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        if ($('#end_date ~ .help-block strong').html() ||
            $('#renewal_date ~ .help-block strong').html() ||
            $('#namecurse ~ .help-block strong').html()) {
            $('#curse-form').modal('show');
            $('#curse-form').attr('action', '/curses/' + $('#id').val() + '/update')
        }


        var elements = $('table#curse-table tbody tr');
        elements = elements.sort(function(a, b) {
            if ($(a).attr('class').indexOf("expired") == -1 && $(b).attr('class').indexOf("expired") > -1) {
                return 1;
            } else {
                if ($(a).attr('class').indexOf("expired") > -1 && $(b).attr('class').indexOf("expired") == -1) {
                    return -1;
                }
            }
            return 0;
        });

        $('table#curse-table tbody').html("");

        $.each(elements, function() {
            $('table#curse-table tbody').append(this);
        });


        $('a[data-edit-curse]').click(function() {
            var curse = $(this).attr('data-edit-curse');


            var renewal = $($('tr.curse-' + curse + ' td')[2]).html() == "Não especificado" ? '' : $($('tr.curse-' + curse + ' td')[2]).html();
            var end = $($('tr.curse-' + curse + ' td')[1]).html() == "Não especificado" ? '' : $($('tr.curse-' + curse + ' td')[1]).html();
            console.log($($('tr.curse-' + curse + ' td')[0]).html())
            $('#namecurse').val($($('tr.curse-' + curse + ' td')[0]).html());
            $('#end_date').val(end);
            $('#renewal_date').val(renewal);
            $('#filenamecurse').val($($('tr.curse-' + curse + ' td')[3]).html())
            $('#idcurse').val($(this).attr('data-edit-curse'));
            $('#curse-form').attr('action', $(this).attr('data-edit-curse-route'));
            $('#curse-form').modal('show');

        });
    });



    $('#addCurse').click(function() {
        $('#curse-form').attr('action', '/curses/store');
    });


    $('#saveCurse').click(function() {
        $('#preloader').show();
        $('#status').show();
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: $('#curse-form').attr('action'),
            data: new FormData($('#curse-form')[0]),
            processData: false,
            contentType: false,
            success: function(res) {
                if( $('a[data-redirect]').attr('data-redirect')){
                    window.location.href = $('a[data-redirect]').attr('data-redirect');
                } else{
                    window.location.reload(true);
                }

                
            },
            error: function(err) {
                console.log(err)
                switch (err.status) {
                    case 422:

                        Object.keys(err.responseJSON).forEach(function(item) {
                            switch (item) {
                                case "renewal_date":
                                    $(".renewalDateCurse").addClass('has-error')
                                    $("#renewal_date ~ .help-block strong").html(err.responseJSON[item][0]);
                                    break;
                                case "end_date":
                                    $(".endDateCurse").addClass('has-error');
                                    $("#end_date ~ .help-block strong").html(err.responseJSON[item][0]);
                                    break;

                                case "name":
                                    $('.nameCurse').addClass("has-error");
                                    $("#namecurse ~ .help-block strong").html(err.responseJSON[item][0]);
                                    break;
                            }
                        });

                        break;
                    case 403:
                        console.log(err)
                        break;
                    case 500:
                        console.log(err)
                        break;
                }


                $('#preloader').hide();
                $('#status').hide();
            }
        });
    });
</script>

@endpush