
function editarModal(id){

  $.ajax({
    type: "POST",
    url: "web/buscarEvento.php",
    data: {'id': id},
    dataType: "json",
    success: function (data) {
      if(dataClientes.length>0) $.observable(dataClientes).remove(0,dataClientes.length); 
      var evento = data.evento;
      $('#tituloAgregarEvento').text('EDITAR EVENTO');
      $('#evento_idevento').val(evento.idevento);  
      $('#evento_local').val(evento.idlocal);
      $('#evento_nombre').val(evento.nombre);
      $('#evento_fecha').val(evento.fechai);
      $('#modalEvento').modal('show');

      $.each(data.clientes, function (ind,val){
        $.observable(dataClientes).insert(crearObjetoCliente(val.dni, val.nombre,val.telefono));
      });
      mostrarBtnClienteNuevo();
      actualizarPrincipalesClientes();
    
    }
  });
   
  
}

function agregarEvento(fecha  ='', local = ''){
  if(dataClientes.length>0) $.observable(dataClientes).remove(0,dataClientes.length); 
  $('#tituloAgregarEvento').text('AGREGAR EVENTO');
  $('#evento_idevento').val('-1');  
  $('#evento_nombre').val('');
  if(fecha == '') fechaActualCampos();
  else   $('#evento_fecha').val(fecha);
  if(local == '')   $('#evento_local').val(1);
  else   $('#evento_local').val(local);
  $('#modalEvento').modal('show');
  mostrarBtnClienteNuevo();
  actualizarPrincipalesClientes();

}
var calendarEl = document.getElementById('calendar');

var calendar = new FullCalendar.Calendar(calendarEl, {
  
  plugins: [ 'interaction','dayGrid' ],
  defaultView: 'dayGridMonth',
  locale: 'es',
  selectable: true,
  events: [
  ],
  eventClick: function(info) {
    editarModal(info.event.id);    
  },
  dateClick: function(info) {
    agregarEvento(info.dateStr);
  }
  });
calendar.render();
 
function buscarEventosCalendar(){

  var eventos = calendar.getEvents()
  
  calendar.batchRendering(function() {
    $(eventos).each(function(ind,event){
      event.remove();
    })
  });
  $.ajax({
    type: "GET",
    url: "web/listarEvento.php",
    dataType: "json",
    success: function (data) {
      calendar.batchRendering(function() {
        $(data).each(function(ind,evento){
          calendar.addEvent(evento);
        });
      });
      
    }
  });
}


$(function () {
  
  $('.fc-today-button').html('Hoy');
  buscarEventosCalendar();
  $('#formularioEvento').on('submit', function(e) {
    e.preventDefault(); // prevent native submit
    $(this).ajaxSubmit({
        dataType:  'json', 
        success: function(data){
            mostrarRespuesta(data);
            if(data.s){
              $('#modalEvento').modal('hide');
              buscarEventosCalendar();
            }
           
          }
          
    })
  });

  $('#formularioDisponibilidad').on('submit', function(e) {
    e.preventDefault(); // prevent native submit
    $(this).ajaxSubmit({
        dataType:  'json', 
        success: function(data){
          $('#tablaDisponibilidad').show();
           $('#tablaDisponibilidad tbody').html('');
           if(data.length>0){
             console.log(data);
             $(data).each(function(i, local){
              
               if(local.idevento == null){
                  var estLocal = '<button type="button" class="btn btn-primary btnDisponible" >DISPONIBLE</button>';
               }else{
                  var estLocal = '<button type="button" class="btn btn-danger" disabled>OCUPADO</button>                  ';
               }
               var tmplt =  '<tr idlocal='+ local.idlocal +'><th scope="row">'+(i+1)+'</th>'+
                            '<td>'+ local.local +'</td>'+
                            '<td>'+ estLocal +'</td>'+
                        '</tr>';
              $('#tablaDisponibilidad tbody').append(tmplt);
            
             })
           }
        }
          
    })
  });

    $('.enteros').keydown(function (e) { 
        return validarEnteros(e);
    });

    $('#btnAgregarEvento').click(function (e) { 
      e.preventDefault();
      agregarEvento();
    });

    $('#btnVerificarEvento').click(function (e) { 
      e.preventDefault();
      fechaActualCampos();
      $('#tablaDisponibilidad').hide();
      $('#modalDisponibilidad').modal('show');
    });

    $('#disponibilidad_fecha').change(function(){
      $('#tablaDisponibilidad').hide();
    });

    $('#tablaDisponibilidad tbody')
    .on("click", ".btnDisponible", function () {
        var idlocal = $(this).parent().parent().attr('idlocal');
        var fecha =    $('#disponibilidad_fecha').val();
        $('#modalDisponibilidad').modal('hide');
        agregarEvento(fecha,idlocal);
    })
   
});
