@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Módulos do plano: {{$plan->name}}</h3>
            </div>
            <div class="panel-body" style="padding: 16px 24px 0 24px;">
                {!! Form::open(['method' => 'post', 'route' => ['plans.addModules', 'id' => $plan->id], 'class' => 'form-inline']) !!}
                <a href="{{url()->previous() == url()->current() ? route('plans.index') : url()->previous()}}"
                   class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Voltar</a>

                <div class="hidden-lg hidden-md hidden-sm">
                    <br>
                </div>

                {!! Form::select('module_id[]', $modules, null, ['title' => 'Selecione os módulos', 'class' => 'selectpicker', 'required' => true, 'multiple' => true, 'data-live-search' => 'true', 'data-actions-box' => "true"]) !!}

                <div class="hidden-lg hidden-md hidden-sm">
                    <br>
                </div>

                <button type="submit" class="btn btn-dct"><span class="glyphicon glyphicon-plus"
                                                                aria-hidden="true"></span> Adicionar Módulo(s)
                </button>

                {!! Form::close() !!}
            </div>

            <div class="panel-body">
                @if ($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{$error}}
                        </div>
                    @endforeach
                @endif
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($plan->modules as $module)
                        <tr>
                            <td>{{$module->name}}</td>
                            <td class="has-btn-group">
                                <a href="{{route('plans.removeModule', ['id' => $plan->id, 'permission' => $module->id])}}"
                                   class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span>
                                    Remover</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection