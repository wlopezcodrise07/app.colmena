@extends('layouts.app')
@section('title')
{{$title}}
@endsection
@section('js'){{$js}}@endsection

@section('content')
<script type="text/javascript">
  const clientes = JSON.parse("{{$clientes}}".replace(/&quot;/g,'"'))
  const productos_cliente = JSON.parse("{{$producto_cliente}}".replace(/&quot;/g,'"'))
  const acciones = JSON.parse("{{$acciones}}".replace(/&quot;/g,'"'))
</script>
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
    <div class="container-xl px-4 mt-n10">
      <form id="formCotizacion">
        @csrf
        <div class="row sticky-top mb-4 justify-content-sm-end overflow-auto" style="position: fixed;right: 1.6%;top: 10%;width:20%">
          <div class="col-md-12">
            <div class="card opacity-75" id="divTotales">
              <div class="row m-1">
                <div class="col-md-6">
                    <label for="" style="font-size:8pt">SubTotal(PEN)</label>
                    <input type="text" class="form-control form-control-sm" name="subtotal_pen" value="" readonly required>
                </div>
                <div class="col-md-6">
                    <label for="" style="font-size:8pt">SubTotal(USD)</label>
                    <input type="text" class="form-control form-control-sm" name="subtotal_usd" value="" readonly required>
                </div>
                <div class="col-md-12">
                    <label for="" style="font-size:8pt">FEE</label>
                    <input type="number" class="form-control form-control-sm" min="0" max="100" name="fee" value="0" required>
                </div>
                <div class="col-md-6">
                    <label for="" style="font-size:8pt">Total (Sin IGV PEN)</label>
                    <input type="text" class="form-control form-control-sm" name="total_sinigv_pen" value="" readonly required>
                </div>
                <div class="col-md-6">
                    <label for="" style="font-size:8pt">Total (Sin IGV USD)</label>
                    <input type="text" class="form-control form-control-sm" name="total_sinigv_usd" value="" readonly required>
                </div>
                <div class="col-md-6">
                    <label for="" style="font-size:8pt">Total (Con IGV PEN)</label>
                    <input type="text" class="form-control form-control-sm" name="total_conigv_pen" value="" readonly required>
                </div>
                <div class="col-md-6">
                    <label for="" style="font-size:8pt">Total (Con IGV USD)</label>
                    <input type="text" class="form-control form-control-sm" name="total_conigv_usd" value="" readonly required>
                </div>
                <div class="col-md-12">
                    <label for="" style="font-size:8pt">Total Cotización (PEN)</label>
                    <input type="number" class="form-control form-control-sm" min="0"  name="total_venta" value="0" readonly required>
                </div>
                <div class="col-md-12">
                    <label for="" style="font-size:8pt">Retención Aplicada(12%) (PEN)</label>
                    <input type="number" class="form-control form-control-sm" min="0" name="retencion" value="0" readonly required>
                </div><br>
                <div class="col-md-12">
                  <div id="divRetencion">
                  </div>
                </div>
                <div class="col-md-12">
                  <div  readonlyclass="d-grid gap-2">
                    <br>
                    <button class="btn btn-sm btn-primary" id="btnGuardar" type="submit" disabled>Guardar</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="">
          input
        </div>
          <div class="card">
              <div class="card-header text-secondary">Cotización # {{str_pad($correlativo,7,"0",STR_PAD_LEFT)}}</div>
              <div class="card-body">

                <div class="row mb-1 div_select"  style="display:none">
                  <div class="col-md-4">
                    <label for="">Cliente</label>
                    <select  id="CCCODCLI" name="CCCODCLI" required>

                    </select>
                  </div>
                  <div class="col-md-3">
                    <label for="">Forma de Pago</label>
                    <select  id="CCFORVEN" name="CCFORVEN" required>
                      @foreach ($formas_pago as $key)
                        <option value="{{$key->id}}">{{$key->descripcion}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-2">
                    <label for="">Tipo de Cambio</label>
                    <input type="number" class="form-control form-control-sm" step="any" id="CCTIPCAM" name="CCTIPCAM" min="1" value="1" required>
                  </div>
                </div>
                <div class="row">
                  <label for="">Información Adicional</label>
                  <textarea name="CCGLOSA" class="form-control" cols="10"></textarea>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="float-end">
                      <button class="btn btn-sm  btn-primary btn-addproducto" data-bs-toggle="modal" data-bs-target="#productoModal" type="button" disabled>
                        <i class="fas fa-plus"></i> &nbsp;Agregar Productos
                      </button>
                    </div>
                  </div>
                </div><br>
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header  text-white bg-secondary">
                        <h2 class="text-white">Detalle</h2>
                      </div>
                      <div class="card-body">
                        <div id="divDetailCot">

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
      </form>
    </div>
    <div class="modal fade" id="productoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formProductoSeleccionado">
              <div class="modal-body">
                @csrf
                <div class="row ">
                  <div class="col-md-12">
                    <label for="">Producto</label>
                    <select id="CCPRODUCTO" name="CCPRODUCTO[]" multiple>

                    </select>
                  </div>

                </div>

              </div>
              <div class="modal-footer">
                <button class="btn btn-primary" type="submit">Elegir</button>
              </div>
            </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="addAccionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAccionesAdd">
              <div class="modal-body">
                @csrf
                <input type="hidden" name="idproducto" value="">
                <div class="row ">
                  <div class="col-md-12">
                    <label for="">Tipo</label>
                    <select id="tipoAccion" class="form-control" name="tipoAcion" required>
                      <option value="">Seleccione</option>
                      <option value="1">Influencer</option>
                      <option value="2">Servicio</option>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 mb-3">
                    <label id="">Influencer/Servicio</label>
                    <select id="tipoAccionSeleccionada" name="accion">
                      <option value="">Seleccione</option>

                    </select>
                  </div>
                </div>
                <div id="divAccionCont" class="table-responsive">

                </div>
                <div class="row d-none">
                  <div class="col-md-12">
                    <label for="">Observaciones</label>
                    <textarea name="observaciones" class="form-control" cols="5"></textarea>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-primary" id="btnDetail" type="button">Agregar</button>
              </div>
            </form>
        </div>
      </div>
    </div>
    <div class="modal fade" id="MetricasInfluencerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div id="divMetricas">

              </div>
            </div>
        </div>
      </div>
    </div>
</main>
@endsection
