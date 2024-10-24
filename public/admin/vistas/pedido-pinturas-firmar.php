<?php
require ('app/help.php');

if ($Session_IDUsuarioBD == "") {
  header("Location:" . PORTAL . "");
}

$idReporte = $GET_idReporte;

$sql_pedido = "SELECT * FROM op_pedido_pinturas_complementos WHERE id = '" . $idReporte . "' ";
$result_pedido = mysqli_query($con, $sql_pedido);
$numero_pedido = mysqli_num_rows($result_pedido);
while ($row_pedido = mysqli_fetch_array($result_pedido, MYSQLI_ASSOC)) {
  $fecha = $row_pedido['fecha'];
  $estatus = $row_pedido['status'];
  $observaciones = $row_pedido['observaciones'];
}

$explode = explode(' ', $fecha);
$fechacompleta = FormatoFecha($explode[0]) . ', ' . date('g:i a', strtotime($explode[1]));

function Personal($idusuario, $con)
{
  $sql = "SELECT nombre FROM tb_usuarios WHERE id = '" . $idusuario . "' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $nombre = $row['nombre'];
  }
  return $nombre;
}
?>

<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dirección de operaciones</title>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">


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
        "idVal": idVal
      };

      $.ajax({
        data: parametros,
        url: '../../public/admin/modelo/token-pedido-pinturas-complementos.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          $(".LoaderPage").hide();

          if (response == 1) {
            //Dentro de la condición cuando se manda la alerta
            alertify.success('El token fue enviado por mensaje');
            alertify.warning('Debera esperar 30 seg para volver a crear un nuevo token');
            // Deshabilitar los botones y guardar el tiempo en localStorage
            var disableTime = new Date().getTime();
            localStorage.setItem('disableTime', disableTime);
            // Deshabilitar los botones
            document.getElementById('btn-email').disabled = true;
            document.getElementById('btn-telegram').disabled = true;
            // Define el tiempo para habilitar los botones
            setTimeout(function () {
              document.getElementById('btn-email').disabled = false;
              document.getElementById('btn-telegram').disabled = false;
            }, 30000); // 60000 milisegundos = 60 segundos

          } else {
            alertify.error('Error al crear el token');
          }

        }
      });

    }

    function FirmarSolicitud(idReporte, tipoFirma) {

      var TokenValidacion = $('#TokenValidacion').val();

      var parametros = {
        "idReporte": idReporte,
        "tipoFirma": tipoFirma,
        "TokenValidacion": TokenValidacion
      };

      if (TokenValidacion != "") {
        $('#TokenValidacion').css('border', '');

        $(".LoaderPage").show();

        $.ajax({
          data: parametros,
          url: '../../public/admin/modelo/firmar-pedido-pinturas-complementos.php',
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
              alertify.error('Error al firmar la solicitud');
            }

          }
        });

      } else {
        $('#TokenValidacion').css('border', '2px solid #A52525');
      }

    }
    // Verificar el tiempo guardado en localStorage al cargar la página
    window.onload = function () {
      var disableTime = localStorage.getItem('disableTime');
      if (disableTime) {
        var currentTime = new Date().getTime();
        var timeDifference = currentTime - disableTime;

        // Si han pasado menos de 60 segundos, deshabilitar los botones
        if (timeDifference < 30000) {
          document.getElementById('btn-sms').disabled = true;
          document.getElementById('btn-whatsapp').disabled = true;

          // Calcular el tiempo restante y volver a habilitar los botones después del tiempo restante
          var remainingTime = 30000 - timeDifference;
          setTimeout(function () {
            document.getElementById('btn-sms').disabled = false;
            document.getElementById('btn-whatsapp').disabled = false;
            localStorage.removeItem('disableTime');
          }, remainingTime);
        }
      }
    }

    function CrearTokenEmail(idReporte){
    $(".LoaderPage").show();

    var parametros = {
    "idReporte" : idReporte
    };

    $.ajax({
    data:  parametros,
    url: '../../public/admin/modelo/token-email-pedido-pinturas.php',
    type:  'post', 
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    $(".LoaderPage").hide();

   if(response == 1){
   alertify.message('El token fue enviado por correo electrónico');   
   }else{
   alertify.error('Error al crear el token');   
   }
 
    }
    });
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
        
        <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
          <ol class="breadcrumb breadcrumb-caret">
            <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
                  class="fa-solid fa-chevron-left"></i>
                Pedido de Pinturas</a></li>
            <li aria-current="page" class="breadcrumb-item active text-uppercase">
              Firmar pedido de pinturas
            </li>
          </ol>
        </div>
        <div class="row">
          <div class="col-12">
            <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
              Firmar pedido de pinturas
            </h3>
          </div>

        </div>
        <hr>

        <div class="row">
<div class="col-12">
  <span class="badge rounded-pill tables-bg mb-3 text-end float-end"><?=$fechacompleta?></span>
  </div>
  </div>
  
        <div class="table-responsive">
          <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
            <thead class="tables-bg">
              <tr>
                <th class="text-center align-middle">#</th>
                <th class="align-middle text-center">Unidad</th>
                <th class="align-middle text-center">Producto</th>
                <th class="align-middle text-center">Piezas</th>
                <th class="align-middle text-center">¿Para que?</th>
              </tr>
            </thead>
            <tbody class="bg-light">
              <?php
              $sql_lista = "SELECT * FROM op_pedido_pinturas_detalle WHERE id_pedido = '" . $idReporte . "' ";
              $result_lista = mysqli_query($con, $sql_lista);
              $numero_lista = mysqli_num_rows($result_lista);
              $ToPiezas = 0;
              if ($numero_lista > 0) {
                $num = 1;
                while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
                  $id = $row_lista['id'];

                  $ToPiezas = $ToPiezas + $row_lista['piezas'];

                  echo '<tr>';
                  echo '<th class="no-hover2 align-middle text-center">' . $num . '</th>';
                  echo '<td class="no-hover2 align-middle">' . $row_lista['unidad'] . '</td>';
                  echo '<td class="no-hover2 align-middle">' . $row_lista['producto'] . '</td>';
                  echo '<td class="no-hover2 align-middle text-center">' . $row_lista['piezas'] . '</td>';
                  echo '<td class="no-hover2 align-middle">' . $row_lista['detalle'] . '</td>';
                  echo '</tr>';

                  $num++;
                }
                echo '<tr>
                        <th colspan="3" class="text-end no-hover2"><b>Total piezas:</b></th>
                        <td colspan="2" class="text-start no-hover2"><b>' . $ToPiezas . '</b></td>
                      </tr>';

              } else {
                echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
        <div class="mt-3">
          <div class="table-responsive">
            <table class="custom-table " style="font-size: .8em;" width="100%">
              <thead class="tables-bg">
                <tr>
                  <th class="text-center align-middle">Observaciones</th>
                </tr>
              </thead>
              <tbody class="bg-light">
                <tr>
                  <th class="no-hover2 p-0">
                    <textarea class="bg-light form-control border-0" style="height:100px;"
                      onkeyup="EditObservaciones(this,<?= $GET_idReporte; ?>)" disabled><?= $observaciones ?></textarea>
                  </th>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <br>
        <div class="mb-2 text-secondary fw-bold">FIRMAS:</div>
        <hr>
        <div class="row">
          <?php if ($Session_IDUsuarioBD == 19) { ?>
            <div class="col-xl-5 col-lg-5 col-md-6 col-sm-12">
              <div class="table-responsive">
                <table class="custom-table" width="100%">
                  <thead class="tables-bg">
                    <tr>
                      <th class="align-middle text-center">FIRMA</th>
                    </tr>
                  </thead>
                  <tbody class="bg-light">

                    <tr>
                      <th class="align-middle text-center no-hover2">
                        <h4 class="text-primary text-center">Token Móvil</h4>
                        <small class="text-secondary" style="font-size: .75em;">Agregue el token enviado a su
                          número de teléfono o de clic en el siguiente botón para crear uno:</small>
                        <br>

                        <!--
                        <button id="btn-sms" type="button" class="btn btn-labeled2 btn-success text-white mt-2"
                          onclick="CrearToken(<?= $GET_idReporte; ?>,1)" style="font-size: .85em;">
                          <span class="btn-label2"><i class="fa-solid fa-comment-sms"></i></span>Crear nuevo token
                          SMS</button>

                        <button id="btn-whatsapp" type="button" class="btn btn-labeled2 btn-success text-white mt-2"
                          onclick="CrearToken(<?= $GET_idReporte; ?>,2)" style="font-size: .85em;">
                          <span class="btn-label2"><i class="fa-brands fa-whatsapp"></i></span>Crear nuevo token
                          Whatsapp</button>
          -->

              <button id="btn-email" type="button" class="btn btn-labeled2 btn-success text-white mt-2" 
                onclick="CrearTokenEmail(<?=$GET_idReporte;?>)" style="font-size: .85em;">
              <span class="btn-label2"><i class="fa-regular fa-envelope"></i></span> Crear nuevo token vía e-mail</button>

              <button id="btn-telegram" type="button" class="btn btn-labeled2 btn-primary text-light mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,3)" style="font-size: .85em;">
              <span class="btn-label2"><i class="fa-brands fa-telegram"></i></span>Crear nuevo token Telegram</button>

                      </th>
                    </tr>

                    <!--
                    <tr>
                      <th class="align-middle text-center no-hover2">
                        <small class="text-danger" style="font-size: .75em;">Nota: En caso de no recibir el token de
                          WhatsApp, agrega el número <b>+1 555-617-9367</b><br>
                          a tus contactos y envía un mensaje por WhatsApp a ese número con la palabra "OK".
                        </small>
                      </th>
                    </tr>
                    <tr>
          -->
                      <th class="align-middle text-center p-0 no-hover2">
                        <div class="input-group">
                          <input type="text" class="form-control border-0" placeholder="Token de seguridad"
                            aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
                          <div class="input-group-append">
                            <button class="btn btn-outline-success border-0" type="button"
                              onclick="FirmarSolicitud(<?= $GET_idReporte ?>,'B')">Firmar solicitud</button>
                          </div>
                        </div>
                      </th>
                    </tr>
                  </tbody>
                </table>

              </div>

            </div>
          <?php } ?>


          <?php

          $sql_firma = "SELECT * FROM op_pedido_pinturas_complementos_firma WHERE id_pedido = '" . $idReporte . "' ";
          $result_firma = mysqli_query($con, $sql_firma);
          $numero_firma = mysqli_num_rows($result_firma);
          while ($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)):
            if ($row_firma['tipo_firma'] == "A"):
              $TipoFirma = "NOMBRE Y FIRMA DEL ENCARGADO";
              $Detalle = '<img src="../../imgs/firma/' . $row_firma['firma'] . '" width="70%">';
            endif; ?>

            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
              <div class="table-responsive">
                <table class="custom-table " style="font-size: .8em;" width="100%">
                  <thead class="tables-bg">
                    <tr>
                      <th class="no-hover2 text-center align-middle">Nombre y firma del Encargado</th>
                    </tr>
                  </thead>
                  <tbody class="bg-light">
                    <tr>
                      <th class="no-hover2 text-center">
                        <?= $Detalle ?>
                      </th>
                    </tr>
                    <tr>
                      <th class="no-hover2 text-center">
                        <?= Personal($row_firma['id_usuario'], $con) ?>
                      </th>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

          <?php endwhile; ?>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalFinalizado">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="margin-top: 83px;">
        <div class="modal-body">
          <h5 class="text-info">El token fue validado correctamente.</h5>
          <div class="text-secondary">El pedido de pinturas fue firmado.</div>
          <div class="text-end">
            <button type="button" class="btn btn-primary" onclick="Regresar()">Aceptar</button>
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalError">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="margin-top: 83px;">
        <div class="modal-body">

          <h5 class="text-danger">El token no fue aceptado, vuelva a generar uno nuevo o inténtelo mas tarde </h5>
          <div class="text-secondary">El pedido de pinturas no fue firmado.</div>


          <div class="text-end">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
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