@extends('layouts.admin')

@section('content_header')
<h1><b>Editar una Configuracion</b></h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-success">
            <div class="card-header">
                <h3 class="card-title">Llene los datos del formulario</h3>
            </div>
            <div class="card-body">

                <form action="{{url ('admin/configuraciones',$configuraciones->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method ('put')
                    <div class=row>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Nombre de la institución</label> <b>(*)</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-building"></i></span>
                                            </div>
                                            <input type="text" name="nombre" value="{{$configuraciones->nombre}}" class="form-control" placeholder="Escriba aquí..." required>
                                        </div>
                                        @error('nombre')
                                        <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Descripción de la institución</label> <b>(*)</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                            </div>
                                            <input type="text" name="descripcion" value="{{$configuraciones->descripcion}}" class="form-control" placeholder="Escriba aquí..." required>
                                        </div>
                                        @error('nombre')
                                        <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Direccion</label> <b>(*)</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            </div>
                                            <input type="address" name="direccion" value="{{$configuraciones->direccion}}" class="form-control" placeholder="Escriba aquí..." required>
                                        </div>
                                        @error('nombre')
                                        <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">Telefono</label> <b>(*)</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="phone" name="telefono" value="{{$configuraciones->telefono}}" class="form-control" placeholder="Escriba aquí..." required>
                                        </div>
                                        @error('nombre')
                                        <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="">Email</label> <b>(*)</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            <input type="email" name="email" value="{{$configuraciones->email}}" class="form-control" placeholder="Escriba aquí..." required>
                                        </div>
                                        @error('nombre')
                                        <small style="color: red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Pagina Web</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                            </div>
                                            <input type="text" name="web" value="{{$configuraciones->web}}" class="form-control" placeholder="Escriba aquí...">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Moneda">Moneda</label> <b>(*)</b>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-coins"></i></span>
                                            </div>
                                            <select name="moneda" id="Moneda" class="form-control" required>
                                                <option value="usd" {{ $configuraciones->moneda == 'usd' ? 'selected' : '' }}>Dólar (USD)</option>
                                                <option value="eur" {{ $configuraciones->moneda == 'eur' ? 'selected' : '' }}>Euro (EUR)</option>
                                                <option value="jpy" {{ $configuraciones->moneda == 'jpy' ? 'selected' : '' }}>Yen Japonés (JPY)</option>
                                                <option value="gbp" {{ $configuraciones->moneda == 'gbp' ? 'selected' : '' }}>Libra Esterlina (GBP)</option>
                                                <option value="btc" {{ $configuraciones->moneda == 'btc' ? 'selected' : '' }}>Bitcoin (BTC)</option>
                                                <option value="inr" {{ $configuraciones->moneda == 'inr' ? 'selected' : '' }}>Rupia India (INR)</option>
                                                <option value="mxn" {{ $configuraciones->moneda == 'mxn' ? 'selected' : '' }}>Peso Mexicano (MXN)</option>
                                                <option value="cad" {{ $configuraciones->moneda == 'cad' ? 'selected' : '' }}>Dólar Canadiense (CAD)</option>
                                                <option value="chf" {{ $configuraciones->moneda == 'chf' ? 'selected' : '' }}>Franco Suizo (CHF)</option>
                                                <option value="ars" {{ $configuraciones->moneda == 'ars' ? 'selected' : '' }}>Peso Argentino (ARS)</option>
                                                <option value="clp" {{ $configuraciones->moneda == 'clp' ? 'selected' : '' }}>Peso Chileno (CLP)</option>
                                                <option value="pen" {{ $configuraciones->moneda == 'pen' ? 'selected' : '' }}>Sol Peruano (PEN)</option>
                                                <option value="brl" {{ $configuraciones->moneda == 'brl' ? 'selected' : '' }}>Real Brasileño (BRL)</option>
                                                <option value="aud" {{ $configuraciones->moneda == 'aud' ? 'selected' : '' }}>Dólar Australiano (AUD)</option>
                                                <option value="cny" {{ $configuraciones->moneda == 'cny' ? 'selected' : '' }}>Yuan Chino (CNY)</option>
                                                <option value="sek" {{ $configuraciones->moneda == 'sek' ? 'selected' : '' }}>Corona Sueca (SEK)</option>
                                                <option value="nok" {{ $configuraciones->moneda == 'nok' ? 'selected' : '' }}>Corona Noruega (NOK)</option>
                                                <option value="rub" {{ $configuraciones->moneda == 'rub' ? 'selected' : '' }}>Rublo Ruso (RUB)</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Valor Interes Base Mensual</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-percentage"></i></span>
                                            </div>
                                            <input type="text" value="{{$configuraciones->base_prestamo}}" name="base_prestamo" class="form-control" placeholder="Escriba aquí...">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Valor Accion</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                            </div>
                                            <input type="text" value="{{$configuraciones->valor_accion}}" name="valor_accion" class="form-control" placeholder="Escriba aquí...">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Valor Retención</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-invoice-dollar"></i></span>
                                            </div>
                                            <input type="text" value="{{$configuraciones->valor_retencion}}" name="valor_retencion" class="form-control" placeholder="Escriba aquí...">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Valor Multa por Mora</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-exclamation-circle"></i></span>
                                            </div>
                                            <input type="text" value="{{$configuraciones->valor_mora}}" name="valor_mora" class="form-control" placeholder="Escriba aquí...">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="logo">Logo</label> <b>(*)</b>
                                <input type="file" id="file" name="logo" accept=".png, .jpg, .jpeg" class="form-control">
                                @error('logo')
                                <small style="color: red">{{ $message }}</small>
                                @enderror

                                <center><output id="list">
                                        <img src="{{ asset('storage/' . $configuraciones->logo) }}" width="150px" alt="LOGO" center>
                                    </output></center>
                                <script>
                                    function archivo(evt) {
                                        var files = evt.target.files;
                                        for (var i = 0, f; f = files[i]; i++) {
                                            if (!f.type.match('image.*')) {
                                                continue;
                                            }
                                            var reader = new FileReader();
                                            reader.onload = (function(theFile) {
                                                return function(e) {
                                                    document.getElementById("list").innerHTML = ['<img class="thumb thumbnail" src="', e.target.result, '" width="70%" ', 'title="', escape(theFile.name), '"/>'].join('');
                                                };
                                            })(f);
                                            reader.readAsDataURL(f);
                                        }
                                    }
                                    document.getElementById('file').addEventListener('change', archivo, false);
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="md-col-6">
                            <div class="form-group">
                                <a href="{{ url('/admin/configuraciones') }}" class="btn btn-danger">Cancelar</a>
                                <button type="submit" class="btn btn-success">Modificar</button>
                            </div>
                        </div>
                    </div>
                </form>


            </div> <!-- /.card-body -->
        </div> <!-- /.card -->
    </div>
</div>
@stop


@section('css')
@stop

@section('js')
@stop
