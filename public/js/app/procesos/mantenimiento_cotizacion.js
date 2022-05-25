function loadData(periodo){
    $('#consulta').DataTable({

        language:{
         url: asset + "/js/spanish.json"
        },
        order:[[0,'desc']],
        destroy:true,
        bAutoWidth: false,
        deferRender:true,
        bProcessing: true,
        stateSave:true,
        iDisplayLength: 10,
        ajax:{
            url:baseurl+'/procesos/cotizacion/versionar',
            type:'GET',
            data:{periodo:periodo}
        },
        columns:[
          {data:null,render:function(data){
            return (""+data.CCNUMDOC).padStart(7, "0");
          }},
          {data:'CCFECDOC'},
          {data:'CCNOMBRE'},
          {data:'CCIMPORTEVTA'},
          {data:'usuario'},
          {data:null,render:function(data){
            if (data.CCESTADO==0) {
              return `
                  <span class="badge bg-primary">EMITIDO</span>
              `;
            }else if (data.CCESTADO==1) {
              return `
                  <span class="badge bg-success">PROGRAMADO</span>
              `;
            }else if (data.CCESTADO==2) {
              return `
                  <span class="badge bg-danger">CANCELADO</span>
              `;
            }
          }},
          {data:null,render:function(data){
            return `<center><button type="button" class="btn btn-dark btn-sm btn-get" name="button" data-CCVERSION="${data.CCVERSION}" data-CCNUMDOC="${data.CCNUMDOC}" data-bs-toggle="tooltip" data-bs-placement="top" title="Programar Cotización"><i class="fa fa-calendar"></i></button>
              <button type="button" class="btn btn-primary btn-sm btn-edit" name="button" data-CCVERSION="${data.CCVERSION}" data-CCNUMDOC="${data.CCNUMDOC}" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar Cotización"><i class="fa fa-edit"></i></button>
              <button type="button" class="btn btn-danger btn-sm btn-delete" name="button" data-CCVERSION="${data.CCVERSION}" data-CCNUMDOC="${data.CCNUMDOC}" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancelar Cotización"><i class="fa fa-trash"></i></button></center>`
          }},
        ]
    });
}

loadData(periodo_elegido);

$(document).on('change','#periodo',function(){
  loadData($(this).val())
})
$(document).on('click','.btn-edit',function(){
  var version = $(this).data('ccversion')
  var numero = $(this).data('ccnumdoc')
  console.log(version)
  console.log(numero)
  $.ajax({
    url: baseurl + '/procesos/cotizacion/edit',
    type: 'GET',
    data: {version:version,numero:numero},
    beforeSend: function(){
      $('#divCotizacionConsultar').fadeOut(1000)
      $('#divCotizacionEditar').html('<center><img  src="'+asset+'/img/loader.gif'+'"><h2>Cargando...<h2></center>')
    },
    success: function(data){
      $('#divCotizacionEditar').fadeIn(1000)
      $('#divCotizacionEditar').html(data)
    }
  })
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
    url: baseurl + '/procesos/cotizacion/update',
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
$(document).on('click','.btn-atras',function(){
  $('#divCotizacionConsultar').fadeIn(1000)
  $('#divCotizacionEditar').fadeOut(1000)
  $('#consulta').DataTable().ajax.reload();
})
