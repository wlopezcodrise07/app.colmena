<div class="container-xl px-4 mt-n10">
<script type="text/javascript">
  const clientes = JSON.parse("{{$clientes}}".replace(/&quot;/g,'"'))
  const productos_cliente = JSON.parse("{{$producto_cliente}}".replace(/&quot;/g,'"'))
  const acciones = JSON.parse("{{$acciones}}".replace(/&quot;/g,'"'))
</script>
  <form id="formCotizacion">
    @csrf
    <div class="row sticky-top mb-4 justify-content-sm-end overflow-auto" style="position: fixed;right: 1.6%;top: 10%;width:20%">
      <div class="col-md-12">
        <div class="card opacity-75" id="divTotales">
          <div class="row m-1">
            <div class="col-md-6">
                <label for="" style="font-size:8pt">SubTotal(PEN)</label>
                <input type="text" class="form-control form-control-sm" name="subtotal_pen" value="{{number_format($cabecera->CCIMPORTE*((100-$cabecera->CCFEEPOR)/100),2,'.','')}}" readonly required>
            </div>
            <div class="col-md-6">
                <label for="" style="font-size:8pt">SubTotal(USD)</label>
                <input type="text" class="form-control form-control-sm" name="subtotal_usd" value="{{number_format($cabecera->CCIMPORTEUSD*((100-$cabecera->CCFEEPOR)/100),2,'.','')}}" readonly required>
            </div>
            <div class="col-md-12">
                <label for="" style="font-size:8pt">FEE</label>
                <input type="number" class="form-control form-control-sm" min="0" max="100" name="fee" value="{{number_format($cabecera->CCFEEPOR,2,'.','')}}" required>
            </div>
            <div class="col-md-6">
                <label for="" style="font-size:8pt">Total (Sin IGV PEN)</label>
                <input type="text" class="form-control form-control-sm" name="total_sinigv_pen" value="{{number_format($cabecera->CCIMPORTE,2,'.','')}}" readonly required>
            </div>
            <div class="col-md-6">
                <label for="" style="font-size:8pt">Total (Sin IGV USD)</label>
                <input type="text" class="form-control form-control-sm" name="total_sinigv_usd" value="{{number_format($cabecera->CCIMPORTEUSD,2,'.','')}}" readonly required>
            </div>
            <div class="col-md-6">
                <label for="" style="font-size:8pt">Total (Con IGV PEN)</label>
                <input type="text" class="form-control form-control-sm" name="total_conigv_pen" value="{{number_format($cabecera->CCIMPORTE*1.18,2,'.','')}}" readonly required>
            </div>
            <div class="col-md-6">
                <label for="" style="font-size:8pt">Total (Con IGV USD)</label>
                <input type="text" class="form-control form-control-sm" name="total_conigv_usd" value="{{number_format($cabecera->CCIMPORTEUSD*1.18,2,'.','')}}" readonly required>
            </div>
            <div class="col-md-12">
                <label for="" style="font-size:8pt">Total Cotización (PEN)</label>
                <input type="number" class="form-control form-control-sm" min="0"  name="total_venta" value="{{number_format($cabecera->CCIMPORTEVTA,2,'.','')}}" readonly required>
            </div>
            <div class="col-md-12">
                <label for="" style="font-size:8pt">Retención Aplicada(12%) (PEN)</label>
                <input type="number" class="form-control form-control-sm" min="0" name="retencion" value="{{number_format($cabecera->CCRETENCION,2,'.','')}}" readonly required>
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

      <div class="card">
          <div class="card-header text-secondary">
            <div class="float-start">
              <button type="button" class="btn btn-info btn-sm btn-atras" name="button">Atras</button>
            </div><br><br>
            Cotización # {{str_pad($cabecera->CCNUMDOC,7,"0",STR_PAD_LEFT)}}
          </div>
          <div class="card-body">
            <input type="hidden" name="CCNUMDOC" value="{{$cabecera->CCNUMDOC}}">
            <input type="hidden" name="CCVERSION" value="{{$cabecera->CCVERSION}}">
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
                <input type="number" class="form-control form-control-sm" step="any" id="CCTIPCAM" name="CCTIPCAM" min="1" value="{{number_format($cabecera->CCTIPCAM,2,'.','')}}" required>
              </div>
            </div>
            <div class="row">
              <label for="">Información Adicional</label>
              <textarea name="CCGLOSA" class="form-control" cols="10">{{$cabecera->CCGLOSA}}</textarea>
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
                      <?php foreach ($productos as $key): ?>
                        <div class="card detailProduct" id="producto_{{$key->CDPRODUCTO}}">
                          <div class="card-header">
                            <input type="hidden" name="idproducto" value="{{$key->CDPRODUCTO}}">
                            <label class="h2 text-dark">{{$key->producto}}</label>
                            <div class="float-end">
                              <button class="btn btn-sm  btn-primary btn-addaccion" data-idproducto="{{$key->CDPRODUCTO}}" data-bs-toggle="modal" data-bs-target="#addAccionModal" type="button">
                                <i class="fas fa-plus"></i> &nbsp;Agregar Productos
                              </button>
                              <button class="btn btn-sm  btn-danger btn-removeaccion"  data-idproducto="{{$key->CDPRODUCTO}}" type="button">
                                <i class="fas fa-trash"></i> &nbsp;Eliminar Productos
                              </button>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-hover" width="100%" style="font-size:10pt">
                              <thead>
                                <tr>
                                  <th>Código</th>
                                  <th>Influencer</th>
                                  <th>Información</th>
                                  <th>¿Canje?</th>
                                  <th>Precio</th>
                                  <th>Moneda</th>
                                  <th>Cantidad</th>
                                  <th>Total</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php $item=1; ?>
                                <?php foreach ($detalle as $key1): ?>
                                  <?php if ($key1->CDPRODUCTO==$key->CDPRODUCTO): ?>
                                    <tr data-id="{{$item}}">
                                      <td width="10%">{{$key1->CDCODIGO}}</td>
                                      <td width="15%">{{$key1->CDDESCRI}}</td>
                                      <td width="20%">
                                        <textarea name="" class="form-control" cols="5" style="font-size:8pt">{{$key1->CDGLOSA}}</textarea>
                                      </td>
                                      <td width="10%"><input type="checkbox" class="form-check-input" name="" value="" <?php echo ($key1->CDCANJE=='SI') ? 'checked' : '' ; ?>> </td>
                                      <td width="15%"><input type="number" class="form-control" style="font-size:9pt" name="" value="{{number_format($key1->CDPREUNIT,2,'.','')}}"></td>
                                      <td width="10%">
                                      <select class="form-control" name="" style="font-size:9pt">
                                        <option value="USD" <?php echo ($key1->CDMONEDA=='USD') ? 'selected' : '' ; ?>>USD</option>
                                        <option value="PEN" <?php echo ($key1->CDMONEDA=='PEN') ? 'selected' : '' ; ?>>PEN</option>
                                      </select>
                                      </td>
                                      <td width="10%"><input type="number" class="form-control" style="font-size:9pt" name="" value="{{number_format($key1->CDCANTID,2,'.','')}}"></td>
                                      <td width="10%">{{$key1->CDTOTVEN}}</td>
                                      <td style="display:none">{{$key1->CDREDSOCIAL}}</td>
                                      <td style="display:none">{{$key1->CDINPUT}}</td>
                                      <td>
                                        <button type="button" class="btn btn-danger btn-sm btn-eliminar-detalle" name="button"><i class="fa fa-trash"></i></button>
                                      </td>
                                    </tr>
                                    <?php $item++; ?>
                                  <?php endif; ?>
                                <?php endforeach; ?>
                              </tbody>
                            </table>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>
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
  <div class="modal-dialog" role="document">
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
<script type="text/javascript">

const sumarPrecios = () => {
  var valor_pen = 0;
  var valor_usd = 0;
  $('#divDetailCot').find('tbody').each(function() {
    item = $(this)
    item.find('tr').each(function() {
      tr = $(this)
      if (tr.find('td').eq(5).find('select').val()=='PEN') {
        valor_pen = valor_pen + parseFloat(tr.find('td').eq(7).html())
      }else if (tr.find('td').eq(5).find('select').val()=='USD') {
        valor_usd = valor_usd + parseFloat(tr.find('td').eq(7).html())
      }
    })
  });
  var fee = parseFloat(($('#divTotales input[name=fee]').val()=='')? 0 : $('#divTotales input[name=fee]').val())
  tipo_cambio = $('#CCTIPCAM').val()
  $('#divTotales input[name=subtotal_pen]').val(valor_pen.toFixed(2))
  $('#divTotales input[name=total_sinigv_pen]').val((valor_pen*(1+fee/100)).toFixed(2))
  $('#divTotales input[name=total_conigv_pen]').val((1.18*(valor_pen*(1+fee/100))).toFixed(2))

  $('#divTotales input[name=subtotal_usd]').val(valor_usd.toFixed(2))
  $('#divTotales input[name=total_sinigv_usd]').val((valor_usd*(1+fee/100)).toFixed(2))
  $('#divTotales input[name=total_conigv_usd]').val((1.18*(valor_usd*(1+fee/100))).toFixed(2))
  total_venta = ((1.18*(valor_usd*(1+fee/100)))*tipo_cambio + (1.18*(valor_pen*(1+fee/100)))).toFixed(2)
  $('#divTotales input[name=total_venta]').val(total_venta)
  if (total_venta>=700) {
      $('#divTotales input[name=retencion]').val((total_venta*0.88).toFixed(2))
      $('#divRetencion').html('<span class="text-danger" style="font-size:7pt">Aplica Retención</span>')
  }else {
      $('#divTotales input[name=retencion]').val((total_venta*1).toFixed(2))
      $('#divRetencion').html('')
  }

  if ($('#divTotales input[name=total_conigv_pen]').val()==0 && $('#divTotales input[name=total_conigv_usd]').val()==0) {
    $('#btnGuardar').attr('disabled','disabled')
  }else {
    $('#btnGuardar').attr('disabled',false)
  }
}

sumarPrecios()

$select =$('#CCCODCLI').selectize({
    maxItems: 1,
    valueField: 'CCODCLI',
    labelField: 'CNOMCLI',
    searchField: 'CNOMCLI',
    options: clientes,
    create: false
})
var selectize = $select[0].selectize;
selectize.setValue("{{$cabecera->CCCODCLI}}");

$select = $('#CCFORVEN').selectize()
var selectize = $select[0].selectize;
selectize.setValue("{{$cabecera->CCFORVEN}}");

$('.div_select').show()

$('.btn-addproducto').attr('disabled',false)
var productos = productos_cliente.filter(function (entry) {
  return entry.cliente === '{{$cabecera->CCCODCLI}}';
});
if (productos.length>0) {

} else {
  productos = JSON.parse('[{"id":"0","producto":"GENERAL"}]')
}
$('#CCPRODUCTO').selectize({
    valueField: 'id',
    labelField: 'producto',
    searchField: 'producto',
    options: productos,
    create: false
})


$(document).on('change','#CCCODCLI',function(){
  var valor = $(this).val()
  var selectized = $('#CCPRODUCTO').selectize();
  var control = selectized[0].selectize;
  control.destroy()
  if (valor=='') {
    $('.btn-addproducto').attr('disabled','disabled')
  }else {
    $('.btn-addproducto').attr('disabled',false)
    var productos = productos_cliente.filter(function (entry) {
      return entry.cliente === valor;
    });
    if (productos.length>0) {

    } else {
      productos = JSON.parse('[{"id":"0","producto":"GENERAL"}]')
    }
    $('#CCPRODUCTO').selectize({
        valueField: 'id',
        labelField: 'producto',
        searchField: 'producto',
        options: productos,
        create: false
    })
  }
})

$(document).on('click','.btn-addproducto',function(){
  $('#CCPRODUCTO').selectize()

})
$(document).on('submit','#formProductoSeleccionado',function(e){
  e.preventDefault()
  productos_elegidos = ($('#CCPRODUCTO').val());
  var productos = productos_cliente.filter(function (entry) {
    return productos_elegidos.includes(""+entry.id+"")==true
  });
  $('#productoModal').modal('hide')

  productos.forEach(element =>
    $('#divDetailCot').append(`
      <div class="card detailProduct" id="producto_${element.id}">
        <div class="card-header">
          <input type="hidden" name="idproducto" value"${element.id}">
          <label class="h2 text-dark">${element.producto}</label>
          <div class="float-end">
            <button class="btn btn-sm  btn-primary btn-addaccion" data-idproducto=${element.id} data-bs-toggle="modal" data-bs-target="#addAccionModal" type="button">
              <i class="fas fa-plus"></i> &nbsp;Agregar Productos
            </button>
            <button class="btn btn-sm  btn-danger btn-removeaccion"  data-idproducto=${element.id} type="button">
              <i class="fas fa-trash"></i> &nbsp;Eliminar Productos
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
          <table class="table table-hover" width="100%" style="font-size:10pt">
            <thead>
              <tr>
                <th>Código</th>
                <th>Influencer</th>
                <th>Información</th>
                <th>¿Canje?</th>
                <th>Precio</th>
                <th>Moneda</th>
                <th>Cantidad</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
          </div>
        </div>
      </div>
      `)
  );

})

$(document).on('click','.btn-addaccion',function(){
  $('#formAccionesAdd')[0].reset()
  $('#tipoAccionSeleccionada').addClass('d-none')
  $('#formAccionesAdd input[name=idproducto]').val($(this).data('idproducto'))
  $('#divAccionCont').html('');
  var selectized = $('#tipoAccionSeleccionada').selectize();
  var control = selectized[0].selectize;
  control.destroy()
})

$(document).on('change','#tipoAccion',function(){
  var valor = $(this).val()
  var descripcion = $(this).text()
  var selectized = $('#tipoAccionSeleccionada').selectize();
  var control = selectized[0].selectize;
  control.destroy()
  var acciones_elegidas = acciones.filter(function (entry) {
    return entry.tipo==valor
  });
  $('#divAccionCont').html('')
  // var $select = $('.tipoAccionSeleccionada');
  // var selectize = $select[0].selectize;
  // selectize.addOption({value:'', text: 'Seleccione'});
  // selectize.addItem('');
   // $('.tipoAccionSeleccionada').selectize.addOption({value:'', text: 'Seleccione'});
//   var $select = $(document.getElementById('mySelect')).selectize(options);
// var selectize = $select[0].selectize;
// selectize.addOption({value: 1, text: 'whatever'});
$('#tipoAccionSeleccionada').removeClass('d-none')

  $('#tipoAccionSeleccionada').selectize({
      valueField: 'codigo',
      labelField: 'descripcion',
      searchField: 'descripcion',
      options: acciones_elegidas,
      create: false
  })
})

$(document).on('change','#tipoAccionSeleccionada',function(){
  var valor = $(this).val()
  $.ajax({
    url : baseurl + "/mantenimiento/influencer/getInfoAccion",
    type: "GET",
    data: {valor},
    beforeSend:function(){
      $('#divAccionCont').html('<center><img  src="'+asset+'/img/loader.gif'+'"></center>')
    },
    success:function(data){
    if ($('#tipoAccion').val()==1) {
      $('#divAccionCont').html(`
        <table class='table table-hover' style="width:100%;font-size:10pt">
          <thead>
            <tr>
              <th>Red Social</th>
              <th>Descripción</th>
              <th>Valor</th>
              <th>Moneda</th>
              <th style="display:none">Moneda</th>
              <th>Seleccionar</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
        `)
        data = JSON.parse(data)
        paquete_descripcion = []
        moneda = []
        data.forEach(function(element) {
          element[0].metricas.forEach(function(red_social){
            if ((red_social.input).includes('tarifa_')===true) {
              if ((red_social.input).includes('_moneda')===true) {
                moneda.push(red_social)
              }
            }
          })
        });
        data.forEach(function(element) {
          element[0].metricas.forEach(function(red_social){
            if ((red_social.input).includes('tarifa_')===true) {
              if ((red_social.input).includes('_descripcion')===true) {
                paquete_descripcion.push(red_social)
              }
            }
          })
        });

        data.forEach(function(element) {

          element[0].metricas.forEach(function(red_social){
            if ((red_social.input).includes('tarifa_')===true) {
              if ((red_social.input).includes('_moneda')===false && (red_social.input).includes('_descripcion')===false) {
                redsocial = element[0].red_social;
                descripcion = red_social.input+''+(red_social.input=='tarifa_paquete' ? ` (${paquete_descripcion[0].valor})` : ``);
                valor = (red_social.valor=='') ? 0 : red_social.valor
                moneda_seleccionada=moneda.filter(function(entry) {
                  return (entry.input).includes(descripcion+'_')===true
                });
                moneda_tarifa = (moneda_seleccionada.length>0) ? (moneda_seleccionada[0].valor=='PEN') ? 'SOLES' : 'DOLARES' : 'SOLES'
                moneda_codigo = (moneda_seleccionada.length>0) ? moneda_seleccionada[0].valor : 'PEN'
                // console.log(element[0].red_social+' '+red_social.input+' '+red_social.value)
                $('#divAccionCont').find('tbody').append(`
                  <tr data-valor="${red_social.input}">
                    <td>${redsocial.replace("_", " ").toUpperCase()}</td>
                    <td>${descripcion.replace("_", " ").toUpperCase()}</td>
                    <td>${valor}</td>
                    <td>${moneda_tarifa}</td>
                    <td style="display:none">${moneda_codigo}</td>
                    <td><input type="checkbox" class="form-check-input"  value="${red_social.input}"></td>
                  </tr>
                  `)
              }
            }
            })
        });
        $('#divAccionCont').find('tbody').append(`
          <tr data-valor="otros">
            <td>OTROS</td>
            <td>OTROS</td>
            <td>0</td>
            <td>SOLES</td>
            <td style="display:none">PEN</td>
            <td><input type="checkbox" class="form-check-input"  value="otros"></td>
          </tr>
          `)
    } else {
      $('#divAccionCont').html(`
        <div class="row">
          <div class="col-md-6">
            <label for="">Información de Servicio</label>
            <input type="text" class="form-control" name="descripcion" value="">
          </div>
          <div class="col-md-3">
            <label for="">Tarifa</label>
            <input type="number" class="form-control" name="precio" value="">
          </div>
          <div class="col-md-3">
            <label for="">Tarifa</label>
            <select class="form-control" name="moneda">
              <option value="PEN">PEN</option>
              <option value="USD">USD</option>
            </select>
          </div>
        </div>
        `)
    }
    }
  })
})

$(document).on('click','#btnDetail',function(e){
  e.preventDefault();
  var tipo_accion = $('#tipoAccion').val()
  var accion_codigo = $('#tipoAccionSeleccionada').val()
  var idproducto = $('#formAccionesAdd input[name=idproducto]').val()
  var accion_descripcion = $('#tipoAccionSeleccionada').text()
  json_total=''
  if ($('#tipoAccion').val()==1) {
    var checkbox = $('#divAccionCont table input[type=checkbox]:checked');//Filas Seleccionadas
    console.log(checkbox)
      $.each(checkbox,function(){
        tr = $(this).parents('tr')
        json ='';
        json = json + '"red_social":"'+tr.find('td').eq(0).html()+'",'
                    + '"descripcion":"'+tr.find('td').eq(1).html()+'",'
                    + '"precio":"'+tr.find('td').eq(2).html()+'",'
                    + '"moneda":"'+tr.find('td').eq(4).html()+'"'
        obj=('{'+json+'}');
        json_total=json_total+','+(obj);
      });
      var array_json=JSON.parse('['+json_total.substr(1)+']');
  }else if ($('#tipoAccion').val()==2) {
    var descripcion = $('#formAccionesAdd input[name=descripcion]').val()
    var precio = $('#formAccionesAdd input[name=precio]').val()
    var moneda = $('#formAccionesAdd select[name=moneda]').val()
    json ='';
    json = json + '"red_social":"",'
                + '"descripcion":"'+descripcion+'",'
                + '"precio":"'+precio+'",'
                + '"moneda":"'+moneda+'"'
    obj=('{'+json+'}');
    json_total=json_total+','+(obj);
  var array_json=JSON.parse('['+json_total.substr(1)+']');
  }
  console.log(array_json)
  var tbody = $('#producto_'+idproducto).find('table').find('tbody')
  valor_tr = (tbody.find('tr:last').data('id')==undefined) ? 0 :tbody.find('tr:last').data('id')
  array_json.forEach((item, i) => {
    tbody.append(`
      <tr data-id="${valor_tr+1}">
        <td width="10%">${accion_codigo}</td>
        <td width="15%">${accion_descripcion}</td>
        <td width="20%">
          <textarea name="" class="form-control" cols="5" style="font-size:8pt">${(item.red_social.trim()!='')?'\n':''}  ${item.descripcion}</textarea>
        </td>
        <td width="10%"><input type="checkbox" class="form-check-input" name="" value=""> </td>
        <td width="15%"><input type="number" class="form-control" style="font-size:9pt" name="" value="${item.precio}"></td>
        <td width="10%">
        <select class="form-control" name="" style="font-size:9pt">
          <option value="USD">USD</option>
          <option value="PEN">PEN</option>
        </select>
        </td>
        <td width="10%"><input type="number" class="form-control" style="font-size:9pt" name="" value="1"></td>
        <td width="10%">${item.precio}</td>
        <td style="display:none">${item.red_social.replace(" ","_").toLowerCase()}</td>
        <td style="display:none">${item.descripcion.replace(" ","_").toLowerCase()}</td>
        <td>
          <button type="button" class="btn btn-danger btn-sm btn-eliminar-detalle" name="button"><i class="fa fa-trash"></i></button>
        </td>
      </tr>
      `)
    tbody.find('tr[data-id='+(valor_tr+1)+']').find('select').val(item.moneda)
  });
  sumarPrecios()
})

$(document).on('click','.btn-eliminar-detalle',function(){
  $(this).parents('tr').remove()
})
$(document).on('click','.btn-removeaccion',function(){
  console.log("eliminar")
  var producto = $(this).data('idproducto')
  var card = $(this).parents('#producto_'+producto)
  var tr = card.find('table').find('tbody').find('tr')
  console.log(tr.length);
  if (tr.length>0) {
    swal({
        title: `Eliminar Producto`,
        text: "La información del detalle se borrará definitivamente ¿Está seguro de eliminar los registros del producto?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "Si, estoy seguro",
        cancelButtonText:"Cerrar",
        closeOnConfirm: true
      },
      function(){
        card.remove()
      });
  }else {
    card.remove()
  }
  sumarPrecios()
})

$('#divTotales').hover(function(){
    $(this).addClass("opacity-100");
    $(this).removeClass("opacity-75");
    }, function(){
    $(this).addClass("opacity-75");
    $(this).removeClass("opacity-100");
  })

  $(document).on('change','.detailProduct input,select',function(){
    var tr = $(this).parents('tr');

    precio_unit  = tr.find('td').eq(4).find('input').val()
    moneda  = tr.find('td').eq(5).find('select').val()
    cant  = tr.find('td').eq(6).find('input').val()

    subtotal = parseFloat(precio_unit)*parseFloat(cant)
    //subtotal
     tr.find('td').eq(7).html(subtotal)
     sumarPrecios()
  })
  $(document).on('change','input[type=number]',function(){
    if ($(this).val()<0) {
      $(this).val(0)
    }
  })
  $(document).on('change','#divTotales input[name=fee]',function(){
     sumarPrecios()
  })
  $(document).on('change','#CCTIPCAM',function(){
     sumarPrecios()
  })



  $(document).on('click','.btnMetricasInfluencer',function(){
  $.ajax({
    url: baseurl + '/procesos/cotizacion/getMetrica',
    type: 'get',
    data: {influencer:$('#tipoAccionSeleccionada').val()},
    beforeSend: function(){
      $('#divMetricas').html('<center><img  src="'+asset+'/img/loader.gif'+'"></center>')
    },
    success: function(data){
      $('#MetricasInfluencerModal').modal('show')
      $('#divMetricas').html(data)
    }
  })
  })
</script>
