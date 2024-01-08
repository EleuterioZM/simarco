@extends('adminlte::page')

@section('title', 'Editar Médico')

@section('content_header')
    <h1>Editar Médico</h1>
@stop

@section('content')
    <!-- general form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados do Médico</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="{{ route('medicos.update', ['id' => $medico->id]) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-body">
                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <input type="text" class="form-control" id="nome" name='nome' value="{{ $medico->nome }}">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="especialidade_id">Especialidade</label>
                        <select class="form-control" id="especialidade_id" name="especialidade_id">
                            <option value="">Selecione uma Especialidade</option>
                            @foreach($especialidades as $especialidade)
                                <option value="{{ $especialidade->id }}" {{ $medico->especialidade_id == $especialidade->id ? 'selected' : '' }}>
                                    {{ $especialidade->descricao }}
                                </option>
                            @endforeach
                        </select>
                    </div> 
                    
                    <div class="form-group col-md-4">
                        <label for="numero_identificacao">Número de Identificação</label>
                        <input type="text" class="form-control" id="numero_identificacao" name='numero_identificacao' value="{{ $medico->numero_identificacao }}">
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label for="disponibilidade">Disponibilidade</label>
                        <select class="form-control" id="disponibilidade" name="disponibilidade">
                            <option value="">Selecione a Disponibilidade</option>
                            @foreach ($disponibilidades as $value)
                                <option value="{{ $value }}" {{ $medico->disponibilidade == $value ? 'selected' : '' }}>
                                    {{ ucfirst($value) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="genero">Gênero</label>
                        <select class="form-control" id="genero" name="genero">
                            @foreach($generos as $genero)
                                <option value="{{ $genero }}" {{ $medico->genero == $genero ? 'selected' : '' }}>
                                    {{ ucfirst($genero) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                </div>
            </div>
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value='Atualizar'>
                <a href="{{ url('/medicoIndex') }}" type="button" class="btn btn-warning">Cancelar</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
