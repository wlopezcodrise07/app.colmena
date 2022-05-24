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
                        <li class="breadcrumb-item ">Mantenimiento</li>
                        <li class="breadcrumb-item active">{{$title}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <div class="card">
            <div class="card-header text-secondary">Clientes</div>
            <div class="card-body">
              <div class="row">
                <div class="col-xl-3">
                  <button type="button" name="button" class="btn btn-sm btn-secondary btnAgregarCliente" data-bs-toggle="modal" data-bs-target="#clienteModal"><i class="fa fa-plus"></i> Agregar </button>
                </div>
              </div><br>
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table id="consulta" class="table table-hover table-condensed" style="font-size: 12px">
                      <thead>
                        <tr>
                          <th>Código</th>
                          <th>Nombre</th>
                          <th>Dirección</th>
                          <th>Telefono</th>
                          <th>RUC</th>
                          <th>Instagram</th>
                          <th>Tik Tok</th>
                          <th>Twitter</th>
                          <th>Facebook</th>
                          <th>Actualizado por</th>
                          <th>Estado</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="clienteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formCliente">
              <div class="modal-body">
                <div class="row ">
                    @csrf
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <label for="">CÓDIGO</label>
                        <input type="text" class="form-control" name="CCODCLI" value="" max="20" required>
                        <input type="hidden" class="form-control" name="id" value="" max="20" required>
                        <input type="checkbox" class="form-check-input ckb_codigo" name="codigo_asignado" id="codigo_asignado" value=""><label class="ckb_codigo" for="codigo_asignado">¿Asignar Código?</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <label>TIPO DE CLIENTE</label>
                        <select class="form-control" name="tipo" required>
                          <option value="NAT">NATURAL</option>
                          <option value="JUR">JURIDICA</option>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <label for="">RAZON SOCIAL/NOMBRE</label>
                        <input type="text" class="form-control" name="CNOMCLI" value="" max="100" required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <label for="">RUC</label>
                        <input type="text" class="form-control" name="CNUMRUC" value="" max="20" required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <label for="">DIRECCIÓN</label>
                        <input type="text" class="form-control" name="CDIRCLI" value="" max="300" required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <label for="">TELÉFONO</label>
                        <div class="input-group ">
                          <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                          <input type="text" class="form-control" placeholder="Ingrese el número telefónico de contacto" name="CTELEFO" aria-label="Username" max="20" aria-describedby="basic-addon1">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <label for="">FACEBOOK</label>
                        <div class="input-group ">
                          <span class="input-group-text"><i class="fab fa-facebook-f"></i></span>
                          <input type="text" class="form-control" placeholder="Ingrese la dirección de la página de Facebook" name="DIRFB" aria-label="Username" max="100" aria-describedby="basic-addon1">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <label for="">TWITTER</label>
                        <div class="input-group ">
                          <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                          <input type="text" class="form-control" placeholder="Ingrese la dirección de la cuenta de Twitter" name="DIRTWITTER" aria-label="Username" max="100" aria-describedby="basic-addon1">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <label for="">INSTAGRAM</label>
                        <div class="input-group ">
                          <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                          <input type="text" class="form-control" placeholder="Ingrese la dirección de la cuenta de Instagram" name="DIRINSTAGRAM" aria-label="Username" max="100" aria-describedby="basic-addon1">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <label for="">TIKTOK</label>
                        <div class="input-group ">
                          <span class="input-group-text"><i class="fab fa-tiktok"></i></span>
                          <input type="text" class="form-control" placeholder="Ingrese la dirección de la cuenta de Tiktok" name="DIRTIKTOK" aria-label="Username" max="100" aria-describedby="basic-addon1">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <label for="">ESTADO</label>
                        <select class="form-control" name="active">
                          <option value="1">Activado</option>
                          <option value="0">Desactivado</option>
                        </select>
                      </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-dark" type="button" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-secondary" type="submit">Guardar</button>
              </div>
          </div>
            </form>
      </div>
  </div>
</main>
@endsection
