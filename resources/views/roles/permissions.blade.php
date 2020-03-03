@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Permissões do Perfil: {{$role->name}}</h3>
            </div>
            <div class="panel-body" style="padding: 16px 24px 0 24px;">
                {!! Form::open(['method' => 'post', 'route' => ['roles.addPermission', 'id' => $role->id], 'class' => 'form-inline']) !!}
                <a href="{{url()->previous() == url()->current() ? route('roles.index') : url()->previous()}}"
                   class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Voltar</a>
                @can('add-permission-role')
                    {!! Form::select('permission_id[]', $permissions, null, ['title' => 'Selecione as permissões', 'class' => 'selectpicker', 'required' => true, 'multiple' => true, 'data-live-search' => 'true', 'data-actions-box' => "true"]) !!}
                    <button type="submit" class="btn btn-dct"><span class="glyphicon glyphicon-plus"
                                                                    aria-hidden="true"></span> Adicionar Permissão
                    </button>
                @endcan

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
                    @foreach($role->permissions as $permission)
                        <tr>
                            <td>{{$permission->name}}</td>
                            <td>{{$permission->slug}}</td>
                            <td>
                                @can('remove-permission-role')
                                    <a href="{{route('roles.removePermission', ['id' => $role->id, 'permission' => $permission->id])}}"
                                       class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span>
                                        Remover</a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection