@extends('layouts.admin')

@section('content_header')
<h1><b>Datos de Configuraciones</b></h1>
<hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Configuraciones registradas</h3>
                <div class="card-tools">
                    <a href="{{ url('/admin/configuraciones/create') }}" class="btn btn-primary">Crear Nuevo</a>

                </div>
            </div>
            <div class="card-body">
                <table id=example1 class="table">
                    <thead>
                        <tr>
                            <th style="text-align: center">Nro</th>
                            <th style="text-align: center">Nombre</th>
                            <th style="text-align: center">Descripción</th>
                            <th style="text-align: center">Teléfono</th>
                            <th style="text-align: center">Email</th>
                            <th style="text-align: center">Moneda</th>
                            <th style="text-align: center">Logo</th>
                            <th style="text-align: center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $contador=1;
                        @endphp
                        @foreach($configuraciones as $configuracion)
                        <tr>
                            <td style="text-align: center">{{ $contador++ }}</td>
                            <td>{{ $configuracion->nombre }}</td>
                            <td>{{ $configuracion->descripcion }}</td>
                            <td>{{ $configuracion->telefono }}</td>
                            <td>{{ $configuracion->email }}</td>
                            <td>{{ $configuracion->moneda }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $configuracion->logo) }}" width="100px" alt="LOGO">
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <!-- Botón de Ver -->
                                    <a href="{{ url('/admin/configuraciones/' . $configuracion->id) }}"
                                        class="btn btn-info btn-sm" style="border-radius: 4px 0px 0px 4px">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <!-- Botón de Editar -->
                                    <a href="{{ url('/admin/configuraciones/' . $configuracion->id . '/edit') }}"
                                        class="btn btn-success btn-sm" style="border-radius: 0px 0px 0px 0px">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    <!-- Formulario de eliminación -->
                                    <form action="{{ url('/admin/configuraciones/' . $configuracion->id) }}" method="post" id="miFormulario{{ $configuracion->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" style="border-radius: 0px 4px 4px 0px"
                                            onclick='preguntar("{{ $configuracion->id }}");'>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                    <script>
                                        function preguntar(id) {
                                            Swal.fire({
                                                title: '¿Desea eliminar este registro?',
                                                text: '',
                                                icon: 'question',
                                                showCancelButton: true,
                                                confirmButtonText: 'Eliminar',
                                                confirmButtonColor: '#d33',
                                                cancelButtonColor: '#27ae60',
                                                cancelButtonText: 'Cancelar'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    var form = document.getElementById('miFormulario' + id);
                                                    if (form) {
                                                        form.submit();
                                                    } else {
                                                        console.error("Formulario no encontrado para el ID: miFormulario" + id);
                                                    }
                                                }
                                            });
                                        }
                                    </script>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    /* Fondo transparente y sin borde en el contenedor */
    #example1_wrapper .dt-buttons {
        background-color: transparent;
        box-shadow: none;
        border: none;
        display: flex;
        /* Centrar los botones */
        justify-content: center;
        /* Centrar los botones */
        gap: 10px;
        /* Espaciado entre botones */
        margin-bottom: 15px;
        /* Separar botones de la tabla */
    }

    /* Estilo personalizado para los botones */
    #example1_wrapper .btn {
        color: #fff;
        /* Color del texto en blanco */
        border-radius: 4px;
        /* Bordes redondeados */
        padding: 5px 15px;
        /* Espaciado interno */
        font-size: 14px;
        /* Tamaño de fuente */
    }

    /* Colores por tipo de botón */
    .btn-danger {
        background-color: #dc3545;
        border: none;
    }

    .btn-success {
        background-color: #28a745;
        border: none;
    }

    .btn-info {
        background-color: #17a2b8;
        border: none;
    }

    .btn-warning {
        background-color: #ffc107;
        color: #212529;
        border: none;
    }

    .btn-default {
        background-color: #6e7176;
        color: #212529;
        border: none;
    }
</style>
@stop

@section('js')
<script>
    $(function() {
        $('#example1').DataTable({
            pageLength: 5,
            language: {
                emptyTable: "No hay información",
                info: "Mostrando _START_ a _END_ de _TOTAL_ páginas",
                infoEmpty: "Mostrando 0 a 0 de 0 páginas",
                infoFiltered: "(Filtrado de _MAX_ total entradas)",
                lengthMenu: "Mostrar _MENU_ páginas",
                loadingRecords: "Cargando...",
                processing: "Procesando...",
                search: "Buscador:",
                zeroRecords: "Sin resultados encontrados",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                }
            },
            responsive: true,
            lengthChange: true,
            autoWidth: false,
            buttons: [{
                    text: '<i class="fas fa-copy"></i> COPIAR',
                    extend: 'copy',
                    className: 'btn btn-default'
                },
                {
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    extend: 'pdf',
                    className: 'btn btn-danger'
                },
                {
                    text: '<i class="fas fa-file-csv"></i> CSV',
                    extend: 'csv',
                    className: 'btn btn-info'
                },
                {
                    text: '<i class="fas fa-file-excel"></i> EXCEL',
                    extend: 'excel',
                    className: 'btn btn-success'
                },
                {
                    text: '<i class="fas fa-print"></i> IMPRIMIR',
                    extend: 'print',
                    className: 'btn btn-warning'
                }
            ]
        }).buttons().container().appendTo('#example1_wrapper .row:eq(0)');
    });
</script>
@stop