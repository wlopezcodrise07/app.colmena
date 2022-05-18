@extends('layouts.app')
@section('title')
{{$title}}
@endsection
@section('js'){{$js}}@endsection

@section('content')
<main>
    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="layout"></i></div>
                            {{$title}}
                        </h1>
                    </div>
                </div>
                <nav class="mt-4 rounded" aria-label="breadcrumb">
                    <ol class="breadcrumb px-3 py-2 rounded mb-0">
                        <li class="breadcrumb-item active">{{$title}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header text-secondary">Actualización de Datos<div class="float-end"><button class="btn btn-sm  btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#changePassModal" type="button"><i class="fa-solid fa-lock"></i>Actualizar Clave</button> </div></div>
            <div class="card-body">
              <form id="formUsuario">
                  @csrf

                  <div class="row mb-3">
                      <label for="nombre" class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>

                      <div class="col-md-6">
                          <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ Auth::user()->nombre }}" required autocomplete="nombre" autofocus>

                          @error('nombre')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                  </div>
                  <div class="row mb-3">
                      <label for="apepat" class="col-md-4 col-form-label text-md-end">{{ __('Apellido Paterno') }}</label>

                      <div class="col-md-6">
                          <input id="apepat" type="text" class="form-control @error('apepat') is-invalid @enderror" name="apepat" value="{{ Auth::user()->apepat }}" required autocomplete="apepat" autofocus>

                          @error('apepat')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                  </div>
                  <div class="row mb-3">
                      <label for="apemat" class="col-md-4 col-form-label text-md-end">{{ __('Apellido Materno') }}</label>

                      <div class="col-md-6">
                          <input id="apemat" type="text" class="form-control @error('apemat') is-invalid @enderror" name="apemat" value="{{ Auth::user()->apemat }}" required autocomplete="apemat" autofocus>

                          @error('apemat')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                  </div>
                  <div class="row mb-3">
                      <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>

                      <div class="col-md-6">
                          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" required autocomplete="email">

                          @error('email')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                  </div>
                  <div class="row mb-3">
                      <label for="documento" class="col-md-4 col-form-label text-md-end">{{ __('Documento') }}</label>

                      <div class="col-md-6">
                          <input id="documento" type="text" class="form-control @error('documento') is-invalid @enderror" name="documento" value="{{ Auth::user()->documento }}" required autocomplete="documento" autofocus>

                          @error('documento')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </div>
                  </div><!--
                  -->

                  <div class="row mb-0">
                      <div class="col-md-6 offset-md-4">
                          <button type="submit" class="btn btn-secondary">
                              {{ __('Actualizar') }}
                          </button>
                      </div>
                  </div>
              </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="changePassModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cambio de Contraseña</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formChangePass">
              <div class="modal-body">
                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                    @csrf

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-dark" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Actualizar Clave</button>
              </div>
          </div>
            </form>
    </div>
</div>
</main>
@endsection
