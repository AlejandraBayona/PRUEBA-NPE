@extends('layouts.app_auth')

@section('content')
{{-- Abrire section container--}}
@php
    if(session_status() === PHP_SESSION_NONE)
    {
        session_start();
    }
@endphp

@if(isset($_SESSION['error_login']))
<div class="alert alert-danger" role="alert">
    @php
        echo $_SESSION['error_login'];
        session_unset();
        session_destroy();
    @endphp
</div>
@endif

@if(isset($_SESSION['success_login']))
<div class="alert alert-success" role="alert">
    @php
        echo $_SESSION['success_login'];
        session_unset();
        session_destroy();
    @endphp
</div>
@endif

<div class="section-form" id="section-validate-nit">
    <div class="form-row">
        <div class="col-12 text-center d-flex justify-content-center">
            <div class="container-form">
                <div class="">
                    <form id="formValidateNit" name="postNit" action="/login" method="POST">
                        <div class="form-group">
                            <label for="nit-request">NIT</label>
                            <input type="text" class="nit-input form-control" name="nitRequest" id="nitRequest" autocomplete="off" maxlength="14" placeholder="00000000000000" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" required="required" aria-invalid="true">
                            <span style="font-size: 13px;">Ingrese su numero de NIT sin guiones</span>
                            <br>

                            <label for="password" style="margin-top: 10px;">Password</label>
                            <input type="password" class="password form-control" name="password" id="password">

                        </div>

                        <button type="submit" class="btn btn-success" id="btnSubmitNitValidate"> Ingresar </button>
                        <a class="btn btn-primary" href="{{url('/') }}/register">Registrarse</a>
                    </form>
                        <a href="{{url('/') }}/reset">Recuperar contraseña</a>
                    <br>
                    
                </div>
            </div>
        </div>
    </div>
</div>


@endsection