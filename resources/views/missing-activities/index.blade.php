@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-8 col-xs-12 col-sm-8">
                        <h3 class="panel-title bold">@lang('titles.missing-activities')</h3>
                    </div>
                    <div class="col-md-4 col-sm-4 text-right">
                        <span title="@lang('tips.whats-missing-activity')"
                              class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true"
                              data-toggle="tooltip" data-placement="left"></span>
                    </div>
                </div>
            </div>

            <div class="panel-body" style="padding: 16px 24px 0 24px;">
                <form>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                @if(count($users))
                                    {!! Form::select('users[]', $users, Request::get('users'), [
                                    'class' => 'selectpicker form-control',
                                    'data-live-search' => 'true',
                                    'data-actions-box' => 'true',
                                    'title' => 'Selecione o(s) colaborador(es)',
                                    'multiple'
                                    ])!!}
                                @endif
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-lg-3">
                            <div class="form-group">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-dct">
                                        Pesquisar
                                    </button>
                                    <button type="button" class="btn btn-dct dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="report-xlsx"><span
                                                        class="glyphicon glyphicon-cloud-download"></span>
                                                @lang('buttons.export-excel')
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-details">
                        <thead>
                        <tr>
                            <th>@lang('headers.date')</th>
                            <th>@lang('headers.collaborator')</th>
                            <th style="min-width: 120px;">@lang('headers.email')</th>
                            <th>@lang('headers.hours')</th>
                            <th>@lang('headers.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($missingActivities as $missingActivity)
                            <tr>
                                <td>{{$missingActivity->date->format('d/m/Y')}}</td>
                                <td>{{$missingActivity->user->name}}</td>
                                <td>{{$missingActivity->user->email}}</td>
                                <td>{{$missingActivity->hours}}</td>
                                <td class="text-center has-btn-group">
                                    <a class="btn btn-default"
                                       href="activities/create?date={{$missingActivity->date->format('d/m/Y')}}&hours={{$missingActivity->hours}}">
                                        @lang('buttons.post-hours')
                                    </a>
                                </td>
                                <td class="table-details-title">
                                    {{$missingActivity->user->name}} no dia {{$missingActivity->date->format('d/m/Y')}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    {!! $missingActivities->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection