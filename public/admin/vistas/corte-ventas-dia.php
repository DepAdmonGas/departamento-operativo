<?php
require ('app/help.php');
if ($Session_IDUsuarioBD == ""):
  header("Location:" . PORTAL . "");
endif;

function Firma($idReporte, $detalle, $rutafirma, $con)
{
  $contenido = '';

  $sql_firma = "SELECT 
op_corte_dia_firmas.id AS idFirma,
op_corte_dia_firmas.id_usuario, 
op_corte_dia_firmas.firma,
op_corte_dia_firmas.fecha,
tb_usuarios.nombre
FROM op_corte_dia_firmas
INNER JOIN tb_usuarios
ON op_corte_dia_firmas.id_usuario = tb_usuarios.id WHERE id_reportedia  = '" . $idReporte . "' AND detalle = '" . $detalle . "' ORDER BY idFirma DESC LIMIT 1 ";
  $result_firma = mysqli_query($con, $sql_firma);
  while ($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)):
    $nombre = $row_firma['nombre'];
    $firma = $row_firma['firma'];
    $explode = explode(' ', $row_firma['fecha']);
  endwhile;

  if ($detalle == "Elaboró"):
    $contenido .= '<tr class="text-center">
    <th class="no-hover"><img src="' . $rutafirma . $firma . '" width="150px" height="70px"></th>';
    $contenido .= '</tr>
    <tr>';
    $contenido .= '<th class="text-center no-hover"><b>' . $nombre . '</b></th>';
    $contenido .= '</tr>';

  elseif ($detalle == "Superviso" || $detalle == "VoBo"):
    $Detalle = '<tr class="text-center">
                  <td class="no-hover">
                    <small class="text-secondary">El formato se firmó por un medio electrónico.</br> <b>Fecha: ' . FormatoFecha($explode[0]) . ', ' . date("g:i a", strtotime($explode[1])) . '</b></small>
                  </td>
                </tr>';
    $contenido .= $Detalle;
    $contenido .= '<tr class="">';
    $contenido .= '<th class="text-center no-hover">' . $nombre . '</th>';
    $contenido .= '</tr>';

  endif;
  return $contenido;

}



$sql_dia = "SELECT id_mes,fecha FROM op_corte_dia WHERE id = '" . $GET_idReporte . "' ";
$result_dia = mysqli_query($con, $sql_dia);
while ($row_dia = mysqli_fetch_array($result_dia, MYSQLI_ASSOC)) {
  $idmes = $row_dia['id_mes'];
  $dia = $row_dia['fecha'];
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script type="text/javascript" src="<?php echo RUTA_JS ?>signature_pad.js"></script>

  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");

      Ventas(<?= $GET_idReporte; ?>);
      AceitesLubricantes(<?= $GET_idReporte; ?>);
      Prosegur(<?= $GET_idReporte; ?>);
      TarjetasBancarias(<?= $GET_idReporte; ?>);
      ClientesControlgas(<?= $GET_idReporte; ?>);
      PagoCliente(<?= $GET_idReporte; ?>);
      DifPagoCliente(<?= $GET_idReporte; ?>);
      DiferenciaTotal(<?= $GET_idReporte; ?>);
      Total1234(<?= $GET_idReporte; ?>);

      ListaDocumentos(<?= $GET_idReporte; ?>);

    });

    function Regresar() {
      window.history.back();
    } 

    function Ventas(idReporte) {
      $('#DivConecntradoVentas').html('<div class="text-center"><img width="30px" src="../../../../imgs/iconos/load-img.gif"></div>');
      $('#DivConecntradoVentas').load('../../../../public/admin/vistas/concentrado-ventas.php?idReporte=' + idReporte);
    }

    function AceitesLubricantes(idReporte) {
      $('#DivAceitesLubricantes').html('<div class="text-center"><img width="30px" src="../../../imgs/iconos/load-img.gif"></div>');
      $('#DivAceitesLubricantes').load('../../../../public/admin/vistas/venta-aceites-lubricantes.php?idReporte=' + idReporte);
    }

    function Prosegur(idReporte) {
      $('#DivProsegur').html('<div class="text-center"><img width="30px" src="../../../../imgs/iconos/load-img.gif"></div>');
      $('#DivProsegur').load('../../../../public/admin/vistas/prosegur.php?idReporte=' + idReporte);
    }

    function TarjetasBancarias(idReporte) {
      $('#DivTarjetasBancarias').html('<div class="text-center"><img width="30px" src="../../../../imgs/iconos/load-img.gif"></div>');
      $('#DivTarjetasBancarias').load('../../../../public/admin/vistas/tarjetas-bancarias.php?idReporte=' + idReporte);
    }

    function ClientesControlgas(idReporte) {
      $('#DivControlgas').html('<div class="text-center"><img width="30px" src="../../../../imgs/iconos/load-img.gif"></div>');
      $('#DivControlgas').load('../../../../public/admin/vistas/clientes-controlgas.php?idReporte=' + idReporte);
    }

    function PagoCliente(idReporte) {
      $('#DivPagoClientes').html('<div class="text-center"><img width="30px" src="../../../../imgs/iconos/load-img.gif"></div>');
      $('#DivPagoClientes').load('../../../../public/admin/vistas/pago-clientes.php?idReporte=' + idReporte);
    }

    function DifPagoCliente(idReporte) {

      $('#DifPagoCliente').load('../../../../public/corte-diario/vistas/diferencia-pagocliente-total.php?idReporte=' + idReporte);
    }

    function DiferenciaTotal(idReporte) {

      $('#DiferenciaTotal').load('../../../../public/corte-diario/vistas/diferencia-total.php?idReporte=' + idReporte);
    }

    function Total1234(idReporte) {
      $('#Total1234').load('../../../../public/corte-diario/vistas/totales-1234.php?idReporte=' + idReporte);
    }

    function PDF(idReporte) {

      window.location = "../../../../public/corte-diario/vistas/pdf-corte-ventas.php?idReporte=" + idReporte;

    }

    function ListaDocumentos(idReporte) {
      $('#Documentos').load('../../../../public/admin/vistas/lista-documentos.php?idReporte=' + idReporte);
    }

    function FirmarCorte(idReporte) {


      var ctx = document.getElementById("canvas");
      var image = ctx.toDataURL();
      document.getElementById('base64').value = image;

      var base64 = $('#base64').val();


      var parametros = {
        "base64": base64,
        "idReporte": idReporte
      };

      $.ajax({
        data: parametros,
        url: '../../../../public/admin/modelo/agregar-firma.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {
            location.reload();
          } else {
            alertify.error('Error al firmar el corte')
          }

        }
      });



    }
    function CrearTokenEmail(idReporte){
    $(".LoaderPage").show();

    var parametros = {
    "idReporte" : idReporte
    };

    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/token-email-corte-diario.php',
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



    function CrearToken(idReporte, idVal) {
      $(".LoaderPage").show();

      var parametros = {
        "idReporte": idReporte,
        "idVal": idVal,
        "fecha": '<?= $ClassHerramientasDptoOperativo->FormatoFecha($dia) ?>'
      };

      $.ajax({
        data: parametros,
        url: '../../../../public/admin/modelo/token-ccorte-diario.php',
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
            }, 30000); // 30000 milisegundos = 30 segundos

          } else {
            alertify.error('Error al crear el token');
          }

        }
      });

    }

    function FirmarFormato(idReporte, tipoFirma) {

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
          url: '../../../../public/admin/modelo/firmar-corte-diario.php',
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
      
      <div class="col-12">
          <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
            <ol class="breadcrumb breadcrumb-caret">
              <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
                    class="fa-solid fa-chevron-left"></i>
                  Corte Diario, <?= $ClassHerramientasDptoOperativo->nombreMes($GET_mes) ?> <?= $GET_year ?></a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase">
                Ventas (<?= $ClassHerramientasDptoOperativo->FormatoFecha($dia) ?>)
              </li>
            </ol>
          </div>
          <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                Ventas (<?= $ClassHerramientasDptoOperativo->FormatoFecha($dia) ?>)
              </h3>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mt-2">
              <button type="button" class="btn btn-labeled2 btn-danger float-end ms-2"
                onclick="PDF(<?= $GET_idReporte ?>)">
                <span class="btn-label2"><i class="fa-solid fa-file-pdf"></i></span>PDF</button>
            </div>

          </div>
          <hr>
        </div>


          <!---------- TABLA - CONCENTRADO DE VENTAS ---------->

          <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 mb-3">
            <div class="mb-3">
              <div id="DivConecntradoVentas"></div>
            </div>
            <!---------- TABLA - Relacion de venta de aceites y lubricantes ---------->


            <div class="mb-3">
              <div id="DivAceitesLubricantes"></div>
            </div>
            <!---------- TABLA - Documentos ---------->

            <div class="mb-3">
              <div id="Documentos"></div>
            </div>
          </div>


          <!---------- TABLA - Prosegur ---------->
          <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
            <div class="mb-3">
              <div id="DivProsegur"></div>
            </div>
            <!---------- TABLA - Monederos y bancos ---------->

            <div class="mb-3">
              <div id="DivTarjetasBancarias"></div>
            </div>
            <!---------- TABLA - Cleintes (ATIO) ---------->

            <div class="mb-3">
              <div id="DivControlgas"></div>
            </div>
            <!---------- TABLA - Totales t diferecnias (1+2+3, B-C) ---------->

            <div class="mt-3">
              <div class="table-responsive">
                <table class="custom-table" style="font-size: 12.5px;" width="100%">

                  <tr class="bg-white">
                    <th class="no-hover">C TOTAL (1+2+3)</th>
                    <td class="align-middle pointer no-hover" id="Total1234"></td>
                  </tr>

                  <tr class="bg-white">
                    <th class="no-hover">DIFERENCIA (B-C)</th>
                    <td class="align-middle pointer no-hover" id="DiferenciaTotal"></td>
                  </tr>

                </table>
              </div>
            </div>
            <!---------- TABLA - Pago de clientes ---------->

            <div class="mb-3">
              <div id="DivPagoClientes"></div>
            </div>

            <div class="mb-3">
              <div class="table-responsive">
                <table class="custom-table" style="font-size: 12.5px;" width="100%">

                  <tr class="bg-white">
                    <td class="no-hover">DIF PAGO DE CLIENTES</td>
                    <td class="no-hover align-middle text-end" id="DifPagoCliente"></td>
                    <td class="no-hover">(4-5)</td>
                  </tr>
                </table>
              </div>
            </div>
            <!---------- Observaciones ---------->
            <div class="mb-3">
              <div class="table-responsive">
                <table class="custom-table " style="font-size: .8em;" width="100%">
                  <thead class="tables-bg">
                    <tr>
                      <th class="text-center align-middle">Observaciones</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white">
                    <tr>
                      <th class="no-hover p-0">
                        <?php
                        $observaciones = '';
                        $sql_observaciones = "SELECT * FROM op_observaciones WHERE idreporte_dia = '" . $GET_idReporte . "' ";
                        $result_observaciones = mysqli_query($con, $sql_observaciones);
                        while ($row_observaciones = mysqli_fetch_array($result_observaciones, MYSQLI_ASSOC)) {
                          $observaciones = $row_observaciones['observaciones'];
                        }
                        ?>
                        <textarea class="bg-white form-control border-0" style="height:200px;"
                          disabled><?= $observaciones ?></textarea>
                      </th>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

          </div>


          <div class="col-12">


        <hr>
 
</div>
        <?php

        function ValidaFirma($idReporte, $detalle, $con)
        {

          $sql_firma = "SELECT 
                op_corte_dia_firmas.id_usuario, 
                op_corte_dia_firmas.firma,
                tb_usuarios.nombre
                FROM op_corte_dia_firmas
                INNER JOIN tb_usuarios
                ON op_corte_dia_firmas.id_usuario = tb_usuarios.id WHERE id_reportedia  = '" . $idReporte . "' AND detalle = '" . $detalle . "' ";
          $result_firma = mysqli_query($con, $sql_firma);
          $numero_lista = mysqli_num_rows($result_firma);

          return $numero_lista;
        }

        $Elaboro = ValidaFirma($GET_idReporte, 'Elaboró', $con);
        $Superviso = ValidaFirma($GET_idReporte, 'Superviso', $con);
        $VoBo = ValidaFirma($GET_idReporte, 'VoBo', $con);
        ?>


          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
            <div class="table-responsive">
              <table class="custom-table" width="100%">
                <thead class="tables-bg">
                  <tr>
                    <th class="align-middle text-center">ELABORÓ</th>
                  </tr>
                </thead>
                <tbody class="bg-white">
                  <?php
                  if ($Elaboro > 0) {
                    $RElaboro = Firma($GET_idReporte, 'Elaboró', RUTA_IMG_Firma, $con);
                    echo $RElaboro;
                  } else {
                    echo '<th class="p-2"><small>No se encontró firma del corte diario</small></th>';
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
            <div class="table-responsive">
              <table class="custom-table" width="100%">
                <thead class="tables-bg">
                  <tr>
                    <th class="align-middle text-center">SUPERVISÓ</th>
                  </tr>
                </thead>
                <tbody class="bg-white">
                  <?php
                  if ($Superviso > 0) {
                    $RSuperviso = Firma($GET_idReporte, 'Superviso', RUTA_IMG_Firma, $con);
                    echo $RSuperviso;
                  } else {
                    if ($Session_IDUsuarioBD == 19) {
                      ?>
                      <tr>
                        <th class="align-middle text-center no-hover2">
                          <h4 class="text-primary text-center">Token Móvil</h4>
                          <small class="text-secondary" style="font-size: .75em;">Agregue el token enviado a su
                            número de teléfono o de clic en el siguiente botón para crear uno:</small>
                          <br><!--
                          <button id="btn-sms" type="button" class="btn btn-labeled2 btn-success text-white mt-2"
                            onclick="CrearToken(<?= $GET_idReporte; ?>,1)" style="font-size: .85em;">
                            <span class="btn-label2"><i class="fa-solid fa-comment-sms"></i></span>Crear nuevo token
                            SMS</button>

                          <button id="btn-whatsapp" type="button" class="btn btn-labeled2 btn-success text-white mt-2"
                            onclick="CrearToken(<?= $GET_idReporte; ?>,2)" style="font-size: .85em;">
                            <span class="btn-label2"><i class="fa-brands fa-whatsapp"></i></span>Crear nuevo token
                            Whatsapp</button>-->

                            <button id="btn-email" type="button" class="btn btn-labeled2 btn-success text-white mt-2" 
                            onclick="CrearTokenEmail(<?=$GET_idReporte;?>)" style="font-size: .85em;">
                            <span class="btn-label2"><i class="fa-regular fa-envelope"></i></span> Crear nuevo token vía e-mail</button>

                            <button id="btn-telegram" type="button" class="btn btn-labeled2 btn-primary text-light mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,3)" style="font-size: .85em;">
                            <span class="btn-label2"><i class="fa-brands fa-telegram"></i></span>Crear nuevo token Telegram</button>
                        </th>
                      </tr>
                      <tr>
                        <th class="align-middle text-center p-0 no-hover2">
                          <div class="input-group">
                            <input type="text" class="form-control border-0" placeholder="Token de seguridad"
                              aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
                            <div class="input-group-append">
                              <button class="btn btn-outline-success border-0" type="button"
                                onclick="FirmarFormato(<?= $GET_idReporte ?>,'Superviso')">Firmar corte diario</button>
                            </div>
                          </div>
                        </th>
                      </tr>
                      <?php
                    } else {
                      echo '<th class="p-2"><small>¡Falta la Firma de supervisión!</small></th>';
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
            <div class="table-responsive">
              <table class="custom-table" width="100%">
                <thead class="tables-bg">
                  <tr>
                    <th class="align-middle text-center">VO.BO.</th>
                  </tr>
                </thead>
                <tbody class="bg-white">
                  <?php 
                  if ($VoBo > 0) {
                    $RVoBo = Firma($GET_idReporte, 'VoBo', RUTA_IMG_Firma, $con);
                    echo $RVoBo;
                  } else {
                    if ($Session_IDUsuarioBD == 2) {
                      ?>
                      <tr>
                        <th class="align-middle text-center no-hover2">
                          <h4 class="text-primary text-center">Token Móvil</h4>
                          <small class="text-secondary" style="font-size: .75em;">Agregue el token enviado a su
                            número de teléfono o de clic en el siguiente botón para crear uno:</small>
                          <br><!--
                          <button id="btn-sms" type="button" class="btn btn-labeled2 btn-success text-white mt-2"
                            onclick="CrearToken(<?= $GET_idReporte; ?>,1)" style="font-size: .85em;">
                            <span class="btn-label2"><i class="fa-solid fa-comment-sms"></i></span>Crear nuevo token
                            SMS</button>

                          <button id="btn-whatsapp" type="button" class="btn btn-labeled2 btn-success text-white mt-2"
                            onclick="CrearToken(<?= $GET_idReporte; ?>,2)" style="font-size: .85em;">
                            <span class="btn-label2"><i class="fa-brands fa-whatsapp"></i></span>Crear nuevo token
                            Whatsapp</button>-->
                            <button id="btn-email" type="button" class="btn btn-labeled2 btn-success text-white mt-2" 
                            onclick="CrearTokenEmail(<?=$GET_idReporte;?>)" style="font-size: .85em;">
                            <span class="btn-label2"><i class="fa-regular fa-envelope"></i></span> Crear nuevo token vía e-mail</button>

                            <button id="btn-telegram" type="button" class="btn btn-labeled2 btn-primary text-light mt-2" onclick="CrearToken(<?=$GET_idReporte;?>,3)" style="font-size: .85em;">
                            <span class="btn-label2"><i class="fa-brands fa-telegram"></i></span>Crear nuevo token Telegram</button>
                        </th>
                      </tr>
                      <tr>
                        <th class="align-middle text-center p-0 no-hover2">
                          <div class="input-group">
                            <input type="text" class="form-control border-0" placeholder="Token de seguridad"
                              aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
                            <div class="input-group-append">
                              <button class="btn btn-outline-success border-0" type="button"
                                onclick="FirmarFormato(<?= $GET_idReporte ?>,'VoBo')">Firmar corte diario</button>
                            </div>
                          </div>
                        </th>
                      </tr>

                      <?php
                    } else {
                      echo '<th class="p-2"><small>¡Falta la Firma de VOBO!</small></th>';
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>

          </div>

      </div>
    </div>

  </div>




  <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalFinalizado">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="margin-top: 83px;">
        <div class="modal-body">

          <h5 class="text-info">El token fue validado correctamente.</h5>
          <div class="text-secondary">El corte diario fue firmado.</div>


          <div class="text-end">
            <button type="button" class="btn btn-primary" onclick="location.reload();">Aceptar</button>
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
          <div class="text-secondary">El corte diario no fue firmado.</div>


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