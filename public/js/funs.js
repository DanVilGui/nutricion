

function mostrarRespuesta(data){
    if(data){
        if(data.success) toastr.success(data.message)   ;
        else toastr.error(data.message)    ;
    }

}

function validarEnteros(evt) {
    var e = evt || window.event;
    var key = e.keyCode || e.which;

    if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
    // numbers   
    key >= 48 && key <= 57 ||
    // Numeric keypad
    key >= 96 && key <= 105 ||
    // Backspace and Tab and Enter
    key == 8 || key == 9 || key == 13 ||
    // Home and End
    key == 35 || key == 36 ||
    // left and right arrows
    key == 37 || key == 39 ||
    // Del and Ins
    key == 46 || key == 45) {
        // input is VALID
    }
    else {
        e.returnValue = false;
        if (e.preventDefault) e.preventDefault();
    }   
}

function fechaActualCampos(){
    var date = new Date();

    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();

    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;

    var today = year + "-" + month + "-" + day;       
    $(".fecha_actual").val(today);
}

function btnTableEditar(){
    return '<button type="button"  class="btn btn-info btn-sm btn-rounded  btnEditar">Editar</button>';
}
function btnTableImage(image){
    if(image == null) return "";
    return '<button type="button"  class="btn btn-sm btn-rounded btnImagen">' +
        '<img style="padding: 3px; height: 70px" src="'+ruta_imagenes+ 'posts/'+ image +'" /></button>';
}

function btnTableVer(){
    return '<button type="button"  class="btn btn-success btn-sm btn-rounded  btnVer" ><i class="mdi mdi-eye"></i></button>';
}
function btnTableBorrar(){
    return ' <button type="button" class="btn btn-danger btn-sm btn-rounded  btnEliminar" >Borrar</button>';
}


function mostrarConfirmDialog(title = 'Está Seguro ?', text ='No será posible revertir este cambio!', icon ='warning'){
    return Swal.fire({
        title: title,
        text: text,
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No',
    });

}