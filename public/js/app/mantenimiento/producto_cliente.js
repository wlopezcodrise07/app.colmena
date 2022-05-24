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
            url:baseurl+'/mantenimiento/producto_cliente/',
            type:'GET',
        },
        columns:[
          {data:'producto'},
          {data:'CNOMCLI'},
          {data:'contacto'},
          {data:'usuario'},
          {data:null,render:function(data){
            if (data.estado==1) {
              return `
                  <span class="badge bg-primary">Activado</span>
              `;
            } else {
              return `
                  <span class="badge bg-danger">Desactivado</span>
              `;
            }
          }},
          {data:null,render:function(data){
            return `<button type="button" class="btn btn-primary btn-sm btn-editar" name="button" data-id="${data.id}"><i class="fa fa-edit"></i> </button>
              <button type="button" class="btn btn-dark btn-sm btn-cronograma d-none" name="button" data-id="${data.id}" data-descripcion="${data.producto}"><i class="fas fa-calendar-alt"></i> </button>
              <button type="button" class="btn btn-danger btn-sm btn-eliminar" name="button" data-id="${data.id}"><i class="fa fa-trash"></i> </button>`
          }},
        ]

    });
}

loadData();

$(document).on('click','.btnAgregarCliente',function(){
  $('#formProductoCliente')[0].reset();
  $('.modal-title').html('Agregar Producto del Cliente')
})

$(document).on('submit','#formProductoCliente',function(e){
  e.preventDefault()
  const form = $(this)
  $.ajax({
    url: baseurl + '/mantenimiento/producto_cliente/store',
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
      $('#ProductoClienteModal').modal('hide')
    }
    }
  })
})
$(document).on('click','.btn-editar',function(e){
  e.preventDefault()
  const id = $(this).data('id')
  $('.modal-title').html('Editar Producto del Cliente');
  $('#formProductoCliente input[name=id]').val(id)
  $.ajax({
    url: baseurl + '/mantenimiento/producto_cliente/edit',
    type: 'get',
    data: {id:id},
    success: function(data){
      console.log(data.error)
      $('#ProductoClienteModal').modal('show')
      $('#formProductoCliente input[name=producto]').val(data.producto)
      $('#formProductoCliente input[name=contacto]').val(data.contacto)
      $('#formProductoCliente select[name=cliente]').val(data.cliente)
      $('#formProductoCliente select[name=estado]').val(data.estado)
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
        url:baseurl+'/mantenimiento/producto_cliente/destroy',
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

  function loadCampaña(producto){
      $('#tableCampaña').DataTable({
        language:{
         url: asset + "/js/spanish.json"
        },
        destroy:true,
        bAutoWidth: false,
        deferRender:true,
        bProcessing: true,
        stateSave:true,
        iDisplayLength: 10,
        ajax:{
            url:baseurl+'/mantenimiento/producto_cliente/get_campana/'+producto,
            type:'GET',
        },
        columns:[
          {data:'periodo'},
          {data:null,render:function(data){
            if (data.condicion==2) {
              return `
                  <span class="badge bg-success">Proximo</span>
              `;
            }else if(data.condicion==1) {
              return `
                  <span class="badge bg-warning">Por Vencer</span>
              `;
            }else if(data.condicion==0) {
              return `
                  <span class="badge bg-danger">Vencido</span>
              `;
            }
          }},
          {data:null,render:function(data){
            return `<button type="button" class="btn btn-danger btn-sm btn-eliminar-campaña" name="button" data-id="${data.id}"><i class="fa fa-trash"></i> </button>`
          }},
        ]
      });
    }

    $(document).on('click','.btn-cronograma',function(e){
      e.preventDefault()
      const id = $(this).data('id')
      const producto = $(this).data('descripcion')
      $("#ProductoCalendarioModal").modal("show")
      $('.modal-title').html('Campañas - Producto : '+producto);
      $('#formProductoCalendario input[name=id]').val(id)
      loadCampaña(id)
    })

    $(document).on('submit','#formProductoCalendario',function(e){
      e.preventDefault()
      const form = $(this)
      $.ajax({
        url: baseurl + '/mantenimiento/producto_cliente/storeCampaña',
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
          $('#tableCampaña').DataTable().ajax.reload();
        }
        }
      })
    })
    $(document).on('click','.btn-eliminar-campaña',function(e){
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
            url:baseurl+'/mantenimiento/producto_cliente/destroyCampaña',
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
                $('#tableCampaña').DataTable().ajax.reload();
              }
            }
          });
        });
      })
