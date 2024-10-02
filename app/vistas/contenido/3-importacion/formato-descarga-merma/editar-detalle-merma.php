<?php
require 'app/vistas/contenido/header.php';

$sql_lista = "SELECT * FROM op_descarga_tuxpa WHERE id = '" . $GET_idReporte . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
$id = $row_lista['id'];
$folio = $row_lista['folio'];
$idEstacionD = $row_lista['id_estacion'];
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($row_lista['id_estacion']);
$Estacion = $datosEstacion['nombre'];

$fechaInput = $row_lista['fecha_llegada'];
$fechallegada = FormatoFecha($row_lista['fecha_llegada']);
$horaInput = $row_lista['hora_llegada'];
$horallegada = date("g:i a", strtotime($row_lista['hora_llegada']));
$datosUsuario = $ClassHerramientasDptoOperativo->obtenerDatosUsuario($row_lista['id_usuario']);
$Personal = $datosUsuario['nombre'];

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
}

?>

<script type="text/javascript">

$(document).ready(function ($) {
$(".LoaderPage").fadeOut("slow");

});


function EditarFormato(idFormato) {
var Fechallegada = $('#Fechallegada').val();
var Horallegada = $('#Horallegada').val();
var Productos = $('#Productos').val();

var Merma = $('#Merma').val();
var Operador = $('#Operador').val();
var Transportista = $('#Transportista').val();

var NoFactura = $('#NoFactura').val();
var Litros = $('#Litros').val();
var PrecioLitro = $('#PrecioLitro').val();
var Unidad = $('#Unidad').val();
var CuentaLitros = $('#CuentaLitros').val();

FacturaRemision = document.getElementById("FacturaRemision");
FacturaRemision_file = FacturaRemision.files[0];
FacturaRemision_filePath = FacturaRemision.value;

InventarioInicial = document.getElementById("InventarioInicial");
InventarioInicial_file = InventarioInicial.files[0];
InventarioInicial_filePath = InventarioInicial.value;

Nice = document.getElementById("Nice");
Nice_file = Nice.files[0];
Nice_filePath = Nice.value;

InventarioFinal = document.getElementById("InventarioFinal");
InventarioFinal_file = InventarioFinal.files[0];
InventarioFinal_filePath = InventarioFinal.value;

MetroContador = document.getElementById("MetroContador");
MetroContador_file = MetroContador.files[0];
MetroContador_filePath = MetroContador.value;

MC20Grados = document.getElementById("MC20Grados");
MC20Grados_file = MC20Grados.files[0];
MC20Grados_filePath = MC20Grados.value;

Sellos = 'NO';
if ($('#SellosAlterados1').is(':checked')) {
Sellos = 'SI';
}

Sdvdld = 'NO';
 if ($('#sdvdld1').is(':checked')) {
Sdvdld = 'SI';
}

var data = new FormData();
//var url = '../public/admin/modelo/editar-descarga-tuxpan.php';
var url = '../app/controlador/3-importacion/controladorMerma.php';

        if (Litros != "") {
            $('#Litros').css('border', '');
            if (PrecioLitro != "") {
                $('#PrecioLitro').css('border', '');
                if (CuentaLitros != "") {
                    $('#CuentaLitros').css('border', '');
                    if (Merma != "") {
                        $('#Merma').css('border', '');
                        if (Unidad != "") {
                            $('#Unidad').css('border', '');
                            if (Operador != "") {
                                $('#Operador').css('border', '');
                                if (Transportista != "") {
                                    $('#Transportista').css('border', '');



                                    data.append('idFormato', idFormato);
                                    data.append('Fechallegada', Fechallegada);
                                    data.append('Horallegada', Horallegada);
                                    data.append('Productos', Productos);
                                    data.append('Merma', Merma);
                                    data.append('Operador', Operador);
                                    data.append('Transportista', Transportista);
                                    data.append('FacturaRemision_file', FacturaRemision_file);
                                    data.append('InventarioInicial_file', InventarioInicial_file);
                                    data.append('Nice_file', Nice_file);
                                    data.append('InventarioFinal_file', InventarioFinal_file);
                                    data.append('MetroContador_file', MetroContador_file);
                                    data.append('MC20Grados_file', MC20Grados_file);
                                    data.append('Sellos', Sellos);
                                    data.append('Sdvdld', Sdvdld);

                                    data.append('NoFactura', NoFactura);
                                    data.append('Litros', Litros);
                                    data.append('PrecioLitro', PrecioLitro);
                                    data.append('Unidad', Unidad);
                                    data.append('CuentaLitros', CuentaLitros);
                                    data.append('accion','editar-formato-merma');

                                    $(".LoaderPage").show();
                                    $.ajax({
                                        url: url,
                                        type: 'POST',
                                        contentType: false,
                                        data: data,
                                        processData: false,
                                        cache: false
                                    }).done(function (data) {
                                        $(".LoaderPage").hide();
                                        history.back();
                                    });


                                } else {
                                    $('#Transportista').css('border', '2px solid #A52525');
                                    alertify.error('Faltan transportista');
                                }
                            } else {
                                $('#Operador').css('border', '2px solid #A52525');
                                alertify.error('Faltan operador');
                            }
                        } else {
                            $('#Unidad').css('border', '2px solid #A52525');
                            alertify.error('Faltan unidad');
                        }
                    } else {
                        $('#Merma').css('border', '2px solid #A52525');
                        alertify.error('Faltan merma');
                    }
                } else {
                    $('#CuentaLitros').css('border', '2px solid #A52525');
                    alertify.error('Faltan el cuenta litros');
                }
            } else {
                $('#PrecioLitro').css('border', '2px solid #A52525');
                alertify.error('Faltan el precio por litro');
            }
        } else {
            $('#Litros').css('border', '2px solid #A52525');
            alertify.error('Faltan los litros');
        }

}

function mermaLts(e, num) {
var valor = e.value;
var LitrosInput = $('#Litros').val();
var CuentaLitrosInput = $('#CuentaLitros').val();

if (num == 1) {
var merma = valor - CuentaLitrosInput;
$('#Merma').val(merma);

} else if (num == 2) {
var merma2 = LitrosInput - valor;
$('#Merma').val(merma2);

}
}

</script>
</head>

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
                                                Detalle de formato</a></li>
                                    <li aria-current="page" class="breadcrumb-item active text-uppercase">
                                        Editar formato
                                    </li>
                                </ol>
                            </div>

                            <div class="row">
                                <div class="col-10">
                                    <h3 class="text-secondary"
                                        style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                                        Editar formato</h3>

                                </div>
                                <div class="col-2">
                                    <span class="badge rounded-pill tables-bg float-end" style="font-size:14px">Folio:
                                        00<?= $folio; ?>
                                    </span>
                                </div>
                            </div>
                            <hr>

                            <div class="row">

                            <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1 fw-bold">* ESTACIÓN DE DESCARGA:</div>
                                    <select class="form-control rounded-0" id="Estacion" disabled>
                                        <option value="<?= $idEstacionD; ?>"><?= $Estacion; ?></option>
                                    </select>
                                </div>


                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1 fw-bold">* RESPONSABLE DE LA ESTACIÓN:</div>
                                    <div id="Personal">
                                        <select class="form-control rounded-0" id="Responsable" disabled>
                                            <option value="<?= $idUsuario; ?>"><?= $Personal; ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1 fw-bold">* FECHA Y HORA DE LLEGADA DE FULL:</div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6 mb-2">
                                            <input type="date" class="form-control rounded-0" id="Fechallegada"
                                                value="<?= $fechaInput; ?>">
                                        </div>

                                        <div class="col-12 col-sm-6 mb-2">
                                            <input type="time" class="form-control rounded-0" id="Horallegada"
                                                value="<?= $horaInput; ?>">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">PRODUCTO RECIBIDO:</div>
                                    <select class="form-select rounded-0" id="Productos">
                                        <option><?= $producto; ?></option>

                                        <?php
                                        if ($producto == "87 oct") {
                                            $ocultar87 = "d-none";
                                        }

                                        if ($producto == "91 oct") {
                                            $ocultar91 = "d-none";
                                        }

                                        if ($producto == "Diesel") {
                                            $ocultarD = "d-none";
                                        }

                                        ?>

                                        <option class="<?= $ocultar87 ?>">87 oct</option>
                                        <option class="<?= $ocultar91 ?>">91 oct</option>
                                        <option class="<?= $ocultarD ?>">Diesel</option>
                                    </select>
                                </div>


                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">NUMERO FACTURA O REMISIÓN:</div>
                                    <input type="text" class="form-control rounded-0" id="NoFactura"
                                        value="<?= $nofacturaremision; ?>">
                                </div>

                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1 fw-bold">* LITROS:</div>
                                    <input type="number" class="form-control rounded-0" id="Litros" value="<?= $litros ?>"
                                        onkeyup="mermaLts(this,1)">
                                </div>

                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1 fw-bold">* PRECIO POR LITRO:</div>
                                    <input type="number" class="form-control rounded-0" id="PrecioLitro"
                                        value="<?= $preciolitro; ?>">
                                </div>

                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1 rounded-0 fw-bold">* CUENTA LITRO:</div>
                                    <input type="number" class="form-control rounded-0" id="CuentaLitros"
                                        value="<?= $cuentalitros; ?>" onkeyup="mermaLts(this,2)">
                                </div>


                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1">ANEXAR MERMA EN LITROS:</div>
                                    <input type="number" class="form-control rounded-0" id="Merma" value="<?= $merma; ?>"
                                        disabled>
                                </div>


                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1 fw-bold">* UNIDAD:</div>
                                    <input type="text" class="form-control rounded-0" id="Unidad" value="<?= $unidad; ?>">
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1 fw-bold">* NOMBRE DEL OPERADOR DE LA UNIDAD:</div>
                                    <input type="text" class="form-control rounded-0" id="Operador" value="<?= $operador; ?>">
                                </div>

                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1 fw-bold">* COMPAÑÍA DE TRANSPORTISTA:</div>
                                    <input type="text" class="form-control rounded-0" id="Transportista"
                                        value="<?= $transportista; ?>">
                                </div>

                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1">FACTURA O REMISIÓN:</div>
                                    <input type="file" class="form-control rounded-0" id="FacturaRemision">
                                </div>


                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1">SELLOS ALTERADOS:</div>

                                    <?php
                                    $checkSellosSI = "";
                                    if ($sellos == "SI") {
                                        $checkSellosSI = "checked";
                                    }
                                    $checkSellosNO = "";
                                    if ($sellos == "NO") {
                                        $checkSellosNO = "checked";
                                    }

                                    ?>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Radios1"
                                            id="SellosAlterados1" style="width: 18px; height: 18px;margin-top: 4px;"
                                            <?= $checkSellosSI; ?>>
                                        <label class="form-check-label" for="SellosAlterados1"
                                            style="margin-left: 10px;">
                                            SI
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Radios1"
                                            id="SellosAlterados2" style="width: 18px; height: 18px;margin-top: 4px;"
                                            <?= $checkSellosNO; ?>>
                                        <label class="form-check-label" for="SellosAlterados2"
                                            style="margin-left: 10px;">
                                            NO
                                        </label>
                                    </div>
                                </div>


                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1">SE DETUVO VENTA DURANTE LA DESCARGA:</div>

                                    <?php
                                    $checkDescargaSI = "";
                                    if ($detuvoventa == "SI") {
                                        $checkDescargaSI = "checked";
                                    }
                                    $checkDescargaNO = "";
                                    if ($detuvoventa == "NO") {
                                        $checkDescargaNO = "checked";
                                    }

                                    ?>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Radios2" id="sdvdld1"
                                            style="width: 18px; height: 18px;margin-top: 4px;" <?= $checkDescargaSI; ?>>
                                        <label class="form-check-label" for="sdvdld1" style="margin-left: 10px;">
                                            SI
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Radios2" id="sdvdld2"
                                            style="width: 18px; height: 18px;margin-top: 4px;" <?= $checkDescargaNO; ?>>
                                        <label class="form-check-label" for="sdvdld2" style="margin-left: 10px;">
                                            NO
                                        </label>
                                    </div>
                                </div>



                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1 fw-bold">* REPORTE DE INVENTARIO INICIAL CON FECHA Y HORA:
                                    </div>
                                    <input type="file" class="form-control rounded-0" id="InventarioInicial">
                                </div>

                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1 fw-bold">* MEDIDA NICE:</div>
                                    <input type="file" class="form-control rounded-0" id="Nice">
                                </div>

                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1 fw-bold">* REPORTE DE INVENTARIO FINAL CON FECHA Y HORA:</div>
                                    <input type="file" class="form-control rounded-0" id="InventarioFinal">
                                </div>

                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1 fw-bold">* METRO CONTADOR TEMPERATURA NORMAL:</div>
                                    <input type="file" class="form-control rounded-0" id="MetroContador">
                                </div>


                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1 fw-bold">* METRO CONTADOR A 20 GRADOS:</div>
                                    <input type="file" class="form-control rounded-0" id="MC20Grados">
                                </div>



                            </div>


                            <hr>

                <!----- FIRMAS ----->


                <div class="row justify-content-md-center">
        <?php
        $sql_firma = "SELECT * FROM op_descarga_tuxpa_firma WHERE id_descarga = '" . $GET_idReporte . "' ";
        $result_firma = mysqli_query($con, $sql_firma);
        $numero_firma = mysqli_num_rows($result_firma);
        while ($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)) {

        echo '<div class="col-12 col-sm-4 mb-3">
        <div class="table-responsive">
        <table id="tabla_bitacora" class="custom-table mt-2" style="font-size: 12.5px;" width="100%">
        <thead class="tables-bg">
        <tr> <th class="align-middle text-center">Firma del '.$row_firma['tipo_firma'].' </th> </tr>
        </thead>
        <tbody>
        <tr class="no-hover">
        <th class="align-middle text-center bg-light"><img src="' . RUTA_IMG . 'firma-tuxpan/' . $row_firma['imagen_firma'] . '" width="100%"></th>
        </tr>
        </tbody>
        </table>
        </div>
        </div>';


        }
        ?>
        </div>


        <hr>
        <div class="row ">

        <div class="col-12">

        <button type="button" class="btn btn-labeled2 btn-success float-end" onclick="EditarFormato(<?= $GET_idReporte ?>)">
        <span class="btn-label2"><i class="fa-solid fa-check"></i></span>Editar y Finalizar</button>


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