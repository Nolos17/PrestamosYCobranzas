@extends('layouts.admin')

@section('content_header')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <h1><b>Informacion Socio {{ $cliente->apellidos }} {{ $cliente->nombres }}</b></h1>
            </div>
        </div>
        <div class="col-md-6 text-right">
            <div class="form-group">
                <a href="{{ url('/admin/clientes') }}" class="btn btn-danger">Volver</a>
            </div>
        </div>
    </div>

@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Información del Socio</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body collapse show">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-id-card"></i> Nro de Identificación:</label>
                                        <span id="nro_documento">{{ $cliente->nro_documento }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-user"></i> Apellidos:</label>
                                        <span id="apellidos">{{ $cliente->apellidos }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-user"></i> Nombres:</label>
                                        <span id="nombres">{{ $cliente->nombres }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-calendar-alt"></i> Fecha de Nacimiento:</label>
                                        <span id="fecha_nacimiento">{{ $cliente->fecha_nacimiento }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-venus-mars"></i> Género:</label>
                                        <span id="genero">{{ $cliente->genero }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-envelope"></i> Correo Electrónico:</label>
                                        <span id="email">{{ $cliente->email }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-mobile-alt"></i> Celular:</label>
                                        <span id="celular">{{ $cliente->celular }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-phone"></i> Ref. Celular:</label>
                                        <span id="ref_celular">{{ $cliente->ref_celular }}</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><i class="fas fa-chart-line"></i> Nro. Acciones:</label>
                                        <span id="acciones">{{ $cliente->acciones }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-chart-line"></i> Fecha de Afiliación:</label>
                                        <span id="fecha_afiliacion">{{ $cliente->fecha_afiliacion }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-chart-line"></i> Saldo Ahorro Actual:</label>
                                        <span id="saldo_ahorro">{{ $cliente->saldo_ahorro }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><i class="fas fa-chart-line"></i> Saldo Ahorro Inicial:</label>
                                        <span id="saldo_ahorro">{{ $cliente->saldo_ahorro1 }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- /.card-body -->
            </div> <!-- /.card -->
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h3 class="card-title">Informacion Prestamos del Socio</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-plus"></i>
                        </button>

                    </div>
                </div>
                <div class="card-body collapse">
                    <div class=row>
                        @if ($prestamos->isEmpty())
                            <p class="text-center">No hay información disponible</p>
                        @else
                            <table id=example1 class="table">
                                <thead>
                                    <tr>
                                        <th style="text-align: center">Nro</th>
                                        <th style="text-align: center">Monto Prestado</th>
                                        <th style="text-align: center">Tipo de Prestamo</th>
                                        <th style="text-align: center">Modalidad</th>
                                        <th style="text-align: center">Saldo pendiente</th>
                                        <th style="text-align: center">Fecha de Inicio</th>
                                        <th style="text-align: center">Estado</th>
                                        <th style="text-align: center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $contador = 1;
                                    @endphp
                                    @foreach ($prestamos as $prestamo)
                                        <tr>
                                            <td style="text-align: center">{{ $contador++ }}</td>
                                            <td style="text-align: center">{{ $prestamo->monto_prestado }}</td>
                                            <td style="text-align: center">{{ $prestamo->metodo_prestamo }}</td>
                                            <td style="text-align: center">{{ $prestamo->modalidad }}</td>
                                            <td style="text-align: center">{{ $prestamo->monto_total }}</td>
                                            <td style="text-align: center">{{ $prestamo->fecha_inicio }}</td>
                                            <td style="text-align: center">{{ $prestamo->estado }}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <!-- Botón de Ver -->
                                                    <a href="{{ url('/admin/prestamos/' . $prestamo->id) }}"
                                                        class="btn btn-info btn-sm"
                                                        style="border-radius: 4px 0px 0px 4px">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <!-- Botón de imprimir contrato -->
                                                    <a href="{{ url('/admin/prestamos/contratos/' . $prestamo->id) }}"
                                                        class="btn btn-warning btn-sm"
                                                        style="border-radius: 0px 0px 0px 0px">
                                                        <i class="fas fa-print"></i>
                                                    </a>

                                                    <!-- Botón de Editar -->
                                                    <a href="{{ url('/admin/prestamos/' . $prestamo->id . '/edit') }}"
                                                        class="btn btn-success btn-sm"
                                                        style="border-radius: 0px 0px 0px 0px" hidden>
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>

                                                    <!-- Formulario de eliminación -->
                                                    <form action="{{ url('/admin/prestamos/' . $prestamo->id) }}"
                                                        method="post" id="miFormulario{{ $prestamo->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            style="border-radius: 0px 4px 4px 0px " hidden
                                                            onclick='preguntar("{{ $prestamo->id }}");'>
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
                        @endif
                    </div>

                </div> <!-- /.card-body -->
            </div> <!-- /.card -->
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">Informacion Ahorros del Socio</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>

                    </div>
                </div>
                <div class="card-body collapse">
                    <div class=row>
                        <table id=example1 class="table">
                            <thead>
                                <tr>
                                    <th style="text-align: center">Nro</th>

                                    <th style="text-align: center">Referencia de Pago</th>
                                    <th style="text-align: center">Monto</th>
                                    <th style="text-align: center">Multa</th>
                                    <th style="text-align: center">Estado</th>
                                    <th style="text-align: center">Fecha de Pago</th>
                                    <th style="text-align: center">Detalle</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $contador = 1;
                                @endphp
                                @foreach ($ahorros as $prestamo)
                                    <tr>
                                        <td style="text-align: center">{{ $contador++ }}</td>
                                        <td>{{ $prestamo->referencia_pago }}</td>
                                        <td>{{ $prestamo->monto_ahorro }}</td>
                                        <td>{{ $prestamo->multa }}</td>
                                        <td>{{ $prestamo->estado }}</td>
                                        <td>{{ $prestamo->fecha_pago }}</td>
                                        <td>{{ $prestamo->detalle_pago }}</td>



                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div> <!-- /.card-body -->
            </div> <!-- /.card -->
        </div>
    </div>
@stop


@section('css')
@stop

@section('js')
@stop
