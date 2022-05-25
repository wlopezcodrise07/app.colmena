@extends('layouts.app')
@section('title')
{{$title}}
@endsection
@section('js'){{$js}}@endsection

@section('content')
<style media="screen">
  input,select{
    font-size: 9pt;
  }
</style>
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
                        <li class="breadcrumb-item ">Procesos</li>
                        <li class="breadcrumb-item active">{{$title}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div id="divCotizacionConsultar">
      <div class="container-xl px-4 mt-n10">
          <div class="card">
              <div class="card-header text-secondary">{{$title}}</div>
              <div class="card-body">
                <div class="row">
                  <div class="col-xl-3">
                    <label>Año</label>
                    <select class="form-control" id="periodo">
                      <?php for ($i=2022; $i <= date('Y') ; $i++) { ?>
                        <option value="{{$i}}" <?php echo ($i==date('Y')) ? 'selected' : '' ; ?>>{{$i}}</option>
                      <?php } ?>
                    </select>
                  </div>
                </div><br>
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table id="consulta" class="table table-hover table-condensed" style="font-size: 12px">
                        <thead>
                          <tr>
                            <th>Cotizacion</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Importe Total</th>
                            <th>Cotizado por</th>
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
    </div>
    <div id="divCotizacionEditar" style="display:none">

    </div>

    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-xl modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Versiones</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
              <div class="modal-body">
                <div class="row ">
                  <div class="col-md-12 table-responsive">
                    <table class="table" id="tblVersions">
                      <thead>
                        <tr>
                          <th>Versión</th>
                          <th>Fecha</th>
                          <th>Cliente</th>
                          <th>Importe Total</th>
                          <th>Cotizado por</th>
                          <th>Fec.Creación</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
            </div>
      </div>
    </div>
  </div>
</main>
<script type="text/javascript">
  const periodo_elegido = '{{date('Y')}}'
</script>
@endsection
