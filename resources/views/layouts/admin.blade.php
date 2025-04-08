@extends('adminlte::page')


@section('preloader')
<div class="text-center">
    <img src="{{ asset('img/cargandodinero2.gif') }}" alt="Contando dinero" style="width: 100px; height: 100px;">
    <h4 class="mt-4 text-dark">Contando dinero...</h4>
</div>
@stop

@push('css')

<style>
    /* Estilos para el contenedor del logo y texto */


    .preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: white;
        /* Sin fondo, para que se vea el fondo de la página */
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }



    a.brand-link {
        display: flex !important;
        align-items: center !important;
        padding: 10px 10px !important;
        background-color: #f8f9fa !important;
        transition: background-color 0.3s ease !important;
    }

    a.brand-link:hover {
        background-color: #e9ecef !important;
    }

    /* Estilos para la imagen del logo */
    a.brand-link img.brand-image {
        width: 60px !important;
        height: 60px !important;
        object-fit: contain !important;
        margin-right: 10px !important;
        transition: transform 0.3s ease !important;
        border-radius: 0 !important;
    }

    a.brand-link:hover img.brand-image {
        transform: scale(1.1) !important;
        opacity: 1 !important;
    }

    /* Estilos para el texto del nombre */
    a.brand-link span.brand-text {
        font-size: 1.2rem !important;
        font-family: 'Roboto', sans-serif !important;
        color: #333 !important;
        letter-spacing: 1px !important;
        transition: color 0.3s ease !important;

        max-width: 150px;
        /* Ajusta el ancho según sea necesario */
        display: block;
        /* Para que respete el ancho máximo */
        white-space: normal;
        /* Permite que el texto se divida en varias líneas */
        word-wrap: break-word;
        /* Corta palabras largas si es necesario */
        overflow-wrap: break-word;
        /* Asegura que las palabras largas se dividan */
        text-align: center;
        /* Centra el texto */
        flex-grow: 1;
        /* Ocupa el espacio disponible */
    }


    a.brand-link span.brand-text b {
        font-weight: 700 !important;
        color: #007bff !important;
    }

    a.brand-link:hover span.brand-text {
        color: #007bff !important;
    }
</style>
@endpush