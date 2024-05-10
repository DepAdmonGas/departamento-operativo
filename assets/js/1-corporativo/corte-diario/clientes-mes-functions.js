function ReporteClientes(IdReporte) {
    $('#DivReporteClientes').load('../../app/vistas/personal-general/1-corporativo/corte-diario/reporte-clientes-mes.php?IdReporte=' + IdReporte);
    //$('#DivReporteClientes').load('../../public/corte-diario/vistas/reporte-clientes-mes.php?IdReporte=' + IdReporte);
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
function Finalizar(IdReporte) {
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
            ReporteClientes(IdReporte);

        }
    });
}