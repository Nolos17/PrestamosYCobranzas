@extends('adminlte::page')

{{-- Customize layout sections --}}



{{-- Content body: main page content --}}

@section('content_body')
<p>Welcome to this beautiful admin panel.</p>
biendenido
@stop

{{-- Push extra CSS --}}

@push('css')
{{-- Add here extra stylesheets --}}
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
<script>
    console.log("Hi, I'm using the Laravel-AdminLTE package!");
</script>
@endpush