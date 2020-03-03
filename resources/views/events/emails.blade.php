@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Emails a serem enviados para o
                    evento: {{trans('events.' . $event->name)}}</h3>
            </div>
            <div class="panel-body">

                {!! Form::open(['route' => ['events.addEmails', 'id' => $event->id], 'class' => 'form-inline']) !!}

                <a href="{{url()->previous() == url()->current() ? route('events.index') : url()->previous()}}"
                   class="btn btn-default">
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    Voltar</a>

                <div class="hidden-lg hidden-sm hidden-md">
                    <br>
                </div>

                {!! Form::select('users[]', $users, null, [
                    'title' => 'Selecione um usuário',
                    'class' => 'selectpicker',
                    'multiple' => true,
                    'data-live-search' => 'true',
                    'required' => true]) !!}

                <div class="hidden-lg hidden-sm hidden-md">
                    <br>
                </div>

                <button type="submit" class="btn btn-dct">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Adicionar Membro
                </button>

                <span title="@lang('tips.events-colaborator-input')"
                      class="glyphicon glyphicon-question-sign black-tooltip" aria-hidden="true"
                      data-toggle="tooltip" data-placement="top"></span>

                {!! Form::close() !!}

                @if ($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{$error}}
                        </div>
                        <br>
                    @endforeach
                @else
                    <br>
                @endif

                <div class="row">
                    <div class="col-xs-12">
                        <div class="row">
                            @foreach($event->users as $user)
                                <div class="col-md-4 col-sm-6 col-xs-12 profile_details">
                                    <div class="well profile_view col-xs-12">
                                        <div class="col-sm-12">
                                            <div class="left col-xs-7">
                                                <h2 style="color: #565656;">{{$user->name}}</h2>
                                                <br>
                                                <ul class="list-unstyled">
                                                    <li class="email">
                                                        <p>
                                                            <strong>Email:</strong><br> {{$user->email}}
                                                        </p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="right col-xs-5 text-center pull-right">
                                                @if($user->avatar)
                                                    <img src="{{$user->avatar}}" alt=""
                                                         class="img-circle img-responsive" style="transform: translateY(-16px);">
                                                @else
                                                    <div style="font-size: 66px;background: #73879C;color: #fff;border-radius: 50%;width: 90px;height: 90px;transform: translateY(-16px);">
                                                        <i style="font-style: normal;text-align: center;">{{substr($user->name,0,1)}}</i>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-12 bottom">
                                            <button type="button" class="btn btn-danger btn-xs delete"
                                                    id="{{route('events.removeEmails', ['id' => $event->id, 'userId' => $user->id])}}"
                                                    style="margin-left: 21px;">
                                                <i class="fa fa-remove"> </i> Remover
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection