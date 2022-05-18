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
            url:baseurl+'/mantenimiento/accion/',
            type:'GET',
        },
        columns:[
          {data:'codigo'},
          {data:'descripcion'},
          {data:null,render:function(data){
            if (data.tipo==1) {
              return `
                INFLUENCER
              `;
            } else {
              return `
                SERVICIO
              `;
            }
          }},
          {data:null,render:function(data){
            if (data.estado==1) {
              return `
                  <span class="badge bg-primary">Activo</span>
              `;
            } else {
              return `
                  <span class="badge bg-danger">Inactivo</span>
              `;
            }
          }},
          {data:null,render:function(data){
            return `<button type="button" class="btn btn-primary btn-sm btn-editar" name="button" data-id="${data.id}"><i class="fa fa-edit"></i> </button>
              <button type="button" class="btn btn-danger btn-sm btn-eliminar" name="button" data-id="${data.id}"><i class="fa fa-trash"></i> </button>`
          }},
        ]
    });
}

loadData();

$(document).on('click','.btnAgregar',function(){
  $('.modal-title').html('Agregar Servicio/Influencer')
  $('#formMantto')[0].reset();
  $('.alertAccionTipo').html('')
  $('#formMantto input[name=codigo]').attr('readonly',false)
})

$(document).on('submit','#formMantto',function(e){
  e.preventDefault()
  const form = $(this)
  $.ajax({
    url: baseurl + '/mantenimiento/accion/store',
    type: 'POST',
    data: form.serialize(),
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
$(document).on('change','#formMantto select[name=tipo]',function(){
  const valor = $(this).val()
  if (valor == 1) {
    $('.alertAccionTipo').html(`
      <div class="alert alert-warning" role="alert">
          Las métricas y datos específicos de los influences se guardarán en el formulario Influencer, primero guarde la información.
      </div>
      `)
  }else {
    $('.alertAccionTipo').html('')
  }
})
$(document).on('click','.btn-editar',function(e){
  e.preventDefault()
  const id = $(this).data('id')
  $('.modal-title').html('Editar Servicio/Influencer');
  $('#formMantto input[name=id]').val(id)
  $('#formMantto input[name=codigo]').attr('readonly','readonly')
  $.ajax({
    url: baseurl + '/mantenimiento/accion/edit',
    type: 'get',
    data: {id:id},
    success: function(data){
      console.log(data.error)
      $('#Modal').modal('show')
      $('#formMantto input[name=codigo]').val(data.codigo)
      $('#formMantto input[name=descripcion]').val(data.descripcion)
      $('#formMantto select[name=tipo]').val(data.tipo)
      if (data.tipo == 1) {
        $('.alertAccionTipo').html(`
          <div class="alert alert-warning" role="alert">
              Las métricas y datos específicos de los influences se guardarán en el formulario Influencer, primero guarde la información.
          </div>
          `)
      }else {
        $('.alertAccionTipo').html('')
      }
      $('#formMantto select[name=estado]').val(data.estado)
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
