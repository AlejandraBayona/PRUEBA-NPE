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

<div class="section-form" id="section-validate-nit">
    <div class="form-row">
        <div class="col-12 text-center d-flex justify-content-center">
            <div class="container-form">
                <div class="">
                    <form id="recoverpass" name="recoverpass" action="/recover" method="POST">
                        <div class="form-group">
                            <label for="nit-request">NIT<span style="font-size: 13px;">(numero sin guiones)</span></label>
                            <input type="text" class="nit-input form-control" name="nitRequest" id="nitRequest" autocomplete="off" maxlength="14" placeholder="00000000000000" onKeypress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" required="required" aria-invalid="true">
                            <label for="email">email<span style="font-size: 13px;">(cuenta asociada a numero de NIT)</span></label>
                            <input type="email" class="email form-control" name="email" id="email">

                        </div>

                        <button type="submit" class="btn btn-success" id="btnSubmitNitValidate"> Recuperar </button>
                    </form>
                    <br>
                    
                </div>
            </div>
        </div>
    </div>
</div>


@endsection