@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="panel panel-dct">
            <div class="panel-heading">
                <h3 class="panel-title bold">Criar Fornecedor</h3>
            </div>
            {!! Form::open(['route' => 'providers.create', 'id' => 'form-providers','method'=>'post']) !!}
            <div class="panel-body">
                @include('providers.form')
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    <a href="{{url()->previous() == url()->current() ? route('providers.index'): url()->previous()}}"
                       class="btn btn-default">
                        <span class="glyphicon glyphicon-arrow-left"></span>
                        Voltar
                    </a>
                    <button type="submit" class="btn btn-dct">
                        <span class="glyphicon glyphicon-floppy-disk"></span>
                        Salvar
                    </button>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection

@push('scripts')
    <script>
    </script>
@endpush