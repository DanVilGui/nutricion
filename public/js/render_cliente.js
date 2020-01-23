var dataClientes = [];
var contenedorClientes = '#contClientes';
var btnClienteNuevo = '#btnAgregarClienteNuevo';


function mostrarBtnClienteNuevo(){
    if(dataClientes.length>0){
        $(btnClienteNuevo).hide(); $(contenedorClientes).show();
    }
    else{
        $(btnClienteNuevo).show();$(contenedorClientes).hide();
    }
}

function crearObjetoCliente(dni = '', nombre = '',telefono =''){
    return { 'dni': dni, 'nombre': nombre, 'telefono':telefono}
}


function actualizarPrincipalesClientes(){
    
    var rowsClientes =$(contenedorClientes+ ' .form-group-sm');
    var size = rowsClientes.length;
    $.each( rowsClientes, function (ind,row) {
        if(size==ind+1){
            $(row).find('.add').show();

        }else {
            $(row).find('.add').hide();

        }
    })
}


function validarClientes(){
   valid = true;
   $(contenedorClientes + '  .dni').each(function( index ) {
       valor = $(this).val().trim().length;
       if( valor === 0) {
            $(this).focus();
            return false;
       };
   });
   $(contenedorClientes + '  .nombre').each(function( index ) {
       valor = $(this).val().trim().length;
       if( valor === 0) {
           $(this).focus();
           return false;
       };
   });
   $(contenedorClientes + '  .telefono').each(function( index ) {
    valor = $(this).val().trim().length;
    if( valor === 0) {
        $(this).focus();
        return false;
    };
});
   return valid;
}

function agregarEventosClientes(){


    $(contenedorClientes)
        .on("click", ".add", function() {
          if(validarClientes()) {
                $.observable(dataClientes).insert(crearObjetoCliente());
                actualizarPrincipalesClientes();

          };
        })
        .on("click", ".del", function() {
            index = $.view(this).index;
            $.observable(dataClientes).remove(index);
            mostrarBtnClienteNuevo();
            actualizarPrincipalesClientes();
        })
       
    ;
}

function iniciarVistaClientes(){
    
    mostrarBtnClienteNuevo();
    $(btnClienteNuevo).click(function (e) { 
        e.preventDefault();
        $.observable(dataClientes).insert(crearObjetoCliente());
        mostrarBtnClienteNuevo();
        actualizarPrincipalesClientes();
    });
}



var templateClientes = $.templates("#tmplClientes");
templateClientes.link(contenedorClientes, dataClientes);

agregarEventosClientes();

$(function () {
    iniciarVistaClientes();
});

