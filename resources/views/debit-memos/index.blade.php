@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <h3 class="panel-title bold">@lang('titles.debitMemos')</h3>
                    </div>
                    <div class="col-md-4 col-sm-4 text-right">
                        <span title="@lang('tips.whats-debit-memos')"
                              class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true"
                              data-toggle="tooltip" data-placement="left"></span>
                    </div>
                </div>
            </div>
            @include('messages')
            @include('debit-memos.search')
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-details" id="debit-memo-table">
                        <thead>
                            <tr>
                                <th style="min-width: 90px;">@lang('headers.debit-memo-number')</th>
                                <th>@lang('headers.project')</th>
                                <th style="min-width: 100px">@lang('headers.status')</th>
                                <th style="min-width: 100px;">@lang('debitMemos.value-total')</th>
                                <th>@lang('headers.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($debitMemos as $key => $debitMemo)
                            <tr>
                                <td class="text-center">{{$debitMemo->code}}</td>
                                <td class="has-btn-group"><a href="{{route('projects.index')}}?search={{$debitMemo->project->compiled_cod}}">{{$debitMemo->project->full_description}}</a></td>
                                <td class="{{$debitMemo->status}} bold">@lang('debitMemos.index.status.' . $debitMemo->status)</td>
                                <td>R$ {{$debitMemo->value_total}}</td>
                                <td class="has-btn-group">
                                    @can('show-debit-memo')
                                        <a class="btn btn-default btn-sm"
                                           href="{{route('debitMemos.show', ['id' => $debitMemo->id])}}"
                                           id="btn-show-debit-memos-{{$key}}"><span
                                                    class="glyphicon glyphicon-list-alt"></span>
                                            @lang('buttons.details')
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    {!! $debitMemos->render() !!}
                </div>
            </div>

        </div>
    </div>
@endsection