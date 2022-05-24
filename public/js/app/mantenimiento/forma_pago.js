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
            url:baseurl+'/mantenimiento/forma_pago/',
            type:'GET',
        },
        columns:[
          {data:'id'},
          {data:'descripcion'},
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
          {data:'usuario'},
          {data:null,render:function(data){
            return         `<button type="button" class="btn btn-primary btn-sm btn-editar" name="button" data-id="${data.id}"><i class="fa fa-edit"></i> </button>
              <button type="button" class="btn btn-danger btn-sm btn-eliminar" name="button" data-id="${data.id}"><i class="fa fa-trash"></i> </button>`
          }},
        ]

    });
}

loadData();

$(document).on('click','.btnAgregar',function(){
  $('.modal-title').html('Agregar Forma de Pago')
  $('#formMantto')[0].reset();
})

$(document).on('submit','#formMantto',function(e){
  e.preventDefault()
  const form = $(this)
  $.ajax({
    url: baseurl + '/mantenimiento/forma_pago/store',
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

$(document).on('click','.btn-editar',function(e){
  e.preventDefault()
  const id = $(this).data('id')
  $('#formMantto')[0].reset();
  $('#formMantto input[name=id]').val(id)
  $('.modal-title').html('Editar Forma de Pago');
  $.ajax({
    url: baseurl + '/mantenimiento/forma_pago/edit',
    type: 'get',
    data: {id:id},
    success: function(data){
      console.log(data.error)
      $('#Modal').modal('show')
      $('#formMantto input[name=id]').val(data.id)
      $('#formMantto input[name=descripcion]').val(data.descripcion)
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
        url:baseurl+'/mantenimiento/forma_pago/destroy',
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
