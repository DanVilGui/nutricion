$(function () {
    $('#formularioInvitados').on('submit', function(e) {
        e.preventDefault(); // prevent native submit
        $(this).ajaxSubmit({
            dataType:  'json', 
            success: function(data){
                mostrarRespuesta(data);
              }
              
        })
      });
    
});