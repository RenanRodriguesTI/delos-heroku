@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">@lang('titles.financial-ratings')</h3>
            </div>
            @include('messages')
            @can('create-financial-rating')
                <div class="panel-body">
                    <a href="{{route('financialRatings.create')}}" class="btn btn-dct">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        @lang('buttons.new-financial-rating')
                    </a>
                </div>
            @endcan
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-details">
                        <thead>
                            <tr>
                                <th>@lang('headers.description')</th>
                                <th>Code</th>
                                <th>@lang('headers.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($financialRatings as $financialRating)
                            <tr>
                                <td>{{$financialRating->description}}</td>
                                <td>{{$financialRating->cod}}</td>
                                <td class="has-btn-group">
                                @can('update-financial-rating')
                                        @if($financialRating->cod !== '03' && $financialRating->cod !== '02')
                                            <a href="{{route('financialRatings.edit', ['id' => $financialRating->id])}}"
                                               class="btn btn-dct btn-sm"><span class="glyphicon glyphicon-edit"></span>
                                                @lang('buttons.edit')
                                            </a>
                                        @endif
                                    @endcan
                                    @can('destroy-financial-rating')
                                        @if($financialRating->cod !== '03' && $financialRating->cod !== '02')
                                            <a id="{{route('financialRatings.destroy', ['id' => $financialRating->id])}}"
                                               class="btn btn-danger btn-sm delete" onclick="getModalDelete(this)"><span
                                                        class="glyphicon glyphicon-trash"></span>
                                                @lang('buttons.remove')
                                            </a>
                                        @endif
                                    @endcan
                                    @if($financialRating->cod == '03' || $financialRating->cod == '02')
                                        <span title="Não é possível remover ou editar uma Classificação Financeira padrão"
                                              class="glyphicon glyphicon-question-sign black-tooltip"
                                              aria-hidden="true"
                                              data-toggle="tooltip" data-placement="top"></span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    {!! $financialRatings->render() !!}
                </div>
            </div>

        </div>
    </div>
@endsection