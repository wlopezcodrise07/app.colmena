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
                  <button type="button" name="button" class="btn btn-sm btn-secondary btnAgregarCliente" data-bs-toggle="modal" data-bs-target="#ProductoClienteModal"><i class="fa fa-plus"></i> Agregar </button>
                </div>
              </div><br>
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table id="consulta" class="table table-hover table-condensed" style="font-size: 12px">
                      <thead>
                        <tr>
                          <th>Producto</th>
                          <th>Cliente</th>
                          <th>Contacto</th>
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
    <div class="modal fade" id="ProductoClienteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formProductoCliente">
              <div class="modal-body">
                <div class="row ">
                    @csrf
                    <div class="row">
                      <div class="col-md-12">
                        <label for="">PRODUCTO</label>
                        <input type="text" class="form-control" name="producto" value="" max="250" required>
                        <input type="hidden" class="form-control" name="id" value="" >
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <label for="">CLIENTE</label>
                        <select class="form-control" name="cliente" required>
                          <option value="">Seleccione</option>
                          @foreach ($clientes as $key)
                            <option value="{{$key->CCODCLI}}">{{$key->CNOMCLI}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <label for="">CONTACTO</label>
                        <input type="text" class="form-control" name="contacto" value="" max="250">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <label for="">ESTADO</label>
                        <select class="form-control" name="estado" required>
                          <option value="1">Activado</option>
                          <option value="0">Desactivado</option>
                        </select>
                      </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" type="submit">Guardar</button>
              </div>
          </div>
            </form>
      </div>
    </div>
  </div>
  <div class="modal fade" id="ProductoCalendarioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="modalTitle"></h5>
              <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
            <div class="modal-body">
              <form id="formProductoCalendario">
              <div class="row ">
                @csrf
                <div class="row">
                  <div class="col-md-6">
                    <label>Campaña</label>
                    <input type="month" class="form-control" name="mes" value="{{date('Y-m')}}">
                    <input type="hidden" class="form-control" name="id" value="" >
                  </div>
                  <div class="col-md-6">
                    <br><button type="submit" class="btn btn-primary" name="button">Agregar</button>
                  </div>
                </div><br><br>
                <div class="row">
                  <div class="col-md-12 table-responsive">
                    <table width="100%" class="table" id="tableCampaña">
                      <thead>
                        <tr>
                          <th>Campaña</th>
                          <th>Estado</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </form>
            </div>
      </div>
    </div>
  </div>
</main>
@endsection
