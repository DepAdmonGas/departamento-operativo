<?php
require 'app/vistas/contenido/header.php';
$Disabled = 'disabled';
$idEstacion = $GET_idEstacion;

?> 

<script type="text/javascript">

$(document).ready(function ($) {
$(".LoaderPage").fadeOut("slow");
});

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

        Sdvdld = 'NO';
        Sellos = 'NO';
        if ($('#SellosAlterados1').is(':checked')) {
            Sellos = 'SI';
        }

        if ($('#sdvdld1').is(':checked')) {
            Sdvdld = 'SI';
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
        var url = '../app/controlador/3-importacion/controladorMerma.php';

        if (Estacion != "") {
            $('#Estacion').css('border', '');
            if (Responsable != "") {
                $('#Responsable').css('border', '');
                if (Fechallegada != "") {
                $('#Fechallegada').css('border', '');
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
                                                                            console.log(data)
                                                                            $(".LoaderPage").hide();
                                                                            history.back();
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
                $('#Fechallegada').css('border', '2px solid #A52525');
                alertify.error('Falta fecha de llegada');
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
<div class="cardAG ">
<div class="border-0 p-3 ">

<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Formato descarga merma</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Nuevo formato
</li>
</ol>
</div>

<div class="row">
<div class="col-9"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Nuevo Formato</h3></div>
<div class="col-3">
<button type="button" class="btn btn-labeled2 btn-success float-end" onclick="GuardarFirmar()">
<span class="btn-label2"><i class="fa-solid fa-check"></i></span>Finalizar</button>
</div>      
</div>
<hr>


<div class="row">
<div class="col-12 col-sm-3 mb-2">
<div class="text-secondary mb-1 fw-bold">* ESTACIÓN DE DESCARGA:</div>
                                    <select class="form-select rounded-0" id="Estacion"

                                        <?= $Disabled; ?>>
                                        <option value="<?= $idEstacion; ?>"><?= $session_nomestacion; ?></option>
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

                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1 fw-bold">* RESPONSABLE DE LA ESTACIÓN:</div>
                                    <div id="Personal">

                                        <select class="form-select rounded-0" id="Responsable" <?= $Disabled; ?>>
                                            <option value="<?= $Session_IDUsuarioBD; ?>"><?= $session_nomusuario; ?></option>

                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1 fw-bold">* FECHA Y HORA DE LLEGADA DE FULL:</div>
                                    <div class="row">
                                    <div class="col-12 col-sm-6 mb-2">
                                            <input type="date" class="form-control rounded-0" id="Fechallegada">
                                        </div>

                                        <div class="col-12 col-sm-6 mb-2">
                                            <input type="time" class="form-control rounded-0" id="Horallegada">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">PRODUCTO RECIBIDO:</div>
                                    <select class="form-select rounded-0" id="Productos">
                                        <option></option>
                                        <option>87 oct</option>
                                        <option>91 oct</option>
                                        <option>Diesel</option>
                                    </select>
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1">NUMERO FACTURA O REMISIÓN:</div>
                                    <input type="text" class="form-control rounded-0" id="NoFactura">
                                </div>

                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1 fw-bold">* LITROS:</div>
                                    <input type="number" class="form-control rounded-0" id="Litros" onchange="mermaLts(this,1)">
                                </div>

                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1 fw-bold">* PRECIO POR LITRO:</div>
                                    <input type="number" class="form-control rounded-0" id="PrecioLitro">
                                </div>

                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1 fw-bold">* CUENTA LITRO:</div>
                                    <input type="number" class="form-control rounded-0" id="CuentaLitros"
                                    onchange="mermaLts(this,2)">
                                </div>

                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1">ANEXAR MERMA EN LITROS:</div>
                                    <input type="number" class="form-control rounded-0" id="Merma" disabled>
                                </div>

                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1 fw-bold">* UNIDAD:</div>
                                    <input type="text" class="form-control rounded-0" id="Unidad">
                                </div>

                                <div class="col-12 col-sm-6 mb-2">
                                    <div class="text-secondary mb-1 fw-bold">* NOMBRE DEL OPERADOR DE LA UNIDAD:</div>
                                    <input type="text" class="form-control rounded-0" id="Operador">
                                </div>

                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1 fw-bold">* COMPAÑÍA DE TRANSPORTISTA:</div>
                                    <input type="text" class="form-control rounded-0" id="Transportista">
                                </div>

                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1">FACTURA O REMISIÓN:</div>
                                    <input type="file" class="form-control rounded-0" id="FacturaRemision">
                                </div>

                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1">SELLOS ALTERADOS:</div>
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

                                <div class="col-12 col-sm-3 mb-2">
                                    <div class="text-secondary mb-1">SE DETUVO VENTA DURANTE LA DESCARGA:</div>
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

  <!---------- FIRMA ---------->
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">* FIRMA DEL ENCARGADO</th> </tr>
  </thead>
  <tbody>
  <tr>
  <th class="align-middle text-center p-0 no-hover2">          
  <div id="signature-pad-1" class="signature-pad ">
  <div class="signature-pad--body ">
  <canvas style="width: 100%; height: 150px; border-right: .1px solid #215d98; border-left: .1px solid #215d98; cursor: crosshair;" id="canvas1"></canvas>
  </div>
  <input type="hidden" name="base64" value="" id="baseImage1">
  </div> 
  </th>
  </tr>

  <tr>
  <th class="align-middle text-center p-2 bg-danger text-white" onclick="clear1()">  
  <i class="fa-solid fa-arrow-rotate-left"></i> Limpiar firma        
  </th>
  </tr>

  </tbody>
  </table>
  </div>



  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">* FIRMA DEL OPERADOR</th> </tr>
  </thead>
  <tbody>
  <tr>
  <th class="align-middle text-center p-0 no-hover2">          
  <div id="signature-pad-2" class="signature-pad ">
  <div class="signature-pad--body ">
  <canvas style="width: 100%; height: 150px; border-right: .1px solid #215d98; border-left: .1px solid #215d98; cursor: crosshair;" id="canvas2"></canvas>
  </div>
  <input type="hidden" name="base64" value="" id="baseImage2">
  </div> 
  </th>
  </tr>

  <tr>
  <th class="align-middle text-center p-2 bg-danger text-white" onclick="clear2()">  
  <i class="fa-solid fa-arrow-rotate-left"></i> Limpiar firma        
  </th>
  </tr>

  </tbody>
  </table>
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