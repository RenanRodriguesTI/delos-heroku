<div class='panel-body'>
    <table class='table table-bordered'>
        <thread>
            <tr>
                <th>Valor</th>
                <th>Inicio</th>
                <th>Finalização</th>
                <th>
            </tr>
        </thread>
        <tbody>
            @foreach($office->officeHistory as $key => $history)
                <tr>
                    <td> R$ {{$history->value}}</td>
                    <td>{{$history->start->format('d/m/Y')}}</td>
                    <td>{{$history->finish ? $history->finish->format('d/m/Y') :'Não Especificado'}}</td>
                    <td  class="has-btn-group">
                                <div class="btn-group {{$key<=3 ? 'dropdown':'dropup'}}">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                    id="btn-options-users-{{$key}}">
                                                <span class="glyphicon glyphicon-cog"></span>
                                                @lang('buttons.options') &nbsp;<span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li class="divider"></li>
                                                <li>
                                                    <a href='#' id='{{route('office.deleteHistory',['id'=>$history->id,'idoffice'=>$history->office_id])}}' class='delete'><span class="glyphicon glyphicon-trash"></span>&nbsp; @lang('buttons.remove')</a>
                                                </li>
                                                <li class="divider"></li>
                                            </ul>

                                </div>
                    </td>
                </tr>
            @endforeach
        
        </tbody>
    </table>
</div>

@include('offices.history.finish')
@include('offices.history.create')