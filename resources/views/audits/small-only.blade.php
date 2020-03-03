<div class="hidden-md hidden-sm hidden-lg">
    @foreach($audits as $index => $audit)
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="panel-title" style="font-size: 1.2em">
                        <a data-toggle="collapse" href="#collapse-{{$index}}">
                            <span><span class="bold">@lang('headers.id')</span>: {{$audit->event}}</span>
                            <br>
                            <span style="font-size: .8em">{{$audit['group_name']}}</span>
                        </a>
                    </p>
                </div>
                <div id="collapse-{{$index}}" class="panel-collapse collapse">
                    <ul class="list-group">
                        <li class="list-group-item"><span class="bold">Id: </span>{{$audit->id}}</li>
                        <li class="list-group-item"><span class="bold">@lang('headers.group'): </span>{{$audit->groupCompany->name}}</li>
                        <li class="list-group-item"><span class="bold">@lang('headers.user'): </span>{{$audit->user->name}}</li>
                        <li class="list-group-item"><span class="bold">@lang('headers.type'): </span>{{$audit->event}}</li>
                        <li class="list-group-item"><span class="bold">@lang('headers.id-changed'): </span>{{$audit->auditable_id}}</li>
                        <li class="list-group-item"><span class="bold">@lang('headers.entity'): </span>{{$audit->auditable_type}}</li>
                        <li class="list-group-item"><span class="bold">@lang('headers.date'): </span>{{$audit->created_at->format('d/m/Y')}}</li>
                        <li class="list-group-item">
                            <a href="{{route('audits.show', ['id' => $audit->id])}}" id="btn-show-audit" class="btn btn-default dropdown-toggle btn-sm bold">
                                <span class="glyphicon glyphicon-eye-open"></span>
                                @lang('buttons.view')
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
</div>