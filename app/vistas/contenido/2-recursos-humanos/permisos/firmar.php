  <?php
  require ('app/help.php');

  $sql_lista = "SELECT * FROM op_rh_permisos WHERE id = '" . $GET_idReporte . "' ORDER BY id DESC";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);
  while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $id = $row_lista['id'];
  $idestacion = $row_lista['id_estacion'];
  $idpersonal = $row_lista['id_personal'];
  
  $datosLocalidad = $ClassHerramientasDptoOperativo-> obtenerDatosLocalidades($idestacion);
  $Estacion = $datosLocalidad['localidad'];
 
  $datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosUsuario($idpersonal);
  $nameUSUR = $datosPersonal['nombre'];
   
  $diastomados = $row_lista['dias_tomados'];
  $observaciones = $row_lista['observaciones'];
  $FechaInicio = $row_lista['fecha_inicio'];
  $FechaTermino = $row_lista['fecha_termino'];
  $Motivo = $row_lista['motivo'];
  
  $idComodin = $row_lista['cubre_turno'];
  $datosPersonalC = $ClassHerramientasDptoOperativo->obtenerDatosUsuario($idComodin);
  $nameUSU = $datosPersonalC['nombre'];
  $nameES = $datosPersonalC['nombreES'];
 
  }

  function FirmaSC($idReporte, $tipoFirma, $con){
  $sql_lista = "SELECT * FROM op_rh_permisos_firma WHERE id_permiso = '" . $idReporte . "' AND tipo_firma = '" . $tipoFirma . "' ";
  $result_lista = mysqli_query($con, $sql_lista);
  return $numero_lista = mysqli_num_rows($result_lista);
  }

  $firmaB = FirmaSC($GET_idReporte, 'B', $con);
  $firmaC = FirmaSC($GET_idReporte, 'C', $con);

  ?>

<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Departamento Operativo</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <link rel="shortcut icon" href="<?= RUTA_IMG_ICONOS ?>/icono-web.png">
    <link rel="apple-touch-icon" href="<?= RUTA_IMG_ICONOS ?>/icono-web.png">
    <link rel="stylesheet" href="<?= RUTA_CSS2 ?>alertify.css">
    <link rel="stylesheet" href="<?= RUTA_CSS2 ?>themes/default.rtl.css">
    <link href="<?= RUTA_CSS2; ?>bootstrap.min.css" rel="stylesheet" />
    <link href="<?= RUTA_CSS2; ?>navbar-general.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
    <script type="text/javascript" src="<?=RUTA_JS ?>signature_pad.js"></script>

    <script type="text/javascript">

        $(document).ready(function ($) {
            $(".LoaderPage").fadeOut("slow");

        });

        function Regresar() {
            window.history.back();
        }

        function CrearToken(idReporte, idVal) {

            $(".LoaderPage").show();

            var parametros = {
                "idReporte": idReporte,
                "idVal": idVal,
                "accion":"crear-token"
            };

            $.ajax({
                data: parametros,
                //url: '../public/recursos-humanos/modelo/token-permiso.php',
                url: '../app/controlador/2-recursos-humanos/controladorPermisos.php',
                type: 'post',
                beforeSend: function () {
                },
                complete: function () {

                },
                success: function (response) {
                    $(".LoaderPage").hide();

                    if (response == 1) {
                        alertify.message('El token fue enviado por mensaje');
                    } else {
                        alertify.error('Error al crear el token');
                    }

                }
            })

        }

        function FirmarPermiso(idReporte, tipoFirma) {

            var TokenValidacion = $('#TokenValidacion').val();

            var parametros = {
                "idReporte": idReporte,
                "tipoFirma": tipoFirma,
                "TokenValidacion": TokenValidacion,
                "accion":"firmar-permiso"
            };

            if (TokenValidacion != "") {
                $('#TokenValidacion').css('border', '');

                $(".LoaderPage").show();

                $.ajax({
                    data: parametros,
                    //url: '../public/recursos-humanos/modelo/firmar-permiso.php',
                    url: '../app/controlador/2-recursos-humanos/controladorPermisos.php',
                    type: 'post',
                    beforeSend: function () {
                    },
                    complete: function () {

                    },
                    success: function (response) {
                        $(".LoaderPage").hide();

                        if (response == 1) {

                            $('#ModalFinalizado').modal('show');

                        } else {
                            $('#ModalError').modal('show');
                            alertify.error('Error al firmar el permiso');
                        }

                    }
                });

            } else {
                $('#TokenValidacion').css('border', '2px solid #A52525');
            }

        }
        function Firmar(idReporte, tipoFirma,idUsuario) {
            var data = new FormData();
            var url = '../app/controlador/2-recursos-humanos/controladorPermisos.php';
            //var url = '../public/recursos-humanos/modelo/agregar-permisos.php';
            var ctx = document.getElementById("canvas");
            var image = ctx.toDataURL();
            document.getElementById('base64').value = image;
            var base64 = $('#base64').val();


            if (signaturePad.isEmpty()) {
            $('#canvas').css('border', '2px solid #A52525');
            } else {
            $('#canvas').css('border', '1px solid #000000');

            data.append('tipo', 3);
            data.append('idReporte', idReporte);
            data.append('tipoFirma', tipoFirma);
            data.append('base64', base64);
            data.append('usuario',idUsuario);
            data.append('accion','firma-quien-cubre');
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
  <div class="cardAG">

  <div class="row">

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Permisos</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Firmar Permiso</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-12">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Firmar Permiso</h3>
  <hr> 
  </div>
  </div>
  </div>

  
  <div class="col-12">
  <div class="row">

  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-1 mt-1">
    <label class="text-secondary">ESTACIÓN:</label>
    <br><?= $Estacion; ?>
  </div>
  
  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-1 mt-1">
    <label class="text-secondary">COLABORADOR:</label>
    <br><?= $nameUSUR; ?>
  </div>
  
  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-1 mt-1">
  <label class="text-secondary">DÍAS TOMADOS:</label>
  <br><?= $diastomados; ?>
  </div>
  </div>
  </div>

  <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-1 mt-1">
  <div class="row"> 
  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1 mt-1">
  <label class="text-secondary">DEL:</label>
  <br><?=$ClassHerramientasDptoOperativo->FormatoFecha($FechaInicio); ?>
  </div>
  
  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1 mt-1">
  <label class="text-secondary">HASTA:</label>
  <br><?=$ClassHerramientasDptoOperativo->FormatoFecha($FechaTermino); ?>
  </div>
  
  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1 mt-1">
  <label class="text-secondary">MOTIVO:</label>
  <br><?= $Motivo; ?>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1 mt-1">
  <label class="text-secondary">OBSERVACIONES:</label>
  <br><?= $observaciones; ?>
  </div>

  </div>
  </div>

  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-1 mt-1">
  <div class="row">

  <div class="col-12">
  <label class="text-secondary">ESTACION DE QUIEN CUBRE:</label>
  <br><?= $nameES; ?>
  </div>

  <div class="col-12">
  <label class="text-secondary">QUIEN CUBRE:</label>
  <br><?= $nameUSU; ?>
  </div>

  </div>
  </div>

  </div>

  <hr>

  <div class="row">

    <?php
    $sql_firma = "SELECT * FROM op_rh_permisos_firma WHERE id_permiso = '" . $GET_idReporte . "' ";
    $result_firma = mysqli_query($con, $sql_firma);
    $numero_firma = mysqli_num_rows($result_firma);
    
    while ($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)) {
    $explode = explode(' ', $row_firma['fecha']);
   
    if ($row_firma['tipo_firma'] == "A") {
    $TipoFirma = "NOMBRE Y FIRMA DEL QUE SOLICITA";
    $Detalle = '<div class="border-0 p-4 text-center"><img src="'.RUTA_IMG_Firma.''.$row_firma['firma'].'" width="70%"></div>';

    } else if ($row_firma['tipo_firma'] == "B") {
    $TipoFirma = "NOMBRE Y FIRMA DEL PERSONAL QUE CUBRE";
    $Detalle = '<div class="border-0 p-4 text-center"><img src="'.RUTA_IMG_Firma.''.$row_firma['firma'].'" width="70%"></div>';

    } else if ($row_firma['tipo_firma'] == "C") {
    $TipoFirma = "NOMBRE Y FIRMA DE VoBo";
    $Detalle = '<div class="border-0 text-center p-2"><small>La solicitud de permiso se firmó por un medio electrónico.</br> <b>Fecha: ' . $ClassHerramientasDptoOperativo->FormatoFecha($explode[0]) . ', ' . date("g:i a", strtotime($explode[1])) . '</b></small></div>';

    }

    $datosUsuario = $ClassHerramientasDptoOperativo->obtenerDatosUsuario($row_firma['id_usuario']);
    $NomUsuario = $datosUsuario['nombre'];

    echo '  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-1 mt-1">
    <table class="custom-table" style="font-size: 14px;" width="100%">
    <thead class="tables-bg">
    <tr> <th class="align-middle text-center">'.$NomUsuario.'</th> </tr>
    </thead>
    <tbody class="bg-light">
    <tr>
    <th class="align-middle text-center no-hover2">'.$Detalle.'</th>
    </tr>
  
    <tr>
    <th class="align-middle text-center no-hover2">'.$TipoFirma.'</th>
    </tr>
    
    </tbody>
    </table>
    </div>';
    }
  

    if ($firmaB == 0) {
    if ($Session_IDUsuarioBD == $idComodin) {
    ?>
    <!---------- FIRMA ---------->
    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-1 mt-1">
    <table class="custom-table" style="font-size: 14px;" width="100%">
    <thead class="tables-bg">
    <tr> <th class="align-middle text-center">FIRMA DEL PERSONAL QUE CUBRE</th> </tr>
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
    <div class="text-end "><button type="button" class="btn btn-labeled2 btn-success pb-0 mb-0" onclick="Firmar(<?= $GET_idReporte; ?>,'B',<?=$Session_IDUsuarioBD?>)">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar firma</button>
    </div>
    </div>

    <?php
    } else if ($Session_IDUsuarioBD == 318) {
    echo '<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mt-2 mb-3"><div class="text-center alert alert-warning" role="alert">
   ¡Aun no es posible firmar! <br> El personal que cubre no ha firmado el formato para poder finalizar la solicitud.</div>';

    } else {
    echo '<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mt-2 mb-3"><div class="text-center alert alert-warning" role="alert">
    ¡No cuentas con los permisos para firmar!
    </div>';
    }

    } else if ($firmaC == 0) {
    if ($Session_IDUsuarioBD == 318) {
    ?>

    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-1 mt-1">
    <div class="table-responsive">
    <table class="custom-table" width="100%">
    <thead class="tables-bg">
    <tr> <th class="align-middle text-center">FIRMA DE VOBO</th> </tr>
    </thead>
    <tbody>
    <tr>
    <th class="align-middle text-center bg-white no-hover">
    <h4 class="text-primary text-center">Token Móvil</h4>
    <small class="text-secondary" style="font-size: .75em;">Agregue el token enviado a su número de teléfono o de clic en el siguiente botón para crear uno:</small>
    <br>
    <button type="button" class="btn btn-labeled2 btn-success text-white mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,1)" style="font-size: .85em;">
    <span class="btn-label2"><i class="fa-solid fa-comment-sms"></i></span>Crear nuevo token SMS</button>

    <button type="button" class="btn btn-labeled2 btn-success text-white mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,2)" style="font-size: .85em;">
    <span class="btn-label2"><i class="fa-brands fa-whatsapp"></i></span>Crear nuevo token Whatsapp</button>
    </th>
    </tr>

    <tr class="no-hover">
    <th class="align-middle text-center bg-white p-0">
    <div class="input-group">
    <input type="text" class="form-control border-0" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
    <div class="input-group-append">
    <button class="btn btn-outline-success" type="button" onclick="FirmarPermiso(<?= $GET_idReporte;?>,'C')">Firmar solicitud</button>
    </div>
    </div>
    </th>
    </tr>
    </tbody>
    </table>
    </div>
    </div>

    <?php
    } else {
    echo '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mt-2 mb-3"><div class="text-center alert alert-warning" role="alert">
    ¡No cuentas con los permisos para firmar!
    </div>';
    }

    }
    ?>

    </div>
    </div>
    </div>

    </div>
    </div>
    </div>
    </div>



    <!---------- MODAL ----------> 
    <div class="modal fade" id="ModalFinalizado" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-body">

    <h5 class="text-info">El token fue validado correctamente.</h5>
    <div class="text-secondary">El permiso fue firmada.</div>

    <div class="text-end">
    <button type="button" class="btn btn-primary" onclick="Regresar()">Aceptar</button>
    </div>

    </div>
    </div>
    </div>
    </div>


    <!---------- MODAL2 ----------> 
    <div class="modal fade" id="ModalError" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-body">

    <h5 class="text-danger">El token no fue aceptado, vuelva a generar uno nuevo o inténtelo mas tarde</h5>
    <div class="text-secondary">El permiso no fue firmada.</div>

    <div class="text-end">
    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
    </div>

    </div>
    </div>
    </div>
    </div>


    <script type="text/javascript">

        var wrapper = document.getElementById("signature-pad");

        var canvas = wrapper.querySelector("canvas");
        var signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)'
        });

        function resizeCanvas() {

            var ratio = Math.max(window.devicePixelRatio || 1, 1);

            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);

            signaturePad.clear();
        }

        window.onresize = resizeCanvas;
        resizeCanvas();

    </script>

    <!---------- FUNCIONES - NAVBAR ---------->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</body>

</html>