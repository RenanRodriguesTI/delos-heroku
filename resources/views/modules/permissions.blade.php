@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Permissões do Módulo: {{$module->name}}</h3>
            </div>
            <div class="panel-body" style="padding: 16px 24px 0 24px;">
                {!! Form::open(['method' => 'post', 'route' => ['modules.addPermission', 'id' => $module->id], 'class' => 'form-inline']) !!}
                <a href="{{url()->previous() == url()->current() ? route('modules.index') : url()->previous()}}"
                   class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Voltar</a>

                <div class="hidden-sm hidden-md hidden-lg">
                    <br>
                </div>

                {!! Form::select('permission_id[]', $permissions, null, ['title' => 'Selecione as permissões', 'class' => 'selectpicker', 'required' => true, 'multiple' => true, 'data-live-search' => 'true', 'data-actions-box' => "true"]) !!}

                <div class="hidden-sm hidden-md hidden-lg">
                    <br>
                </div>

                <button type="submit" class="btn btn-dct"><span class="glyphicon glyphicon-plus"
                                                                aria-hidden="true"></span> Adicionar Permissão
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
                        <th>Slug</th>
                        <th>Ação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($module->permissions as $permission)
                        <tr>
                            <td>{{$permission->name}}</td>
                            <td>{{$permission->slug}}</td>
                            <td>
                                <a href="{{route('modules.removePermission', ['id' => $module->id, 'permission' => $permission->id])}}"
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