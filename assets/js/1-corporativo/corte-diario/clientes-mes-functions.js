function ReporteClientes(IdReporte, ruta_js) {
    $('#DivReporteClientes').load('../../app/vistas/personal-general/1-corporativo/corte-diario/clientes/reporte-clientes-mes.php?IdReporte=' + IdReporte, function () {
        function initializeDataTable(tableId) {
            // Clonar y remover las filas antes de inicializar DataTables
            var $lastRows = $('#' + tableId + ' tr.ultima-fila').clone();
            $('#' + tableId + ' tr.ultima-fila').remove();
    
            // Inicializar DataTables
            $('#' + tableId).DataTable({
                "stateSave": true,
                "language": {
                    "url": ruta_js + "/es-ES.json"
                },
                "order": [[0, "desc"]],
                "lengthMenu": [15, 30, 50, 100],
                "columnDefs": [
                    { "orderable": false,},
                    { "searchable": false,}
                ],
                "drawCallback": function(settings) {
                    // Remover cualquier fila 'ultima-fila' existente para evitar duplicados
                    $('#' + tableId + ' tr.ultima-fila').remove();
                    // Añadir las filas clonadas al final del tbody
                    $('#' + tableId + ' tbody').append($lastRows.clone());
                }
            });
    
            // Añadir las filas clonadas al final del tbody inicial
            $('#' + tableId + ' tbody').append($lastRows);
        }
        // Inicializar ambas tablas
        initializeDataTable('resumen-clientes-credito');
        initializeDataTable('resumen-clientes-debito');
        
    });

}


function ESICredito(id) {
    var total = $('#ESICredito' + id).val();
    var parametros = {
        "id": id,
        "total": total,
        "accion": "editar-saldo-inicial"
    };
    $.ajax({
        data: parametros,
        url: '../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url: '../../public/corte-diario/modelo/editar-saldo-inicial.php',
        type: 'post',
        beforeSend: function () { },
        complete: function () { },
        success: function (response) {
            $('#SaldoF' + id).text(response)
        }
    });
}
function Finalizar(IdReporte, ruta_js) {
    var parametros = {
        "IdReporte": IdReporte,
        "accion": "finaliza-resumen-cliente-mes"
    };
    $.ajax({
        data: parametros,
        url: '../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../public/corte-diario/modelo/finalizar-resumen-clientes-mes.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {
            if(response == 1){
                // Oculta el botonde finalizar
                document.getElementById('btnFinalizar').style.display = 'none';
                ReporteClientes(IdReporte, ruta_js);
                alertify.success('Clientes finalizado');
            }else{
                alertify.error('Error al finalizar cliente');
            }
            
        }
    });
}