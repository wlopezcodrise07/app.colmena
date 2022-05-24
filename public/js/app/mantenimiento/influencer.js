function loadData(){
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
            url:baseurl+'/mantenimiento/influencer/',
            type:'GET',
        },
        columns:[
          {data:'influencer_descripcion'},
          {data:'representacion'},
          {data:'celular'},
          {data:'correo'},
          {data:null,render:function(data){
            string = '';

            if (data.categorias!=null) {
              categoriesSelecteds = data.categorias.split(',');
              if (categoriesSelecteds.length>0) {
                categoriesSelecteds.forEach(element => string = string + (categoriasArray.filter(word => word.id==element)[0].descripcion)  + ',');
              }

            }
            return string;
          }},
          {data:'usuario'},
          {data:null,render:function(data){
            return `
            <button type="button" class="btn btn-info btn-sm btn-editar" name="button" data-id="${data.influencer_codigo}">datos</button>
            <button type="button" class="btn btn-dark btn-sm btn-metricas" name="button" data-id="${data.influencer_codigo}">metricas</button>
              `
          }},
        ]

    });
}

loadData();


$(document).on('submit','#formMantto',function(e){
  e.preventDefault()
  const form = $(this)
  var checkbox = $('#formMantto input[type=checkbox]:checked');//Filas Seleccionadas
  var categorias = [];//Array que contendrá los elementos

    $.each(checkbox,function(index,rowId){
      categorias.push(rowId.value);
    });
  $.ajax({
    url: baseurl + '/mantenimiento/influencer/store',
    type: 'POST',
    data: form.serialize()+'&categorias='+categorias,
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
      loadData()
      $('#Modal').modal('hide')
    }
    }
  })
})
$(document).on('click','.btn-editar',function(e){
  e.preventDefault()
  const id = $(this).data('id')
  $('.modal-title').html('Actualizar Datos');
  $('#formMantto input[name=influencer]').val(id)
  $('#formMantto input[name=influencer_descripcion]').attr('readonly','readonly')
  $.ajax({
    url: baseurl + '/mantenimiento/influencer/edit',
    type: 'get',
    data: {id:id},
    success: function(data){
      console.log(data.error)
      $('#Modal').modal('show')
      $('#formMantto input[name=influencer]').val(data.influencer_codigo)
      $('#formMantto input[name=influencer_descripcion]').val(data.influencer_descripcion)
      $('#formMantto input[name=representacion]').val(data.representacion)
      $('#formMantto input[name=correo]').val(data.correo)
      $('#formMantto input[name=celular]').val(data.celular)
      categoriesSelecteds = data.categorias.split(',');
      if (categoriesSelecteds.length>0) {
        categoriesSelecteds.forEach(element => $('#categoria'+element).prop("checked",true));
      }
    }
  })
})
$(document).on('click','.btn-metricas',function(e){
  e.preventDefault()
  const id = $(this).data('id')
  $('.modal-title').html('Métricas del Influencer');
  $('#formMetricas input[name=influencer]').val(id)
  $.ajax({
    url: baseurl + '/mantenimiento/influencer/editMetrica',
    type: 'get',
    data: {id:id},
    success: function(data){
      console.log(data.error)
      $('#MetricasModal').modal('show')
      $('#divMetricas').html(data)
    }
  })
})
$(document).on('click','.btn-eliminar',function(e){
  e.preventDefault()
  const id = $(this).data('id')
  swal({
      title: `Desactivar Registro`,
      text: "¿Está Seguro de desactivar el registro?",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Si, estoy seguro",
      cancelButtonText:"Cerrar",
      closeOnConfirm: false
    },
    function(){
      $.ajax({
        url:baseurl+'/mantenimiento/accion/destroy',
        type:'GET',
        data:{
          'id':id
        },
        dataType:'JSON',
        beforeSend:function(){
          swal({
            title: "Cargando",
            imageUrl: asset + "/img/loader.gif",
            text:  "Espere un Momento,no cierre la ventana.",
            showConfirmButton: false
          });
        },
        success:function(data){
          console.log(data.error)
          swal({
              title: data.title,
              type:  data.type,
              text:  data.text,
              timer: 2000,
              showConfirmButton: false
          });
          if (data.type=='success') {
            loadData()
          }
        }
      });
    });
  })
  function ArrayAvg(myArray) {
      var i = 0, summ = 0, ArrayLen = myArray.length;
      while (i < ArrayLen) {
          summ = summ + parseInt(myArray[i++]);
  }
      return summ / ArrayLen;
  }

  function actualizarMetrica(){
    $(".array_prom").each(function () {
      const div_pane = $(this).parents('.tab-pane')
      const valor = $(this).val();
      const name = $(this).attr('name');

      const array = valor.split(',')
      console.log(array.length)
      if (array.length>=7 && array.length<=14 ) {
        $(this).removeClass("border border-4 border-danger")
        prom = ArrayAvg(array);
        console.log(prom)

      let castigo = $('input[name=castigo_'+name+']').val();
          div_pane.find('input[name=prom_'+name+']').val((prom*castigo/100).toFixed(2))
          if ($('input[name=seguidores]').val()>0) {
            er = (prom*castigo/100)/$('input[name=seguidores]').val()
          }else {
            er = 0
          }

          div_pane.find('input[name=er_'+name+']').val((er*100).toFixed(2))
          if (er>=0.10) {
            div_pane.find('input[name=er_'+name+']').addClass("border border-4 border-success")
          }else {
            div_pane.find('input[name=er_'+name+']').addClass("border border-4 border-danger")
          }

      }else {
        $(this).addClass("border border-4 border-danger")
      }
    })
  }
  $(document).on('change','.array_prom,.seguidores,.castigo',function(){
    actualizarMetrica()
  })
  $(document).on('submit','#formMetricas',function(e){
    e.preventDefault()
    var items = [];
    form = $(this)
    $(".tab-pane").each(function(){
      json_total=''
      $(this).find('input').each(function(){
        json ='';
        json = json + '"input":"'+$(this).attr('name')+'",'+'"valor":"'+$(this).val()+'"'
        obj=('{'+json+'}');
        json_total=json_total+','+(obj);
      })
      $(this).find('select').each(function(){
        json ='';
        json = json + '"input":"'+$(this).attr('name')+'",'+'"valor":"'+$(this).val()+'"'
        obj=('{'+json+'}');
        json_total=json_total+','+(obj);
      })
      $(this).find('textarea').each(function(){
        json ='';
        json = json + '"input":"'+$(this).attr('name')+'",'+'"valor":"'+$(this).val()+'"'
        obj=('{'+json+'}');
        json_total=json_total+','+(obj);
      })
      var array_json=('['+json_total.substr(1)+']');

      array = '[{"red_social":"'+$(this).attr('id')+'","metricas":'+array_json+'}]';

      items = items+','+array
        //items.push(JSON.parse(array));

    })
    items = JSON.parse('['+items.substr(1)+']')
    $.ajax({
      url: baseurl + '/mantenimiento/influencer/storeMetrica',
      type: 'POST',
      data: form.serialize()+'&metricasArray='+JSON.stringify(items),
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
        loadData()
      }
      }
    })
  })
