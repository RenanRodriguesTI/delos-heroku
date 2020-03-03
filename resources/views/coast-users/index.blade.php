@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h3 class="panel-title bold">@lang('titles.coast-users')</h3>
                    </div>
                    <div class="col-md-4 col-sm-4 hidden-xs text-right">
                        <span title="@lang('tips.whats-coast-users')"
                              class="glyphicon glyphicon-question-sign black-tooltip"
                              aria-hidden="true" data-toggle="tooltip" data-placement="left"></span>
                    </div>
                </div>
            </div>
            @include('messages')

            <div class="panel-body row" style="padding: 16px 24px 0 24px;">
                <div class="col-md-3 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="year">Selecione o ano:</label>
                        <select name="year" id="year" class="selectpicker form-control" title="Selecione um ano"
                                data-size="9">
                            @for($i = 0; $i < (date('Y')-2016+1); $i++)
                                <option value="{{date('Y')-$i}}" selected>{{date('Y')-$i}}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="col-lg-3 col-lg-offset-6 col-md-5 col-md-offset-4 col-sm-12 col-xs-12 pull-right">
                    <div class="form-group">
                        <label for="year" style="opacity: 0;">Selecione o ano:</label>
                        <a href="{{route('coastUsers.copyLastValues')}}" class="btn btn-dct btn-block">Copiar último mês</a>
                    </div>
                </div>
            </div>
            <div class="panel-body" id="coast-users-table">
                <ul class="nav nav-tabs" role="tablist" id="coast-users-tab">
                    <li role="presentation" class="{{!strcasecmp('january', date('F')) ? 'active' : ''}}">
                        <a href="#january" aria-controls="{{trans('titles.january')}}" role="tab"
                           data-toggle="pill">@lang('titles.january')</a>
                    </li>
                    <li role="presentation" class="{{!strcasecmp('february', date('F')) ? 'active' : ''}}">
                        <a href="#february" aria-controls="{{trans('titles.february')}}" role="tab"
                           data-toggle="pill">@lang('titles.february')</a>
                    </li>
                    <li role="presentation" class="{{!strcasecmp('march', date('F')) ? 'active' : ''}}">
                        <a href="#march" aria-controls="{{trans('titles.march')}}" role="tab"
                           data-toggle="pill">@lang('titles.march')</a>
                    </li>
                    <li role="presentation" class="{{!strcasecmp('april', date('F')) ? 'active' : ''}}">
                        <a href="#april" aria-controls="{{trans('titles.april')}}" role="tab"
                           data-toggle="pill">@lang('titles.april')</a>
                    </li>
                    <li role="presentation" class="{{!strcasecmp('may', date('F')) ? 'active' : ''}}">
                        <a href="#may" aria-controls="{{trans('titles.may')}}" role="tab"
                           data-toggle="pill">@lang('titles.may')</a>
                    </li>
                    <li role="presentation" class="{{!strcasecmp('june', date('F')) ? 'active' : ''}}">
                        <a href="#june" aria-controls="{{trans('titles.june')}}" role="tab"
                           data-toggle="pill">@lang('titles.june')</a>
                    </li>
                    <li role="presentation" class="{{!strcasecmp('july', date('F')) ? 'active' : ''}}">
                        <a href="#july" aria-controls="{{trans('titles.july')}}" role="tab"
                           data-toggle="pill">@lang('titles.july')</a>
                    </li>
                    <li role="presentation" class="{{!strcasecmp('august', date('F')) ? 'active' : ''}}">
                        <a href="#august" aria-controls="{{trans('titles.august')}}" role="tab"
                           data-toggle="pill">@lang('titles.august')</a>
                    </li>
                    <li role="presentation" class="{{!strcasecmp('september', date('F')) ? 'active' : ''}}">
                        <a href="#september" aria-controls="{{trans('titles.september')}}" role="tab"
                           data-toggle="pill">@lang('titles.september')</a>
                    </li>
                    <li role="presentation" class="{{!strcasecmp('october', date('F')) ? 'active' : ''}}">
                        <a href="#october" aria-controls="{{trans('titles.october')}}" role="tab"
                           data-toggle="pill">@lang('titles.october')</a>
                    </li>
                    <li role="presentation" class="{{!strcasecmp('november', date('F')) ? 'active' : ''}}">
                        <a href="#november" aria-controls="{{trans('titles.november')}}" role="tab"
                           data-toggle="pill">@lang('titles.november')</a>
                    </li>
                    <li role="presentation" class="{{!strcasecmp('december', date('F')) ? 'active' : ''}}">
                        <a href="#december" aria-controls="{{trans('titles.december')}}" role="tab"
                           data-toggle="pill">@lang('titles.december')</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel"
                         class="tab-pane animated fadeIn {{!strcasecmp('january', date('F')) ? 'active' : ''}}"
                         id="january">
                        @include('coast-users.table', [$users, 'month' => 'january'])
                    </div>
                    <div role="tabpanel"
                         class="tab-pane animated fadeIn {{!strcasecmp('february', date('F')) ? 'active' : ''}}"
                         id="february">
                        @include('coast-users.table', [$users, 'month' => 'february'])
                    </div>
                    <div role="tabpanel"
                         class="tab-pane animated fadeIn {{!strcasecmp('march', date('F')) ? 'active' : ''}}"
                         id="march">
                        @include('coast-users.table', [$users, 'month' => 'march'])
                    </div>
                    <div role="tabpanel"
                         class="tab-pane animated fadeIn {{!strcasecmp('april', date('F')) ? 'active' : ''}}"
                         id="april">
                        @include('coast-users.table', [$users, 'month' => 'april'])
                    </div>
                    <div role="tabpanel"
                         class="tab-pane animated fadeIn {{!strcasecmp('may', date('F')) ? 'active' : ''}}" id="may">
                        @include('coast-users.table', [$users, 'month' => 'may'])
                    </div>
                    <div role="tabpanel"
                         class="tab-pane animated fadeIn {{!strcasecmp('june', date('F')) ? 'active' : ''}}" id="june">
                        @include('coast-users.table', [$users, 'month' => 'june'])
                    </div>
                    <div role="tabpanel"
                         class="tab-pane animated fadeIn {{!strcasecmp('july', date('F')) ? 'active' : ''}}" id="july">
                        @include('coast-users.table', [$users, 'month' => 'july'])
                    </div>
                    <div role="tabpanel"
                         class="tab-pane animated fadeIn {{!strcasecmp('august', date('F')) ? 'active' : ''}}"
                         id="august">
                        @include('coast-users.table', [$users, 'month' => 'august'])
                    </div>
                    <div role="tabpanel"
                         class="tab-pane animated fadeIn {{!strcasecmp('september', date('F')) ? 'active' : ''}}"
                         id="september">
                        @include('coast-users.table', [$users, 'month' => 'september'])
                    </div>
                    <div role="tabpanel"
                         class="tab-pane animated fadeIn {{!strcasecmp('october', date('F')) ? 'active' : ''}}"
                         id="october">
                        @include('coast-users.table', [$users, 'month' => 'october'])
                    </div>
                    <div role="tabpanel"
                         class="tab-pane animated fadeIn {{!strcasecmp('november', date('F')) ? 'active' : ''}}"
                         id="november">
                        @include('coast-users.table', [$users, 'month' => 'november'])
                    </div>
                    <div role="tabpanel"
                         class="tab-pane animated fadeIn {{!strcasecmp('december', date('F')) ? 'active' : ''}}"
                         id="december">
                        @include('coast-users.table', [$users, 'month' => 'december'])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection