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
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table id="consulta" class="table table-hover table-condensed" style="font-size: 12px">
                      <thead>
                        <tr>
                          <th>Influencer</th>
                          <th>Representado por</th>
                          <th>Celular</th>
                          <th>Correo</th>
                          <th>Categoria</th>
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
                        <label for="">Influencer</label>
                        <input type="hidden" name="influencer" value="">
                        <input type="text" class="form-control" name="influencer_descripcion" value="">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <label for="">Representado por:</label>
                        <input type="text" class="form-control" name="representacion" value="" max="250" required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <label for="">Celular:</label>
                        <input type="text" class="form-control" name="celular" value="" max="250" required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <label for="">Correo:</label>
                        <input type="email" class="form-control" name="correo" value="" max="250" required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <label for="">Categoria</label>
                        <div class="row">
                          <?php foreach ($categorias as $key): ?>
                            <div class="col-md-4">
                              <input type="checkbox" class="form-check-input" name="categoria[]" id="categoria{{$key->id}}" value="{{$key->id}}"><label class="form-check-label" style="font-size:9pt" for="categoria{{$key->id}}">{{$key->descripcion}}</label>
                            </div>
                          <?php endforeach; ?>
                        </div>
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
  <div class="modal fade" id="MetricasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-xl modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="modalTitle"></h5>
              <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="formMetricas">
            @csrf
            <input type="hidden" name="influencer" value="">
            <div class="modal-body">
              <div id="divMetricas">

              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="submit">Guardar</button>
            </div>
          </form>
    </div>
  </div>
</div>
</main>
<script type="text/javascript">
  var categoriasArray = '{{($categorias)}}'
  categoriasArray = (JSON.parse(categoriasArray.replace(/&quot;/g,'"')))


</script>
@endsection
