<div class="hidden-xs hidden-sm">
    <div class="row">
        <div class="table-responsive col-md-10 nopadding" style="padding-left: 10px !important;">
            <table class="table table-bordered table-striped" id="projects-table">
                <thead>
                    <tr>
                        <th style="min-width: 330px;">@lang('headers.description')</th>
                        <th>@lang('headers.owner')</th>
                        <th>@lang('headers.start')</th>
                        <th style="min-width: 130px">@lang('headers.finish')</th>
                        <th>@lang('headers.last-activity')</th>
                        <th style="min-width: 224px;">@lang('headers.hours')</th>
                        <th>@lang('headers.proposal-number')</th>
                        @can('see-proposal-value')
                            <th>@lang('headers.proposal-value')</th>
                        @endcan
                        <th>Despesas Orçadas</th>
                    </tr>
                </thead>

                <tbody>

                @foreach($projects as $project)

                    <tr>
                        <td>{{$project->full_description}}</td>
                        <td>{{$project->owner->name}}</td>
                        <td>{{$project->start->format('d/m/Y')}}</td>

                        @if(!$project->extension)
                            @if($project->finish->isPast())
                                <td class="text-danger bold">{{$project->finish->format('d/m/Y')}} &nbsp;&nbsp;<span style="background-color: #e51c23;color: rgba(0,0,0,0);">&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                            @else
                                <td>{{$project->finish->format('d/m/Y')}}</td>
                            @endif

                            @else
                                @if($project->extension->isPast())
                                    <td class="text-danger bold">{{$project->extension->format('d/m/Y')}} &nbsp;&nbsp;<span style="background-color: #e51c23;color: rgba(0,0,0,0);">&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                                    @else
                                    <td>{{$project->extension->format('d/m/Y')}}</td>
                                @endif
                        @endif
                        <td>{{$project->last_activity ? $project->last_activity->format('d/m/Y') : null}}</td>
                        <td>
                            <div class="col-md-12">
                                <div class="row">
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
                                                <span id="id-{{str_replace(" ","-", $project->compiled_cod)}}">{{(int)$project->getHoursPercentage()}}
                                                    %</span>
                                            </td>
                                        </tr>
                                    </table>
                                    <br>
                                    <div class="progress" style="height: 10px;">
                                        <div id="progress-bar-{{str_replace(" ","-", $project->compiled_cod)}}"
                                             class="progress-bar progress-bar-success progress-bar-striped active"
                                             role="progressbar" aria-valuenow="{{(int)$project->getHoursPercentage()}}"
                                             aria-valuemin="0" aria-valuemax="100"
                                             style="width: {{(int)$project->getHoursPercentage()}}%">
                                            <span class="sr-only">60% Complete</span>
                                        </div>
                                    </div>

                                    <script>
                                        var text = document.getElementById('id-{{str_replace(" ","-", $project->compiled_cod)}}');
                                        var value = document.getElementById('progress-bar-{{str_replace(' ','-', $project->compiled_cod)}}').getAttribute('aria-valuenow');
                                        if (value < 70) {
                                            document.getElementById('progress-bar-{{str_replace(' ','-', $project->compiled_cod)}}').className += " progress-bar-sucess";
                                        } else if (value < 90) {
                                            document.getElementById('progress-bar-{{str_replace(' ','-', $project->compiled_cod)}}').className += " progress-bar-warning";
                                            text.className += " dct-yellow";
                                        } else {
                                            document.getElementById('progress-bar-{{str_replace(' ','-', $project->compiled_cod)}}').className += " progress-bar-danger";
                                            text.className += " dct-red";
                                        }
                                    </script>

                                </div>
                            </div>
                        </td>
                        <td>{{$project->proposal_number}}</td>
                        @can('see-proposal-value')
                            <td>{{number_format($project->proposal_value, 2, ',', '.')}}</td>
                        @endcan
                        <td>R$ {{number_format($project->extra_expenses,2,',','.')}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-2 nopadding">
            <table class="table table-bordered table-striped table-projects-options" id="projects-table-actions">
                <thead>
                <tr>
                    <th class="text-center">@lang('headers.action')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle btn-sm bold"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="glyphicon glyphicon-cog dct-color" aria-hidden="true"></span>
                                    @lang('buttons.options') <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right">

                                    <li class="divider"></li>

                                    @can('show-project')
                                        <li>
                                            <a href="{{route('projects.show', ['id' => $project->id])}}">
                                                                    <span class="glyphicon glyphicon-list-alt"
                                                                          aria-hidden="true"></span>
                                                @lang('buttons.details')
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                    @endcan

                                    @if (Auth::user()->can('proposal-values-description', $project))
                                            <li>
                                                <a href="{{route('projects.descriptionValues.index', ['id' => $project->id])}}">
                                                                        <span class="glyphicon glyphicon-th-list"
                                                                            aria-hidden="true"></span>
                                                    @lang('buttons.description-values')
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                        @endif

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

                                        @can('manage-project', $project) 

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

                                            <li class="divider"></li>
                                        @endcan
                                    @endif

                                    @if($project->deleted_at)
                                        @can('restore-project')
                                            <li style="cursor: pointer">
                                                <a href="{{route('projects.restore', ['id' => $project->id])}}">
                                                    <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>
                                                    @lang('buttons.restore')
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                        @endcan
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
</div>