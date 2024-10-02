<?php
error_reporting(0);
require 'app/vistas/contenido/header.php';
?>

<script type="text/javascript">

    $(document).ready(function ($) {
        $(".LoaderPage").fadeOut("slow");

    });

    function Regresar() {
        window.history.back();
    }

    function Crear(idEstacion) {

        var data = new FormData();
        //var url = '../public/recursos-humanos/modelo/agregar-permisos.php';
        var url = '../app/controlador/2-recursos-humanos/controladorPermisos.php';

        var Colaborador = $('#Colaborador').val();
        var DiasTomados = $('#DiasTomados').val();
        var estacionPersonal = $('#estacionPersonal').val();

        var Observacion = $('#Observacion').val();

        var FechaInicio = $('#FechaInicio').val();
        var FechaTermino = $('#FechaTermino').val();
        var Cubre = $('#Cubre').val();
        var Motivo = $('#Motivo').val();

        var ctx = document.getElementById("canvas");
        var image = ctx.toDataURL();
        document.getElementById('base64').value = image;

        var base64 = $('#base64').val();

        if (Colaborador != "") {
            $('#Colaborador').css('border', '');
            if (DiasTomados != "") {
                $('#DiasTomados').css('border', '');
                if (estacionPersonal != "") {
                    $('#estacionPersonal').css('border', '');
                    if (Cubre != "") {
                        $('#Cubre').css('border', '');
                        if (Motivo != "") {
                            $('#Motivo').css('border', '');

                            if (signaturePad.isEmpty()) {
                                $('#canvas').css('border', '2px solid #A52525');
                            } else {
                                $('#canvas').css('border', '1px solid #000000');

                                $(".LoaderPage").show();

                                data.append('tipo', 1);
                                data.append('Estacion', idEstacion);
                                data.append('Colaborador', Colaborador);
                                data.append('DiasTomados', DiasTomados);
                                data.append('Observacion', Observacion);
                                data.append('FechaInicio', FechaInicio);
                                data.append('FechaTermino', FechaTermino);
                                data.append('Cubre', Cubre);
                                data.append('Motivo', Motivo);
                                data.append('base64', base64);
                                data.append('estacionCubre',estacionPersonal);
                                data.append('accion','agregar-permiso')
                                $.ajax({
                                    url: url,
                                    type: 'POST',
                                    contentType: false,
                                    data: data,
                                    processData: false,
                                    cache: false
                                }).done(function (data) {
                                    console.log(data)
                                    if (data == 1) {
                                        Regresar();
                                    } else {
                                        $(".LoaderPage").hide();
                                        alertify.error('Error al crear el permiso');
                                    }
                                });
                            }
                        } else {
                            $('#Motivo').css('border', '2px solid #A52525');
                        }
                    } else {
                        $('#Cubre').css('border', '2px solid #A52525');
                    }
                } else {
                    $('#estacionPersonal').css('border', '2px solid #A52525');
                }
            } else {
                $('#DiasTomados').css('border', '2px solid #A52525');
            }
        } else {
            $('#Colaborador').css('border', '2px solid #A52525');
        }
    }
    function SelEstacionP() {

        const idEstacion = $('#estacionPersonal').val();
        //$('#SelectPersonal').load('../public/recursos-humanos/vistas/lista-personal-select.php?idEstacion=' + idEstacion);
        $('#SelectPersonal').load('../app/vistas/contenido/2-recursos-humanos/permisos/lista-personal-select.php?idEstacion=' + idEstacion);
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
<div class="container bg-white p-3">
        
<div class="row">
                
<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Permisos</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Nuevo Permiso</li>
</ol>
</div>

<div class="row">
<div class="col-12">
<h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Nuevo Permiso</h3>
<hr>
</div>
</div>

</div>

<div class="col-12">
<div class="alert alert-warning text-center" role="alert">
<b>IMPORTANTE:</b> PARA SOLICITAR UN PERMISO DEBE DE SER CON MÍNIMO 15 DÍAS DEANTICIPACIÓN
</div>
</div>


<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
<div class="row">

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
<label class="text-secondary mt-2 fw-bold">* COLABORADOR</label>
<?php
$sql_listaestacion = "SELECT id, nombre FROM tb_usuarios WHERE id_gas = '" . $GET_idEstacion . "' AND estatus = 0 ORDER BY nombre ASC";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
echo '<select class="form-select titulos" id="Colaborador">';
echo '<option value="' . $idpersonal . '">' . $Responsable . '</option>';
while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
$id = $row_listaestacion['id'];
$estacion = $row_listaestacion['nombre'];
echo '<option value="' . $id . '">' . $estacion . '</option>';
}
echo '</select>';
?>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
<label class="text-secondary mt-2 fw-bold">* DÍAS TOMADOS</label>
<input type="text" class="form-control" id="DiasTomados" value="<?= $diastomados; ?>">
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
<label class="text-secondary mt-2">DEL</label>
<input type="date" class="form-control" id="FechaInicio"  value="<?= $FechaInicio; ?>">
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
<label class="text-secondary mt-2">HASTA</label>
<input type="date" class="form-control" id="FechaTermino" value="<?= $FechaTermino; ?>">
</div>
</div>
</div>


<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
<div class="row">

<div class="col-12">
<label class="text-secondary mt-2 fw-bold">* ESTACION</label>
<select class="form-select titulos" id="estacionPersonal" onchange="SelEstacionP()">
<option value=""></option>
<?php
$sql_estaciones = "SELECT id, nombre FROM tb_estaciones WHERE numlista <= 9  ORDER BY numlista ASC";
$result_estaciones = mysqli_query($con, $sql_estaciones);
$numero_estaciones = mysqli_num_rows($result_estaciones);

while ($row_estaciones = mysqli_fetch_array($result_estaciones, MYSQLI_ASSOC)) {
$idEstacionOP = $row_estaciones['id'];
$nombreES = $row_estaciones['nombre'];
echo '<option value="' . $idEstacionOP . '">' . $nombreES . '</option>';
}
?>
</select>
</div>

<div class="col-12">
<label class="text-secondary mt-2 fw-bold">* QUIEN CUBRE</label>
<div id="SelectPersonal">
<select class="form-select titulos" id="Cubre">
<option value=""></option>
</select>
</div>
</div>

</div>
</div>

   
<div class="col-12">
<div class="row">
<div class="col-12 col-sm-4">
<label class="text-secondary mt-3 fw-bold">* MOTIVO</label>
<textarea class="form-control titulos" id="Motivo"><?= $Motivo; ?></textarea>
</div>

<div class="col-12 col-sm-4">
<label class="text-secondary mt-3">OBSERVACIONES</label>
<textarea class="form-control titulos" id="Observacion"><?= $observaciones; ?></textarea>
</div>
</div>
<hr>
</div>


  <!---------- FIRMA ---------->
  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">FIRMA DEL SOLICITANTE</th> </tr>
  </thead>
  <tbody>
  <tr>
  <th class="align-middle text-center p-0 no-hover2">          
  <div id="signature-pad" class="signature-pad ">
  <div class="signature-pad--body ">
  <canvas style="width: 100%; height: 150px; border-right: .1px solid #215d98; border-left: .1px solid #215d98; cursor: crosshair;" id="canvas"></canvas>
  </div>
  <input type="hidden" name="base64" value="" id="base64">
  </div> 
  </th>
  </tr>

  <tr>
  <th class="align-middle text-center p-2 bg-danger text-white" onclick="resizeCanvas()">  
  <i class="fa-solid fa-arrow-rotate-left"></i> Limpiar firma        
  </th>
  </tr>

  </tbody>
  </table>
  </div>


  <div class="col-12">
    <hr>
  <button type="button" class="btn btn-labeled2 btn-success float-end" onclick="Crear(<?= $GET_idEstacion; ?>)">
  <span class="btn-label2"><i class="fa fa-check"></i></span>Crear Permiso</button>
  </div>


  </div>
  </div>
  </div>

  </div>
  </div>


<!---------- FUNCIONES - NAVBAR ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>
<script src="<?= RUTA_JS2 ?>signature-pad-functions.js"></script>

</body>
</html>