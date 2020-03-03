{!! Form::open(['route' => $route, 'method' => 'get']) !!}

<div class="row">
    <div class="col-md-3 col-sm-12 col-xs-12">
        <div class="form-group">
            <select name="collaborators[]" class="selectpicker form-control" title="Selecione um colaborador" multiple
                    data-size="9" data-live-search="true">

                @foreach($collaborators as $key => $collaborator)
                    @if(in_array($collaborator->name, Request::get('collaborators') ?? []))
                        <option value="{{$collaborator->name}}" selected>{{$collaborator->name}}</option>
                    @else
                        <option value="{{$collaborator->name}}">{{$collaborator->name}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-3 col-sm-12 col-xs-12">
        <div class="form-group">
            <select name="months[]" class="selectpicker form-control" title="Selecione um mês" multiple
                    data-size="9" data-live-search="true">
                @foreach($months as $key => $month)
                    @if(in_array($key, Request::get('months') ?? []))
                        <option value="{{$key}}" selected>{{$month}}</option>
                    @else
                        <option value="{{$key}}">{{$month}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-3 col-sm-12 col-xs-12">
        <div class="form-group">
            <select name="years[]" class="selectpicker form-control" title="Selecione um ano" multiple
                    data-size="9" data-live-search="true">
                @for($i = 0; $i < (date('Y')-2016+1); $i++)
                    @if(in_array((date('Y')-$i), Request::get('years') ?? []))
                        <option value="{{date('Y')-$i}}" selected>{{date('Y')-$i}}</option>
                    @else
                        <option value="{{date('Y')-$i}}">{{date('Y')-$i}}</option>
                    @endif
                @endfor
            </select>
        </div>
    </div>

    <div class="col-md-3 col-sm-12 col-xs-12">
        <div class="form-group">
            <div class="btn-group">
                {!! Form::submit('Pesquisar', ['class' => 'btn btn-dct']) !!}
                <button type="button" class="btn btn-dct dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="report-xlsx"><span class="glyphicon glyphicon-cloud-download"></span>
                            @lang('buttons.export-excel')
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}