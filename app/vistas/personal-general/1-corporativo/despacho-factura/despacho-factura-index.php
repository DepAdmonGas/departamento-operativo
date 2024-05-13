<?php
require ('app/vistas/contenido/header.php');
$breadcrumbYearMes = $ClassHomeCorporativo->tituloMenuCorporativoYearMes($Pagina, $Session_IDUsuarioBD, $session_idpuesto, $GET_year, $GET_mes);
?>
<style media="screen">
    .grayscale {
        filter: opacity(50%);
    }
</style>
<script type="text/javascript">
    $(document).ready(function ($) {
        $(".LoaderPage").fadeOut("slow");
        ListaDespachoFactura(<?= $GET_year; ?>, <?= $GET_mes; ?>);
    });
    function ListaDespachoFactura(year, mes) {
        $('#ListaDespachoFactura').load('../../app/vistas/personal-general/1-corporativo/despacho-factura/lista-despacho-factura-mes.php?Year=' + year + '&Mes=' + mes);
        //$('#ListaDespachoFactura').load('../../public/corte-diario/vistas/lista-despacho-factura-mes.php?Year=' + year + '&Mes=' + mes);
    }
    function Editar(e, idDias, Despacho) {
        var input = e.value;

        var Litros = $('#' + idDias + 'L' + Despacho).text();

        LitrosReplace = Litros.replace(/,/g, "");

        var TotalLitros = LitrosReplace - input;


        var parametros = {
            "idDias": idDias,
            "input": input,
            "Despacho": Despacho,
            "accion": "editar-despacho-factura"
        };

        $.ajax({
            data: parametros,
            //url: '../../public/corte-diario/modelo/editar-despacho-factura.php',
            url: '../../app/controlador/1-corporativo/controladorDespacho.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {
                console.log(response)
                $('#' + idDias + 'LC' + Despacho).text(TotalLitros)

            }
        });
    }
    function menuCorporativoYearMes(referencia) {
        window.location.href = "../../" + referencia;
    }
    function returnCorporativoItem(referencia) {
        window.location.href = "../../" + referencia;
    }
</script>
<body>
    <div class="LoaderPage"></div>
    <!---------- DIV - CONTENIDO ---------->
    <div id="content">
        <!---------- NAV BAR - PRINCIPAL (TOP) ---------->
        <?php include_once "public/navbar/navbar-perfil.php"; ?>
        <!---------- CONTENIDO PAGINA WEB---------->
        <div class="contendAG">
            <div class="row">
                <div class="col-12">
                    <?= $breadcrumbYearMes ?>
                </div>
                <div class="col-12">
                    <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Despacho VS
                        Factura, <?= nombreMes($GET_mes) ?> <?= $GET_year ?></h3>
                    <hr>
                    <div class="col-12" id="ListaDespachoFactura"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>