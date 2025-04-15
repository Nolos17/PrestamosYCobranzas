@extends('layouts.admin')

@section('content_header')
    <h1><b>Listado de Socios</b></h1>
    <hr>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Socios Registrados</h3>
                    <div class="card-tools">
                        <a href="{{ url('/admin/clientes/create') }}" class="btn btn-primary">Crear Nuevo</a>
                    </div>
                </div>
                <div class="card-body">
                    <table id=example1 class="table">
                        <thead>
                            <tr>
                                <th style="text-align: center">Nro</th>
                                <th style="text-align: center">Identificacion</th>
                                <th style="text-align: center">Apellidos y Nombres</th>
                                <th style="text-align: center">Celular</th>
                                <th style="text-align: center">Nº de Acciones</th>
                                <th style="text-align: center">Saldo Ahorro</th>
                                <th style="text-align: center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $contador = 1;
                            @endphp
                            @foreach ($clientes as $cliente)
                                <tr>
                                    <td style="text-align: center">{{ $contador++ }}</td>
                                    <td>{{ $cliente->nro_documento }}</td>
                                    <td>{{ $cliente->apellidos . ' ' . $cliente->nombres }}</td>
                                    <td>{{ $cliente->celular }}</td>
                                    <td style="text-align: center">{{ $cliente->acciones }}</td>
                                    <td>{{ $cliente->saldo_ahorro }}</td>

                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            @if ($cliente->estado !== 'Deshabilitado')
                                                <!-- Botón de Ver -->
                                                <a href="{{ url('/admin/clientes/' . $cliente->id) }}"
                                                    class="btn btn-info btn-sm" style="border-radius: 4px 0px 0px 4px">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <!-- Botón de Editar -->
                                                <a href="{{ url('/admin/clientes/' . $cliente->id . '/edit') }}"
                                                    class="btn btn-success btn-sm" style="border-radius: 0px 0px 0px 0px">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>

                                                <!-- Botón de Deshabilitar -->
                                                <form action="{{ url('/admin/clientes/deshabilitar/' . $cliente->id) }}"
                                                    method="post" id="miFormularioDeshabilitar{{ $cliente->id }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="button" class="btn btn-warning btn-sm"
                                                        style="border-radius: 0px 4px 4px 0px"
                                                        onclick='preguntar1("{{ $cliente->id }}");'>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif

                                           <!-- Botón de Eliminar (solo si el estado es deshabilitado y saldo_ahorro es 0) -->
                                             @if ($cliente->estado === 'Deshabilitado' && $cliente->saldo_ahorro == 0)
                                                <form action="{{ url('/admin/clientes/' . $cliente->id) }}" method="post"
                                                    id="miFormularioEliminar{{ $cliente->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        style="border-radius: 0px 4px 4px 0px"
                                                        onclick='preguntar("{{ $cliente->id }}");'>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                        <!-- Script para el botón de Deshabilitar -->
                                        <script>
                                            function preguntar1(id) {
                                                Swal.fire({
                                                    title: '¿Desea deshabilitar este registro?',
                                                    text: '',
                                                    icon: 'question',
                                                    showCancelButton: true,
                                                    confirmButtonText: 'Deshabilitar',
                                                    confirmButtonColor: '#d33',
                                                    cancelButtonColor: '#27ae60',
                                                    cancelButtonText: 'Cancelar'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        var form = document.getElementById('miFormularioDeshabilitar' + id);
                                                        if (form) {
                                                            form.submit();
                                                        } else {
                                                            console.error("Formulario no encontrado para el ID: miFormularioDeshabilitar" + id);
                                                        }
                                                    }
                                                });
                                            }
                                        </script>

                                        <!-- Script para el botón de Eliminar -->
                                        <script>
                                            function preguntar(id) {
                                                Swal.fire({
                                                    title: '¿Desea eliminar este registro?. Se perderan todos los registros relacionados',
                                                    text: '',
                                                    icon: 'question',
                                                    showCancelButton: true,
                                                    confirmButtonText: 'Eliminar',
                                                    confirmButtonColor: '#d33',
                                                    cancelButtonColor: '#27ae60',
                                                    cancelButtonText: 'Cancelar'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        var form = document.getElementById('miFormularioEliminar' + id);
                                                        if (form) {
                                                            form.submit();
                                                        } else {
                                                            console.error("Formulario no encontrado para el ID: miFormularioEliminar" + id);
                                                        }
                                                    }
                                                });
                                            }
                                        </script>
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
