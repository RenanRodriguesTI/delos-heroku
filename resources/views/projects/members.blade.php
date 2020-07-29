@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Membros do Projeto: {{$project->full_description}}</h3>
            </div>
            <div class="panel-body">
                {!! Form::open(['route' => ['projects.addMember', 'id' => $project->id], 'class' => 'form-inline']) !!}

                <a href="{{url()->previous() == url()->current() ? route('projects.index') . '?deleted_at=whereNull' : url()->previous()}}"
                   class="btn btn-default">
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    Voltar</a>

                <div class="hidden-lg hidden-md hidden-sm">
                    <br>
                </div>

                @can('manage-project', $project)
                    {!! Form::select('members[]', $users, null, [
                        'title' => 'Selecione um membro',
                        'class' => 'selectpicker member',
                        'multiple' => true,
                        'data-live-search' => 'true',
                        'required' => true,
                        ]) !!}

                    <div class="hidden-lg hidden-md hidden-sm">
                        <br>
                    </div>

                    <button type="submit" class="btn btn-dct">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        Adicionar Membro
                    </button>

                @endcan
                {!! Form::close() !!}

                @if ($errors->any())

                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{$error}}
                        </div>
                    @endforeach
                @endif

                <br>
                
                <div class="row">
                    <div class="col-xs-12">
                        <div class="row">
                            @foreach($members as $user)
                                <div class="col-md-4 col-sm-6 col-xs-12 profile_details">
                                    <div class="well {{$project->owner_id == $user->id ? 'owner':''}} profile_view col-xs-12">
                                        <div class="left col-xs-7">
                                            @if($project->owner_id == $user->id)
                                                <h2>Lider</h2>
                                            @endif
                                            <h2>{{$user->name}}</h2>
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
                                                <div style="font-size: 66px;background: #73879C;color: #fff;border-radius: 50%;width: 80px;height: 80px;transform: translateY(-16px);">
                                                    <i style="font-style: normal;text-align: center;position: relative;top: -9px;">{{substr($user->name,0,1)}}</i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-xs-12 bottom">
                                            @can('manage-project', $project)

                                                <button type="button" class="btn btn-danger btn-xs delete"
                                                        id="{{route('projects.removeMember', ['id' => $project->id, 'member' => $user->id])}}"
                                                        style="margin-left: 21px;">
                                                    <i class="fa fa-remove"> </i> Remover
                                                </button>

                                                @if(strpos($user->name,'PS -')===0 && $user->pivot->hours =="1")
                                                    <button type="button" id='{{route('projects.changehoursps', ['id' => $project->id, 'member' => $user->id])}}' data-hours="{{ ($user->pivot->hours !=0)?'1':'0' }}" class="btn btn-success btn-xs hours">
                                                        <i class="fa fa-check"></i>  Com horas
                                                    </button>
                                                @endif

                                            @if(strpos($user->name,'PS -')===0 && $user->pivot->hours =="0")
                                                <button type="button" id='{{route('projects.changehoursps', ['id' => $project->id, 'member' => $user->id])}}' data-hours="{{ ($user->pivot->hours !=0)?'1':'0' }}" class="btn btn-danger btn-xs hours">
                                                    <i class="fa fa-remove"> </i> Sem horas
                                                </button>
                                            @endif

                                            @endcan
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
