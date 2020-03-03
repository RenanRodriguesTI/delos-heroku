<div class="hidden-xs" style="overflow-x: scroll">
    <table class="table table-bordered table-hover table-responsive">
        <thead>
        <tr>
            <th>Id</th>
            <th>@lang('headers.group')</th>
            <th>@lang('headers.user')</th>
            <th>@lang('headers.type')</th>
            <th>@lang('headers.id-changed')</th>
            <th>@lang('headers.entity')</th>
            <th>@lang('headers.date')</th>
            <th>@lang('headers.action')</th>
        </tr>
        </thead>
        
        <tbody> 
            @foreach($audits as $key => $audit)
                <tr>
                    <td class="text-center">{{$audit->id}}</td>
                    <td>{{$audit->groupCompany->name}}</td>
                    <td>{{$audit->user->name }}</td>
                    <td class="text-center">{{$audit->event}}</td>
                    <td class="text-center">{{$audit->auditable_id}}</td>
                    <td>{{$audit->auditable_type}}</td>
                    <td class="text-center">{{$audit->created_at->format('d/m/Y')}}</td>
                    <td class="text-center">
                        <a href="{{route('audits.show', ['id' => $audit->id])}}" id="btn-show-audit" class="btn btn-default dropdown-toggle btn-sm bold">
                            <span class="glyphicon glyphicon-eye-open"></span>
                            @lang('buttons.view')
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>