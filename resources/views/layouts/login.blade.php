@extends('adminlte::auth.login')


@push('css')
<style>
    /* Pantalla del login */
    /* Fondo de la página de login */
    body.login-page {
        position: relative;
        font-family: 'Roboto', sans-serif !important;
        min-height: 100vh !important;
        background: none;
        /* Eliminamos cualquier otro fondo */
    }

    body.login-page::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;

        background: url("{{ asset('img/fondoahorro.png') }}") no-repeat center center/cover;
        opacity: 0.5;
        /* Ajusta la transparencia (0 es completamente transparente, 1 es completamente visible) */
        z-index: -1;
        /* Lo envía al fondo */
    }



    /* Contenedor principal */
    /* Contenedor principal alineado a la derecha */
    .login-box {
        width: 400px !important;
        position: absolute;
        top: 50%;
        right: 10%;
        /* Ajusta según lo necesites */
        transform: translateY(-50%);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
        border-radius: 10px !important;
        background-color: #ffffff !important;
    }

    /* Contenedor del logo */
    .login-logo {
        text-align: center !important;
        padding: 20px 0 !important;
    }

    /* Estilos para el enlace del logo */
    .login-logo a {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        text-decoration: none !important;
    }

    /* Estilos para la imagen del logo */
    .login-logo a img {
        width: 50px !important;
        height: 50px !important;
        object-fit: contain !important;
        margin-right: 10px !important;
        transition: transform 0.3s ease !important;
        border-radius: 50% !important;
        opacity: 0.8 !important;
    }

    .login-logo a:hover img {
        transform: scale(1.1) !important;
        opacity: 1 !important;
    }

    /* Estilos para el texto del logo */
    .login-logo a {
        font-size: 1.8rem !important;
        font-family: 'Roboto', sans-serif !important;
        color: #333 !important;
        letter-spacing: 1px !important;
        transition: color 0.3s ease !important;
    }

    .login-logo a b {
        font-weight: 700 !important;
        color: #007bff !important;
    }

    .login-logo a:hover {
        color: #007bff !important;
    }

    /* Contenedor del formulario */
    .card {
        border: none !important;
        border-radius: 10px !important;
    }

    .card-header {
        background-color: #ffffff !important;
        border-bottom: none !important;
        text-align: center !important;
        padding: 15px !important;
    }

    .card-title {
        font-size: 1.3rem !important;
        color: #333 !important;
    }

    .login-card-body {
        padding: 30px !important;
        border-radius: 10px !important;
    }

    .login-box-msg {
        font-size: 1.1rem !important;
        color: #666 !important;
        margin-bottom: 20px !important;
    }

    /* Campos del formulario */
    .input-group {
        margin-bottom: 20px !important;
    }

    .form-control {
        border-radius: 5px !important;
        border: 1px solid #ced4da !important;
        padding: 10px !important;
        font-size: 1rem !important;
        transition: border-color 0.3s ease !important;
    }

    .form-control:focus {
        border-color: #007bff !important;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.3) !important;
    }

    .input-group-text {
        background-color: #f8f9fa !important;
        border: 1px solid #ced4da !important;
        border-radius: 5px !important;
        color: #666 !important;
    }

    /* Checkbox */
    .icheck-primary {
        margin-bottom: 15px !important;
    }

    /* Botón de "Acceder" */
    .btn-primary {
        background-color: #007bff !important;
        border-color: #007bff !important;
        border-radius: 5px !important;
        padding: 10px !important;
        font-size: 1rem !important;
        transition: background-color 0.3s ease !important;
    }

    .btn-primary:hover {
        background-color: #0056b3 !important;
        border-color: #0056b3 !important;
    }

    /* Enlaces */
    .card-footer a {
        color: #007bff !important;
        text-decoration: none !important;
        transition: color 0.3s ease !important;
    }

    .card-footer a:hover {
        color: #0056b3 !important;
        text-decoration: underline !important;
    }

    /* Ajustes para modo oscuro (si lo usas) */
    @media (prefers-color-scheme: dark) {
        body.login-page {
            background: linear-gradient(135deg, #2c3e50, #4a5568) !important;
        }

        .login-box {
            background-color: #343a40 !important;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3) !important;
        }

        .login-logo a {
            color: #ffffff !important;
        }

        .login-logo a b {
            color: #66b0ff !important;
        }

        .login-logo a:hover {
            color: #66b0ff !important;
        }

        .card-header {
            background-color: #343a40 !important;
        }

        .card-title {
            color: #ffffff !important;
        }

        .login-box-msg {
            color: #adb5bd !important;
        }

        .form-control {
            background-color: #495057 !important;
            border-color: #6c757d !important;
            color: #ffffff !important;
        }

        .form-control:focus {
            border-color: #66b0ff !important;
            box-shadow: 0 0 5px rgba(102, 176, 255, 0.3) !important;
        }

        .input-group-text {
            background-color: #495057 !important;
            border-color: #6c757d !important;
            color: #adb5bd !important;
        }

        .card-footer a {
            color: #66b0ff !important;
        }

        .card-footer a:hover {
            color: #4a90e2 !important;
        }
    }
</style>
@endpush