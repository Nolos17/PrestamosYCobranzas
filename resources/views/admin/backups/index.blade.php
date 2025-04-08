@extends('adminlte::page')

@section('title', 'Backups')

@section('content_header')
    <h1>Gestión de Backups</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Backups</h3>
            <div class="card-tools">
                <a href="{{ route('admin.backups.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Crear Nuevo
                </a>
            </div>
        </div>
        <div class="card-body">
            @if (session('mensaje'))
                <div class="alert alert-{{ session('icono') }} alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session('mensaje') }}
                </div>
            @endif

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($backups as $backup)
                        <tr>
                            <td>{{ $backup['nombre'] }}</td>
                            <td>{{ $backup['fecha'] }}</td>
                            <td>
                                <a href="{{ route('admin.backups.download', $backup['nombre']) }}"
                                    class="btn btn-success btn-sm" title="Descargar Backup">
                                    <i class="fas fa-download"></i> Descargar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No hay backups disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        // Opcional: Agregar animaciones o efectos si lo deseas
    </script>
@stop
