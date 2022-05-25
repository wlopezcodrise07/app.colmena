
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
$('#CCCODCLI').selectize({
    maxItems: 1,
    valueField: 'CCODCLI',
    labelField: 'CNOMCLI',
    searchField: 'CNOMCLI',
    options: clientes,
    create: false
})
$('#CCFORVEN').selectize()
$('.div_select').show()
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
      $('#divAccionCont').html('<center><img  src="'+asset+'/img/loader.gif'+'" width="60%"></center>')
    },
    success:function(data){
    if ($('#tipoAccion').val()==1) {
      $('#divAccionCont').html(`
        <div class="row">
          <div class="col-md-12">
            <div class="float-end">
              <input type="hidden" name="" value="${data}">
              <button class="btn btn-sm  btn-outline-info btnMetricasInfluencer"  type="button">
                <i class="fas fa-tachometer-alt"></i> &nbsp;Metricas
              </button>
            </div>
          </div>
        </div><br>
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
  $(document).on('click','.btn-eliminar-detalle',function(){
    $(this).parents('tr').remove()
  })
  $(document).on('submit','#formCotizacion',function(e){
    e.preventDefault()
    var form = $(this)
    var detalle = []
    $('#divDetailCot').find('tbody').each(function() {
      item = $(this)
      producto_cliente = item.parents('.detailProduct').find('input[name=idproducto]').val()

      item.find('tr').each(function() {
        tr = $(this)
        var canje = (tr.find('td').eq(3).find('input').is(':checked'))? 'SI' : 'NO'
        var fila = {
          producto_cliente:producto_cliente,
          codigo : tr.find('td').eq(0).html(),
          descripcion : tr.find('td').eq(1).html(),
          glosa : tr.find('td').eq(2).find('textarea').val(),
          canje: canje,
          precio : tr.find('td').eq(4).find('input').val(),
          moneda : tr.find('td').eq(5).find('select').val(),
          cantidad : tr.find('td').eq(6).find('input').val(),
          total : tr.find('td').eq(7).html(),
          red_social : tr.find('td').eq(8).html(),
          input : tr.find('td').eq(9).html(),
        }
        detalle.push(fila);
      })
    });
    console.log(JSON.stringify(detalle))

    $.ajax({
      url: baseurl + '/procesos/cotizacion/create',
      type: 'POST',
      data: form.serialize()+'&detalle='+JSON.stringify(detalle),
      beforeSend: function(){
        swal({
          title: "Cargando",
          imageUrl: asset + "/img/loader.gif",
          text:  "Espere un Momento,no cierre la ventana.",
          showConfirmButton: false
        });
      },
      success: function(data){
        console.log(data.error)

        swal({
          title: data.title,
          type:  data.type,
          text:  data.text,
          timer: 2000,
          showConfirmButton: false
      });
      if (data.type=='success') {
        setTimeout(function(){
          location.reload();
        }, 2000);
      }

      }
    })
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
