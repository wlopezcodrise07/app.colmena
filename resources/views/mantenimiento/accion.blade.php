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
            <div class="card-header text-secondary">{{$title}}</div>
            <div class="card-body">
              <div class="row">
                <div class="col-xl-3">
                  <button type="button" name="button" class="btn btn-sm btn-secondary btnAgregar" data-bs-toggle="modal" data-bs-target="#Modal"><i class="fa fa-plus"></i> Agregar </button>
                </div>
              </div><br>
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table id="consulta" class="table table-hover table-condensed" style="font-size: 12px">
                      <thead>
                        <tr>
                          <th>Código</th>
                          <th>Descripción</th>
                          <th>Tipo</th>
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

    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formMantto">
              <div class="modal-body">
                <div class="row ">
                    @csrf
                    <div class="row">
                      <div class="col-md-12">
                        <label for="">Código</label>
                        <input type="text" class="form-control" name="codigo" value="" max="100" required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <label for="">Descripción</label>
                        <input type="hidden" class="form-control" name="id" value="" max="20" required>
                        <input type="text" class="form-control" name="descripcion" value="" max="100" required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <label for="">Tipo</label>
                        <select class="form-control" name="tipo">
                          <option value="1">Influencer</option>
                          <option value="2">Servicio</option>
                        </select>
                      </div>
                    </div>
                    <div class="alertAccionTipo">

                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <label for="">Estado</label>
                        <select class="form-control" name="estado">
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
</main>
@endsection
