<div class="hidden-md hidden-lg">
    @foreach($projects as $index => $project)
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p class="panel-title" style="font-size: 1.2em">
                        <a data-toggle="collapse" href="#collapse-{{$index}}">
                            <span class="bold">{{$project->compiled_cod}}</span>
                            <br>
                            <span style="font-size: .8em">{{$project->description}}</span>
                        </a>
                    </p>
                </div>
                <div id="collapse-{{$index}}" class="panel-collapse collapse">
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item"><span class="bold">@lang('headers.owner')
                                    : </span>{{$project->owner->name}}</li>
                            <li class="list-group-item"><span class="bold">@lang('headers.start')
                                    : </span>{{$project->start->format('d/m/Y')}}</li>
                            <li class="list-group-item"><span class="bold">@lang('headers.finish'): </span><span
                                        class="{{$project->finish->isPast() ? 'text-danger bold' : ''}}">{{$project->finish->format('d/m/Y')}}</span>
                            </li>
                            <li class="list-group-item"><span class="bold">@lang('headers.last-activity')
                                    : </span>{{$project->last_activity ? $project->last_activity->format('d/m/Y') : null}}
                            </li>
                            <li class="list-group-item"><span class="bold">@lang('headers.hours'): </span>
                                <table class="table-hours">
                                    <tr>
                                        <td>
                                            <span class="bold">@lang('headers.hours-spent')</span>
                                            <br>
                                            {{$project->getSpentHours()}}
                                        </td>
                                        <td>
                                            <span class="bold">@lang('headers.budget')</span>
                                            <br>
                                            {{$project->budget}}
                                        </td>
                                        <td>
                                            <span class="bold">@lang('headers.percentage')</span>
                                            <br>
                                            <span id="id-mobile-{{str_replace(" ","-", $project->compiled_cod)}}">{{(int)$project->getHoursPercentage()}}
                                                %</span>
                                        </td>
                                    </tr>
                                </table>
                                <br>
                                <div class="progress" style="height: 10px;">
                                    <div id="progress-bar-mobile-{{str_replace(" ","-", $project->compiled_cod)}}"
                                         class="progress-bar progress-bar-success progress-bar-striped active"
                                         role="progressbar" aria-valuenow="{{(int)$project->getHoursPercentage()}}"
                                         aria-valuemin="0" aria-valuemax="100"
                                         style="width: {{(int)$project->getHoursPercentage()}}%">
                                        <span class="sr-only">60% Complete</span>
                                    </div>
                                </div>

                                <script>
                                    var text = document.getElementById('id-mobile-{{str_replace(" ","-", $project->compiled_cod)}}');

                                    var value = document.getElementById('progress-bar-mobile-{{str_replace(' ','-', $project->compiled_cod)}}').getAttribute('aria-valuenow');

                                    if (value < 70) {
                                        document.getElementById('progress-bar-mobile-{{str_replace(' ','-', $project->compiled_cod)}}').className += " progress-bar-sucess";
                                    } else if (value < 90) {
                                        document.getElementById('progress-bar-mobile-{{str_replace(' ','-', $project->compiled_cod)}}').className += " progress-bar-warning";
                                        text.className += " dct-yellow";
                                    } else {
                                        document.getElementById('progress-bar-mobile-{{str_replace(' ','-', $project->compiled_cod)}}').className += " progress-bar-danger";
                                        text.className += " dct-red";
                                    }
                                </script>
                            </li>
                            @can('see-proposal-value')
                                <li class="list-group-item"><span class="bold">@lang('headers.proposal-value')
                                        : </span>{{$project->proposal_number}}</li>
                            @endcan
                            <li class="list-group-item"><span class="bold">@lang('headers.action'): </span>
                                <div class="btn-group dropup">
                                    <button type="button" class="btn btn-default dropdown-toggle btn-sm bold"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="glyphicon glyphicon-cog dct-color" aria-hidden="true"></span>
                                        @lang('buttons.options') <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right">

                                        @can('show-project')
                                            <li class="divider"></li>
                                            <li>
                                                <a href="{{route('projects.show', ['id' => $project->id])}}">
                                                                    <span class="glyphicon glyphicon-list-alt"
                                                                          aria-hidden="true"></span>
                                                    @lang('buttons.details')
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                        @endcan

                                        @can('manage-project', $project)
                                            <li>
                                                <a href="{{route('projects.descriptionValues.index', ['id' => $project->id])}}">
                                                                        <span class="glyphicon glyphicon-th-list"
                                                                            aria-hidden="true"></span>
                                                    @lang('buttons.description-values')
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                        @endcan

                                        @if(!$project->deleted_at)
                                            @can('update-project')
                                                <li>
                                                    <a href="{{route('projects.edit', ['id' => $project->id])}}">
                                                                        <span class="glyphicon glyphicon-edit"
                                                                              aria-hidden="true"></span>
                                                        @lang('buttons.edit')
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                            @endcan
                                        @endif

                                        @if(!$project->deleted_at)
                                            @can('manage-project', $project)
                                            <li>
                                                <a href="{{route('projects.descriptionValues.index', ['id' => $project->id])}}">
                                                                        <span class="glyphicon glyphicon-th-list"
                                                                            aria-hidden="true"></span>
                                                    @lang('buttons.description-values')
                                                </a>
                                            </li>
                                            <li class="divider"></li>    

                                            <li style="cursor: pointer">
                                                    <a class="distroy"
                                                       id="{{route('projects.destroy', ['id' => $project->id])}}">
                                                                        <span class="glyphicon glyphicon-check"
                                                                              aria-hidden="true"></span>
                                                        @lang('buttons.finalize-project')
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="{{route('projects.membersToAdd', ['id' => $project->id])}}">
                                                                        <span class="glyphicon glyphicon-user"
                                                                              aria-hidden="true"></span>
                                                        @lang('buttons.members')
                                                    </a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="{{route('projects.tasksToAdd', ['id' => $project->id])}}">
                                                                        <span class="glyphicon glyphicon-tasks"
                                                                              aria-hidden="true"></span>
                                                        @lang('buttons.tasks')
                                                    </a>
                                                </li>
                                            @endcan
                                        @endcan

                                        @if($project->deleted_at)
                                            @can('restore-project')
                                                <li style="cursor: pointer">
                                                    <a href="{{route('projects.restore', ['id' => $project->id])}}">
                                                        <span class="glyphicon glyphicon-transfer"
                                                              aria-hidden="true"></span>
                                                        @lang('buttons.restore')
                                                    </a>
                                                </li>
                                            @endcan
                                        @endif
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>