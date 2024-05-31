<?php
require 'app/vistas/contenido/header.php';
function Estacion($idEstacion, $con): string
{
    $estacion = "";
    $sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = ? ";
    $stmt = $con->prepare($sql_listaestacion);
    $stmt->bind_param("i", $idEstacion);
    $stmt->execute();
    $stmt->bind_result($estacion);
    $stmt->fetch();
    $stmt->close();
    return $estacion;
}

function Personal($idPersonal, $con): string
{
    $nombre = "";
    $sql = "SELECT nombre FROM tb_usuarios WHERE id = ? ";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $idPersonal);
    $stmt->execute();
    $stmt->bind_result($nombre);
    $stmt->fetch();
    $stmt->close();
    return $nombre;
}

$sql_lista = "SELECT * FROM op_descarga_tuxpa WHERE id = '" . $GET_idReporte . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
    $id = $row_lista['id'];
    $folio = $row_lista['folio'];
    $Estacion = Estacion($row_lista['id_estacion'], $con);
    $fechallegada = FormatoFecha($row_lista['fecha_llegada']);
    $horallegada = date("g:i a", strtotime($row_lista['hora_llegada']));
    $Personal = Personal($row_lista['id_usuario'], $con);
    $producto = $row_lista['producto'];
    $sellos = $row_lista['sellos'];
    $detuvoventa = $row_lista['detuvo_venta'];
    $operador = $row_lista['operador'];
    $transportista = $row_lista['transportista'];

    $nofactura = $row_lista['no_factura'];
    $inventarioinicial = $row_lista['inventario_inicial'];
    $nice = $row_lista['nice'];
    $inventariofinal = $row_lista['inventario_final'];
    $metrocontador = $row_lista['metro_contador'];
    $metrocontador20 = $row_lista['metro_contador20'];

    $nofacturaremision = $row_lista['no_factura_remision'];
    $litros = $row_lista['litros'];
    $preciolitro = $row_lista['precio_litro'];
    $unidad = $row_lista['unidad'];
    $cuentalitros = $row_lista['cuenta_litros'];

    $valortolerancia = $litros * .55 / 100;
    $tolerancia = round($valortolerancia);

    $merma = $litros - $cuentalitros;

    $calculaNC = $merma - $tolerancia;

    $NC = number_format($calculaNC * $preciolitro, 2);

    $extensionFactura = pathinfo($nofactura, PATHINFO_EXTENSION);
    $extensionInvInicial = pathinfo($inventarioinicial, PATHINFO_EXTENSION);
    $extensionNice = pathinfo($nice, PATHINFO_EXTENSION);
    $extensionInvFinal = pathinfo($inventariofinal, PATHINFO_EXTENSION);
    $extensionmetrocontador = pathinfo($metrocontador, PATHINFO_EXTENSION);
    $extensionmetrocontador20 = pathinfo($metrocontador20, PATHINFO_EXTENSION);



    if ($extensionFactura == "pdf") {
        $facturaElement = '<iframe class="border-0 mt-0 mb-0" src="' . RUTA_ARCHIVOS . 'tuxpan/' . $nofactura . '" width="100%" height="400px"></iframe>';
    } else {
        $facturaElement = '<img src="' . RUTA_ARCHIVOS . 'tuxpan/' . $nofactura . '" width="100%">';
    }

    if ($extensionInvInicial == "pdf") {
        $invInicialElement = '<iframe class="border-0 mt-0 mb-0" src="' . RUTA_ARCHIVOS . 'tuxpan/' . $inventarioinicial . '" width="100%" height="400px"></iframe>';
    } else {
        $invInicialElement = '<img src="' . RUTA_ARCHIVOS . 'tuxpan/' . $inventarioinicial . '" width="100%">';
    }

    if ($extensionNice == "pdf") {
        $niceElement = '<iframe class="border-0 mt-0 mb-0" src="' . RUTA_ARCHIVOS . 'tuxpan/' . $nice . '" width="100%" height="400px"></iframe>';
    } else {
        $niceElement = '<img src="' . RUTA_ARCHIVOS . 'tuxpan/' . $nice . '" width="100%">';
    }

    if ($extensionInvFinal == "pdf") {
        $invFinalElement = '<iframe class="border-0 mt-0 mb-0" src="' . htmlspecialchars(RUTA_ARCHIVOS . 'tuxpan/' . $inventariofinal, ENT_QUOTES, 'UTF-8') . '" width="100%" height="400px"></iframe>';
    } else {
        $invFinalElement = '<img src="' . htmlspecialchars(RUTA_ARCHIVOS . 'tuxpan/' . $inventariofinal, ENT_QUOTES, 'UTF-8') . '" width="100%">';
    }



    if ($extensionmetrocontador == "pdf") {
        $metroElement = '<iframe class="border-0 mt-0 mb-0" src="' . RUTA_ARCHIVOS . 'tuxpan/' . $metrocontador . '" width="100%" height="400px"></iframe>';
    } else {
        $metroElement = '<img src="' . RUTA_ARCHIVOS . 'tuxpan/' . $metrocontador . '" width="100%">';
    }

    if ($extensionmetrocontador20 == "pdf") {
        $metro20Element = '<iframe class="border-0 mt-0 mb-0" src="' . RUTA_ARCHIVOS . 'tuxpan/' . $metrocontador20 . '" width="100%" height="400px"></iframe>';
    } else {
        $metro20Element = '<img src="' . RUTA_ARCHIVOS . 'tuxpan/' . $metrocontador20 . '" width="100%">';
    }

}

?>
<script type="text/javascript">

    $(document).ready(function ($) {
        $(".LoaderPage").fadeOut("slow");
    });

    function Regresar() {
        window.location.href = "../descarga-tuxpan";
    }

    function EditarDM(idReporte) {
        window.location.href = "../descarga-tuxpan-editar/" + idReporte;
    }

    function Eliminar(idReporte) {


        var parametros = {
            "idReporte": idReporte,
            "accion":"elimina-formato-merma"
        };


        alertify.confirm('',
            function () {

                $.ajax({
                    data: parametros,
                    //url: '../public/admin/modelo/eliminar-descarta-tuxpan.php',
                    url: '../app/controlador/3-importacion/controladorMerma.php',
                    type: 'post',
                    beforeSend: function () {
                    },
                    complete: function () {
                    },
                    success: function (response) {
                        if (response == 1) {
                            Regresar();
                        } else {
                            alertify.error('Error al eliminar la descarga');
                        }

                    }
                });

            },
            function () {

            }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();


    }

</script>
<!--Se ocupa cuando se registra un nuevo permiso y se actualice los datos de la vista-->
<script>
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                // Si la página está en la caché del navegador, recargarla
                window.location.reload();
            }
        });
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

                <div class="col-12 mb-3">
                    <div class="cardAG">
                        <div class="border-0 p-3">

                            <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
                                <ol class="breadcrumb breadcrumb-caret">
                                    <li class="breadcrumb-item"><a onclick="history.back()"
                                            class="text-uppercase text-primary pointer"><i
                                                class="fa-solid fa-chevron-left"></i>
                                            Formato descarga merma</a></li>
                                    <li aria-current="page" class="breadcrumb-item active text-uppercase">
                                        Detalle formato de descarga merma
                                    </li>
                                </ol>
                            </div>

                            <div class="row">
                                <div class="col-9">
                                    <h3 class="text-secondary"
                                        style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                                        Detalle formato merma</h3>

                                </div>
                                <div class="col-3">
                                    <img class="float-end pointer ms-2" src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"
                                        onclick="Eliminar(<?= $GET_idReporte; ?>)">
                                    <img class="float-end pointer ms-2" src="<?= RUTA_IMG_ICONOS; ?>editar-tb.png"
                                        onclick="EditarDM(<?= $GET_idReporte; ?>)">
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-12 col-sm-4 mb-3">
                                    <div class="border p-2">
                                        <div class="text-secondary titulos"><small>Folio:</small></div>
                                        <div class="font-weight-bold titulos">00<?= $folio; ?></div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4 mb-3">
                                    <div class="border p-2">
                                        <div class="text-secondary titulos"><small>Estación de descarga:</small></div>
                                        <div class="titulos"><?= $Estacion; ?></div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4 mb-3">
                                    <div class="border p-2">
                                        <div class="text-secondary titulos"><small>Responsable de la estación:</small>
                                        </div>
                                        <div class="titulos"><?= $Personal; ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-8 mb-3">
                                    <div class="border p-2">
                                        <div class="text-secondary titulos"><small>Fecha y hora de llegada de
                                                full:</small></div>
                                        <div class="titulos"><?= $fechallegada; ?>, <?= $horallegada; ?></div>
                                    </div>
                                </div>


                                <div class="col-12 col-sm-4 mb-3">
                                    <div class="border p-2">
                                        <div class="text-secondary titulos"><small>Productos recibido:</small></div>
                                        <div class="titulos"><?= $producto; ?></div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4 mb-3">
                                    <div class="border p-2">
                                        <div class="text-secondary titulos"><small>Numero Factura o Remisión:</small>
                                        </div>
                                        <div class="titulos"><?= $nofacturaremision; ?></div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4 mb-3">
                                    <div class="border p-2">
                                        <div class="text-secondary titulos"><small>Litros:</small></div>
                                        <div class="titulos"><?= number_format($litros, 2); ?></div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4 mb-3">
                                    <div class="border p-2">
                                        <div class="text-secondary titulos"><small>Precio por litro:</small></div>
                                        <div class="titulos"><?= $preciolitro; ?></div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4 mb-3">
                                    <div class="border p-2">
                                        <div class="text-secondary titulos"><small>Cuenta litro:</small></div>
                                        <div class="titulos"><?= $cuentalitros; ?></div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4 mb-3">
                                    <div class="border p-2">
                                        <div class="text-secondary titulos"><small>Tolerancia:</small></div>
                                        <div class="titulos"><?= $tolerancia; ?></div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-2 mb-3">
                                    <div class="border p-2">
                                        <div class="text-secondary titulos"><small>Merma en Litros:</small></div>
                                        <div class="titulos"><?= $merma; ?></div>
                                    </div>
                                </div>


                                <div class="col-12 col-sm-4 mb-3">
                                    <div class="border p-2">
                                        <div class="text-secondary titulos"><small>N.C:</small></div>
                                        <div class="titulos"><?= $calculaNC; ?></div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4 mb-3">
                                    <div class="border p-2">
                                        <div class="text-secondary titulos"><small>Importe N.C:</small></div>
                                        <div class="mt-1">$<?= $NC; ?></div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4 mb-3">
                                    <div class="border p-2">
                                        <div class="text-secondary titulos"><small>Unidad:</small></div>
                                        <div class="titulos"><?= $unidad; ?></div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4 mb-3">
                                    <div class="border p-2">
                                        <div class="text-secondary titulos"><small>Nombre del operador de la
                                                unidad:</small></div>
                                        <div class="titulos"><?= $operador; ?></div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-3 mb-3">
                                    <div class="border p-2">
                                        <div class="text-secondary titulos"><small>Compañía de Transportista:</small>
                                        </div>
                                        <div class="titulos"><?= $transportista; ?></div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-2 mb-3">
                                    <div class="border p-2">
                                        <div class="text-secondary titulos"><small>Sellos alterados:</small></div>
                                        <div class="titulos"><?= $sellos; ?></div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-3 mb-3">
                                    <div class="border p-2">
                                        <div class="text-secondary titulos"><small>Se detuvo venta durante la
                                                descarga:</small></div>
                                        <div class="titulos"><?= $detuvoventa; ?></div>
                                    </div>
                                </div>


                            </div>

                            <div class="row">

                                <div class="col-12 col-sm-4 mb-3">
                                    <div class="border p-3">
                                        <div class="text-secondary titulos"><small>Factura o Remisión:</small></div>
                                        <hr>
                                        <div class="text-center"><?= $facturaElement ?></div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4 mb-3">
                                    <div class="border p-3">
                                        <div class="text-secondary titulos"><small>Reporte de inventario Inicial con
                                                fecha y
                                                hora:</small></div>
                                        <hr>
                                        <div class="text-center"><?= $invInicialElement ?></div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-4 mb-3">
                                    <div class="border p-3">
                                        <div class="text-secondary titulos"><small>Medida Nice:</small></div>
                                        <hr>
                                        <div class="text-center"><?= $niceElement ?></div>
                                    </div>
                                </div>


                                <div class="col-12 col-sm-4 mb-3">
                                    <div class="border p-3">
                                        <div class="text-secondary titulos"><small>Reporte de inventario final con fecha
                                                y
                                                hora:</small></div>
                                        <hr>
                                        <div class="text-center"><?= $invFinalElement ?></div>
                                    </div>
                                </div>


                                <div class="col-12 col-sm-4 mb-3">
                                    <div class="border p-3">
                                        <div class="text-secondary titulos"><small>Metro contador temperatura
                                                normal:</small></div>
                                        <hr>
                                        <div class="text-center"><?= $metroElement ?></div>
                                    </div>
                                </div>


                                <div class="col-12 col-sm-4 mb-3">
                                    <div class="border p-3">
                                        <div class="text-secondary titulos"><small>Metro contador a 20 grados:</small>
                                        </div>
                                        <hr>
                                        <div class="text-center"><?= $metro20Element ?></div>
                                    </div>
                                </div>

                            </div>

                            <div class="border p-3">
                                <div class="col-9">
                                    <h3 class="text-secondary"
                                        style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                                        Firmas</h3>

                                </div>
                                <hr>
                                <div class="row justify-content-md-center">
                                    <?php

                                    $sql_firma = "SELECT * FROM op_descarga_tuxpa_firma WHERE id_descarga = '" . $GET_idReporte . "' ";
                                    $result_firma = mysqli_query($con, $sql_firma);
                                    $numero_firma = mysqli_num_rows($result_firma);
                                    while ($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)) {

                                        echo '<div class="col-12 col-sm-4">';
                                        echo '<div class="mb-2 text-center"><b>' . $row_firma['tipo_firma'] . '</b></div>';
                                        echo '<div class="border p-1 text-center"><img src="' . RUTA_IMG . 'firma-tuxpan/' . $row_firma['imagen_firma'] . '" width="100%"></div>';
                                        echo '</div>';
                                    }

                                    ?>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>

        </div>



        <!---------- FUNCIONES - NAVBAR ---------->
        <script
            src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</body>

</html>