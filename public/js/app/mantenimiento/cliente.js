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
            url:baseurl+'/mantenimiento/clientes/',
            type:'GET',
        },
        columns:[
          {data:'CCODCLI'},
          {data:'CNOMCLI'},
          {data:'CDIRCLI'},
          {data:'CTELEFO'},
          {data:'CNUMRUC'},
          {data:null,render:function(data){
            return (data.DIRINSTAGRAM) ? `<center><a href="${data.DIRINSTAGRAM}" target="_blank"><span class="badge bg-pink" >IG</span> </a></center>` : '';
          }},
          {data:null,render:function(data){
            return (data.DIRTIKTOK) ? `<center><a href="${data.DIRTIKTOK}" target="_blank"><span class="badge bg-dark" >TT</span> </a></center>` : '';
          }},
          {data:null,render:function(data){
            return (data.DIRTWITTER) ? `<center><a href="${data.DIRTWITTER}" target="_blank"><span class="badge bg-cyan" >TW</span> </a></center>` : '';
          }},
          {data:null,render:function(data){
            return (data.DIRFB) ? `<center><a href="${data.DIRFB}" target="_blank"><span class="badge bg-primary">FB</span> </a></center>` : '';
          }},
          {data:null,render:function(data){
            if (data.active==1) {
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
              <button type="button" class="btn btn-danger btn-sm btn-eliminar" name="button" data-id="${data.id}"><i class="fa fa-trash"></i> </button>`
          }},
        ]

    });
}

loadData();

$(document).on('click','.btnAgregarCliente',function(){
  $('.modal-title').html('Agregar Cliente')
  $('#formCliente input[name=codigo]').attr('readonly',false)
  $('#formCliente')[0].reset();

})

$(document).on('submit','#formCliente',function(e){
  e.preventDefault()
  const form = $(this)
  $.ajax({
    url: baseurl + '/mantenimiento/clientes/store',
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
      $('#clienteModal').modal('hide')
    }
    }
  })
})
$(document).on('click','.btn-editar',function(e){
  e.preventDefault()
  const id = $(this).data('id')
  $('.modal-title').html('Editar Cliente');
  $('#formCliente input[name=id]').val(id)
  $('#formCliente input[name=codigo]').attr('readonly','readonly')
  $.ajax({
    url: baseurl + '/mantenimiento/clientes/edit',
    type: 'get',
    data: {id:id},
    success: function(data){
      console.log(data.error)
      $('#clienteModal').modal('show')
      $('#formCliente input[name=id]').val(data.id)
      $('#formCliente input[name=CCODCLI]').val(data.CCODCLI)
      $('#formCliente input[name=CNOMCLI]').val(data.CNOMCLI)
      $('#formCliente input[name=CNUMRUC]').val(data.CNUMRUC)
      $('#formCliente input[name=CDIRCLI]').val(data.CDIRCLI)
      $('#formCliente input[name=CTELEFO]').val(data.CTELEFO)
      $('#formCliente input[name=DIRFB]').val(data.DIRFB)
      $('#formCliente input[name=DIRTWITTER]').val(data.DIRTWITTER)
      $('#formCliente input[name=DIRINSTAGRAM]').val(data.DIRINSTAGRAM)
      $('#formCliente input[name=DIRTIKTOK]').val(data.DIRTIKTOK)
      $('#formCliente select[name=active]').val(data.active)

    }
  })
})
$(document).on('click','.btn-eliminar',function(e){
  e.preventDefault()
  const id = $(this).data('id')
  swal({
      title: `Desactivar Registro`,
      text: "Se mantendrá el registro del cliente, pero no podrá ser usado en las operaciones del aplicativo ¿Está Seguro de desactivar el registro?",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "Si, estoy seguro",
      cancelButtonText:"Cerrar",
      closeOnConfirm: false
    },
    function(){
      $.ajax({
        url:baseurl+'/mantenimiento/clientes/destroy',
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
