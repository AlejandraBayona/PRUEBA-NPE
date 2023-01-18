@extends('layouts.app_auth')

@section('content')
{{-- Abrire section container--}}
@php
    if(session_status() === PHP_SESSION_NONE){
    session_start();
    }
@endphp

@if(isset($_SESSION['error_new_pass']))
<div class="alert alert-danger" role="alert">
    @php
        echo $_SESSION['error_new_pass'];
        session_unset();
        session_destroy();
    @endphp
</div>
@endif

<div class="section-form" id="section-validate-nit">
    <div class="form-row">
        <div class="col-12 text-center justify-content-center">
            <div class="container-form">
                <div class="">
                    <form id="formRestablecerContrasenia" name="form-restablecer" action="/new_password" method="POST">

                        <div class="form-group row">

                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                            <input class="col-md-6" type="password" class="pass-input form-control" name="password" id="password" placeholder="Password" required="required">

                        </div>

                        <div class="form-group row">

                            <label for="confirm-password" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                            <input class="col-md-6" type="password" class="pass-input form-control" name="confirm_password" placeholder="Confirm Password" id="confirm-password" required="required">

                        </div>
                        <input type="hidden" name="token" value="@php echo $_GET['token'] @endphp">

                        <button type="submit" class="btn btn-primary" id="btnSubmitRestablecer">Restablecer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection