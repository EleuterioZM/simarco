@extends('adminlte::page')

@section('title', 'Editar Prescrição Médica')

@section('content_header')
    <h1>Editar Prescrição Médica</h1>
@stop

@section('content')
    <!-- General form elements -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Dados da Prescrição Médica</h3>
        </div>
        <!-- /.card-header -->
        <!-- Form start -->
        <form action="{{ route('prescricoes.update', ['id' => $prescricao->id]) }}" method="POST" enctype="multipart/form-data">
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
                <div class="row">
                    <div class="form-group col-md-6">
                    <label for="data_prescricao">Data da Prescrição</label>
                    <input type="date" class="form-control" id="data_prescricao" name='data_prescricao' value="{{ $prescricao->data_prescricao }}" required>
                  </div>
                
                 <div class="form-group col-md-6">
                    <label for="consulta_id">Paciente relacionado à Consulta</label>
                    <select class="form-control" id="consulta_id" name="consulta_id">
                        <option value="">Selecione uma consulta</option>
                        @foreach ($consultas as $consulta)
                            @if ($consulta->paciente)
                                <option value="{{ $consulta->id }}" {{ $prescricao->consulta_id == $consulta->id ? 'selected' : '' }}>
                                    {{ $consulta->data }} - {{ $consulta->paciente->nome }}
                                </option>
                            @endif
                        @endforeach
                      </select>
                 </div>
             </div>
                
             <div class="form-group">
                <label for="observacoes">Observações</label>
                <textarea class="form-control custom-textarea" id="observacoes" name='observacoes' placeholder="Digite as observações...">{{ $prescricao->observacoes }}</textarea>
            </div>
            </div>
        
            <div class="card-footer">
                <input type="submit" class="btn btn-primary" value='Atualizar'>
                <a href="{{ url('/prescricaoIndex') }}" type="button" class="btn btn-warning">Cancelar</a>
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
