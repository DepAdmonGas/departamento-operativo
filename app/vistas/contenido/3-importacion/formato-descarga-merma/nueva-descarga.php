<?php
require 'app/vistas/contenido/header.php';

$Disabled = 'disabled';
$idEstacion = $Session_IDEstacion;
$NomEst = $session_nomestacion;
$idUsuario = $Session_IDUsuarioBD;
$NomUsua = $session_nomusuario;

if ($Session_IDEstacion == 8):
    $Disabled = '';
    $idEstacion = '';
    $NomEst = '';
    $idUsuario = '';
    $NomUsua = '';

endif;

?>
<script type="text/javascript">

    $(document).ready(function ($) {
        $(".LoaderPage").fadeOut("slow");
    });

    function Regresar() {
        window.history.back();
    }

    function GuardarFirmar() {
        var Estacion = $('#Estacion').val();
        var Responsable = $('#Responsable').val();
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

        if ($('#SellosAlterados1').is(':checked')) {
            Sellos = 'SI';
        } else {
            Sellos = 'NO';
        }

        if ($('#sdvdld1').is(':checked')) {
            Sdvdld = 'SI';
        } else {
            Sdvdld = 'NO';
        }

        var baseImage1 = "";
        var baseImage2 = "";
        let signatureBlank1 = signaturePad1.isEmpty();
        if (!signatureBlank1) {
            var ctx1 = document.getElementById("canvas1");
            var image1 = ctx1.toDataURL();
            document.getElementById('baseImage1').value = image1;
            baseImage1 = $('#baseImage1').val();
            $('#canvas1').css('border', '1px solid black');
        } else {
            $('#canvas1').css('border', '2px solid #A52525');
            baseImage1 = "";
        }

        let signatureBlank2 = signaturePad2.isEmpty();
        if (!signatureBlank2) {
            var ctx2 = document.getElementById("canvas2");
            var image2 = ctx2.toDataURL();
            document.getElementById('baseImage2').value = image2;
            baseImage2 = $('#baseImage2').val();
            $('#canvas2').css('border', '1px solid black');
        } else {
            $('#canvas2').css('border', '2px solid #A52525');
            baseImage2 = "";
        }

        var data = new FormData();
        //var url = 'public/admin/modelo/guardar-descarga-tuxpan.php';
        var url = 'app/controlador/3-importacion/controladorMerma.php';

        if (Estacion != "") {
            $('#Estacion').css('border', '');
            if (Responsable != "") {
                $('#Responsable').css('border', '');
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


                                            if (InventarioInicial_filePath != "") {
                                                $('#InventarioInicial').css('border', '');
                                                if (Nice_filePath != "") {
                                                    $('#Nice').css('border', '');
                                                    if (InventarioFinal_filePath != "") {
                                                        $('#InventarioFinal').css('border', '');
                                                        if (MetroContador_filePath != "") {
                                                            $('#MetroContador').css('border', '');
                                                            if (MC20Grados_filePath != "") {
                                                                $('#MC20Grados').css('border', '');

                                                                if (baseImage1 != "") {
                                                                    $('#canvas1').css('border', '');
                                                                    if (baseImage2 != "") {
                                                                        $('#canvas2').css('border', '');

                                                                        data.append('Estacion', Estacion);
                                                                        data.append('Responsable', Responsable);
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
                                                                        data.append('baseImage1', baseImage1);
                                                                        data.append('baseImage2', baseImage2);

                                                                        data.append('NoFactura', NoFactura);
                                                                        data.append('Litros', Litros);
                                                                        data.append('PrecioLitro', PrecioLitro);
                                                                        data.append('Unidad', Unidad);
                                                                        data.append('CuentaLitros', CuentaLitros);
                                                                        data.append('accion','nuevo-formato');

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
                                                                            Regresar();
                                                                        });

                                                                    } else {
                                                                        alertify.error('Falta firma operador');
                                                                    }
                                                                } else {

                                                                    alertify.error('Falta firma encargado de estación');
                                                                }
                                                            } else {
                                                                $('#MC20Grados').css('border', '2px solid #A52525');
                                                                alertify.error('Falta Metro contador a 20 grados');
                                                            }
                                                        } else {
                                                            $('#MetroContador').css('border', '2px solid #A52525');
                                                            alertify.error('Falta Metro contador temperatura normal');
                                                        }
                                                    } else {
                                                        $('#InventarioFinal').css('border', '2px solid #A52525');
                                                        alertify.error('Falta Reporte de inventario final con fecha y hora');
                                                    }
                                                } else {
                                                    $('#Nice').css('border', '2px solid #A52525');
                                                    alertify.error('Falta Medida Nice');
                                                }
                                            } else {
                                                $('#InventarioInicial').css('border', '2px solid #A52525');
                                                alertify.error('Falta Reporte de inventario Inicial con fecha y hora');
                                            }


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
            } else {
                $('#Responsable').css('border', '2px solid #A52525');
                alertify.error('Falta responsable');
            }
        } else {
            $('#Estacion').css('border', '2px solid #A52525');
            alertify.error('Falta Estación de descarga');
        }

    }

    function BuscarEstacion(e) {

        var idEstacion = e.value

        var parametros = {
            "idEstacion": idEstacion
        };

        $.ajax({
            data: parametros,
            url: 'public/admin/modelo/buscar-personal-descarta-tuxpan.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {

                $('#Personal').html(response);

            }
        });
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

            <section class="row">
                <div class="col-12 mb-3">
                    <div class="cardAG">
                        <div class="border-0 p-3 ">

                            <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
                                <ol class="breadcrumb breadcrumb-caret">
                                    <li class="breadcrumb-item"><a onclick="history.back()"
                                            class="text-uppercase text-primary pointer"><i
                                                class="fa-solid fa-chevron-left"></i>
                                            Formato descarga merma</a></li>
                                    <li aria-current="page" class="breadcrumb-item active text-uppercase">Nuevo formato
                                    </li>
                                </ol>
                            </div>

                            <div class="row">
                                <div class="col-9">
                                    <h3 class="text-secondary"
                                        style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                                        Nuevo Formato</h3>
            
                                </div>
                            </div>
                            <hr>
                            <div class="row">

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">Estación de descarga:</div>
                                    <select class="form-select" id="Estacion" onchange="BuscarEstacion(this)"
                                        <?= $Disabled; ?>>
                                        <option value="<?= $idEstacion; ?>"><?= $NomEst; ?></option>
                                        <?php
                                        $sql_listaestacion = "SELECT id, nombre FROM tb_estaciones WHERE numlista <= 8";
                                        $result_listaestacion = mysqli_query($con, $sql_listaestacion);
                                        while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
                                            $id = $row_listaestacion['id'];
                                            $estacion = $row_listaestacion['nombre'];
                                            echo '<option value="' . $id . '">' . $estacion . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">Responsable de la estación:</div>
                                    <div id="Personal">
                                        <select class="form-select" id="Responsable" <?= $Disabled; ?>>
                                            <option value="<?= $idUsuario; ?>"><?= $NomUsua; ?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 mb-2">
                                    <div class="text-secondary mb-1">Fecha y hora de llegada de full:</div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6 mb-2">
                                            <input type="date" class="form-control" id="Fechallegada">
                                        </div>

                                        <div class="col-12 col-sm-6 mb-2">
                                            <input type="time" class="form-control" id="Horallegada">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">Productos recibido:</div>
                                    <select class="form-select" id="Productos">
                                        <option></option>
                                        <option>87 oct</option>
                                        <option>91 oct</option>
                                        <option>Diesel</option>
                                    </select>
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">Numero Factura o Remisión:</div>
                                    <input type="text" class="form-control" id="NoFactura">
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">Litros:</div>
                                    <input type="number" class="form-control" id="Litros" onkeyup="mermaLts(this,1)">
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">Precio por litro:</div>
                                    <input type="number" class="form-control" id="PrecioLitro">
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">Cuenta litro:</div>
                                    <input type="number" class="form-control" id="CuentaLitros"
                                        onkeyup="mermaLts(this,2)">
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">Anexar merma en Litros:</div>
                                    <input type="number" class="form-control" id="Merma" disabled>
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">Unidad:</div>
                                    <input type="text" class="form-control" id="Unidad">
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">Nombre del operador de la unidad:</div>
                                    <input type="text" class="form-control" id="Operador">
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">Compañía de Transportista:</div>
                                    <input type="text" class="form-control" id="Transportista">
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">Factura o Remisión:</div>
                                    <input type="file" class="form-control" id="FacturaRemision">
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">Sellos alterados:</div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Radios1"
                                            id="SellosAlterados1" style="width: 18px; height: 18px;margin-top: 4px;">
                                        <label class="form-check-label" for="SellosAlterados1"
                                            style="margin-left: 10px;">
                                            SI
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Radios1"
                                            id="SellosAlterados2" style="width: 18px; height: 18px;margin-top: 4px;">
                                        <label class="form-check-label" for="SellosAlterados2"
                                            style="margin-left: 10px;">
                                            NO
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">Se detuvo venta durante la descarga:</div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Radios2" id="sdvdld1"
                                            style="width: 18px; height: 18px;margin-top: 4px;">
                                        <label class="form-check-label" for="sdvdld1" style="margin-left: 10px;">
                                            SI
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="Radios2" id="sdvdld2"
                                            style="width: 18px; height: 18px;margin-top: 4px;">
                                        <label class="form-check-label" for="sdvdld2" style="margin-left: 10px;">
                                            NO
                                        </label>
                                    </div>
                                </div>


                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">Reporte de inventario Inicial con fecha y hora:
                                    </div>
                                    <input type="file" class="form-control" id="InventarioInicial">
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">Medida Nice:</div>
                                    <input type="file" class="form-control" id="Nice">
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">Reporte de inventario final con fecha y hora:</div>
                                    <input type="file" class="form-control" id="InventarioFinal">
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">Metro contador temperatura normal:</div>
                                    <input type="file" class="form-control" id="MetroContador">
                                </div>


                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">Metro contador a 20 grados:</div>
                                    <input type="file" class="form-control" id="MC20Grados">
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <!----- FIRMAS ----->
                <div class="col-12 mb-3">
                    <div class="cardAG">
                        <div class="border-0 p-3">

                            <div class="row">
                                <div class="col-12">
                                    <h5>Firmas</h5>
                                    <hr>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">Encargado de estación:</div>
                                    <div id="signature-pad-1" class="signature-pad mt-2" onmouseup="PintarCanva(this)">
                                        <div class="signature-pad--body">
                                            <canvas style="width: 100%; height: 150px; border: 1px black solid;"
                                                id="canvas1"></canvas>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <input type="hidden" name="base64" value="" id="baseImage1">
                                        <button type="button" class="btn btn-sm btn-primary float-end"
                                            onclick="clear1()">Limpiar</button>
                                    </div>
                                </div>


                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">Operador:</div>
                                    <div id="signature-pad-2" class="signature-pad mt-2">
                                        <div class="signature-pad--body">
                                            <canvas style="width: 100%; height: 150px; border: 1px black solid; "
                                                id="canvas2"></canvas>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <input type="hidden" name="base64" value="" id="baseImage2">
                                        <button type="button" class="btn btn-sm btn-primary float-end"
                                            onclick="clear2()">Limpiar</button>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-success btn-block p-2 mb-2 mt-2 float-end"
                                        onclick="GuardarFirmar()">Guardar y Finalizar</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script type="text/javascript">

        var wrapper1 = document.getElementById("signature-pad-1"),
            canvas1 = wrapper1.querySelector("canvas"),
            signaturePad

        var wrapper2 = document.getElementById("signature-pad-2"),
            canvas2 = wrapper2.querySelector("canvas"),
            signaturePad2;

        function resizeCanvas(canvas) {
            var ratio = window.devicePixelRatio || 1;
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
        }

        resizeCanvas(canvas1);
        signaturePad1 = new SignaturePad(canvas1);

        resizeCanvas(canvas2);
        signaturePad2 = new SignaturePad(canvas2);

        function clear1() {
            signaturePad1.clear();
            document.getElementById('baseImage1').value = "";
        }

        function clear2() {
            signaturePad2.clear();
            document.getElementById('baseImage2').value = "";
        }
    </script>


    <!---------- FUNCIONES - NAVBAR ---------->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>
</body>

</html>