@extends('layouts.admin')
@section('content_header')
<h1><b>Bienvenido </b></h1>
<hr>
@stop

@section('content')
<section content>
    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ url('/admin/configuraciones') }}">
                            <img src="{{ url('/img/herramientas-de-servicio.gif') }}" width="100%" alt="imagen">
                        </a>
                    </div>
                    <div class="col-md-9" style="margin-top: 8px;">
                        <h5><b>Configuraciones registradas</b></h5>
                        {{ $total_configuraciones }} configuraciones
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ url('/admin/roles') }}">
                            <img src="{{ url('/img/carpeta.gif') }}" width="100%" alt="imagen">
                        </a>
                    </div>
                    <div class="col-md-9" style="margin-top: 8px;">
                        <h5><b>Roles registrados</b></h5>
                        {{ $total_roles }} roles
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ url('/admin/users') }}">
                            <img src="{{ url('/img/trabajo-en-equipo.gif') }}" width="100%" alt="imagen">
                        </a>
                    </div>
                    <div class="col-md-9" style="margin-top: 8px;">
                        <h5><b>Usuarios registrados</b></h5>
                        {{ $total_users }} usuarios
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ url('/admin/clientes') }}">
                            <img src="{{ url('/img/usuario.gif') }}" width="100%" alt="imagen">
                        </a>
                    </div>
                    <div class="col-md-9" style="margin-top: 8px;">
                        <h5><b>Clientes registrados</b></h5>
                        {{ $total_clientes }} clientes
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop



@section('css')

@stop

@section('js')

@stop