var modalTrigger = null;

 function init(){
    $("#producto_form").on("submit",function(e){
        guardaryeditar(e);
    });
 }
 init();

$(document).ready(function(){

    tabla = $('#producto_data').dataTable({

        "aProcessing": true, // Activamos el procesamiento de datatables
        "aServerSide": true, // Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', // Definimos los elementos del control de tabla

        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],

        "ajax": {
            url: '../../controller/producto.php?op=listar',
            type: "get",
            dataType: "json",
            error: function(e){
                console.log(e.responseText);
            }
        },

        "bDestroy": true,
        "responsive": true,
        "bInfo": true,
        "iDisplayLength": 10, //Por cada 10 registros hace una paginación

        "order": [[ 0, "asc" ]],

        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando un total de 0 registros",
            "sInfoFiltered": "(Filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }

    }).DataTable();

});

function guardaryeditar(e){
    e.preventDefault();
    var formData = new FormData($("#producto_form")[0]);
    $.ajax({
        url: "../../controller/producto.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(response){
            if (!response.success) {
                window.alert(response.message || "No se pudo guardar el producto.");
                return;
            }
            $('#producto_form')[0].reset();
            $("#modalmantenimiento").modal('hide');
            $('#producto_data').DataTable().ajax.reload();
        },
        error: function(xhr){
            var message = xhr.responseJSON && xhr.responseJSON.message;
            window.alert(message || "No se pudo guardar el producto. Verifica los datos e inténtalo de nuevo.");
        }
    });
}

$(document).on("click", "#btnNuevo", function(){
    modalTrigger = this;
    $("#producto_form")[0].reset();
    $("#modalmantenimiento").modal("show");
})

$("#modalmantenimiento").on("hide.bs.modal", function(){
    if (this.contains(document.activeElement)) {
        document.activeElement.blur();
    }
}).on("hidden.bs.modal", function(){
    if (modalTrigger && document.contains(modalTrigger)) {
        modalTrigger.focus();
    }
});

function eliminar(prod_id){
    alert("FUNCION ELIMINAR ID: "+prod_id)
    $.post("../../controller/producto.php?op=eliminar", {prod_id:prod_id}, function(data){

    })

}
