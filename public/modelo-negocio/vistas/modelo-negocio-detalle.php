<?php
require 'app/help.php';

$sql_lista = "SELECT * FROM op_modelo_negocio WHERE id = '" . $GET_idReporte . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $Titulo = $row_lista['titulo'];
  $Descripcion = $row_lista['descripcion'];
}
if($Titulo == ''):
$Titulo = 'Sin titulo';
endif;
if($Descripcion == ''):
  $Descripcion = 'Sin descripcion';
  endif;
// Documento
$sql_documento = "SELECT * FROM op_modelo_negocio_documento WHERE id_modelo_negocio = '" . $GET_idReporte . "' ";
$result_documento = mysqli_query($con, $sql_documento);
$numero_documento = mysqli_num_rows($result_documento);
// Comentario
$sql_comentario = "SELECT comentario FROM op_modelo_negocio_comentario WHERE id_modelo_negocio = '" . $GET_idReporte . "' ";
$result_comentario = mysqli_query($con, $sql_comentario);
$numero_comentario = mysqli_num_rows($result_comentario);


$spanAlert = '<i class="fa-regular fa-comment-dots"></i>';
if ($numero_comentario != 0) :
  $spanAlert = '<span class="ms-1 badge bg-danger text-white rounded-circle">
  <small>' . $numero_comentario . '</small>
  </span> ';
endif;
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
      ModeloNegocioVB(<?= $GET_idReporte; ?>);
    });

    function Regresar() {
      window.history.back();
    }

    function ModeloNegocioVB(idReporte) {
      $('#CotenidoVB').load('../public/modelo-negocio/vistas/modelo-negocio-vb.php?idReporte=' + idReporte);
    }

    function CrearToken(idReporte, idVal) {

      $(".LoaderPage").show();

      var parametros = {
        "idReporte": idReporte,
        "idVal": idVal
      };

      $.ajax({
        data: parametros,
        url: '../public/modelo-negocio/modelo/token-modelo-negocio.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          $(".LoaderPage").hide();

          if (response == 1) {
            alertify.message('El token fue enviado por mensaje');
            alertify.warning('Debera esperar 30 seg para volver a crear un nuevo token');
            // Deshabilitar los botones y guardar el tiempo en localStorage
            var disableTime = new Date().getTime();
            localStorage.setItem('disableTime', disableTime);
            // Deshabilitar los botones
            document.getElementById('btn-sms').disabled = true;
            document.getElementById('btn-whatsapp').disabled = true;
            // Define el tiempo para habilitar los botones
            setTimeout(function () {
              document.getElementById('btn-sms').disabled = false;
              document.getElementById('btn-whatsapp').disabled = false;
            }, 30000); // 60000 milisegundos = 60 segundos
          } else {
            alertify.error('Error al crear el token');
          }

        }
      });

    }

    function CrearTokenEmail(idReporte) {
      $(".LoaderPage").show();

      var parametros = {
        "idReporte": idReporte
      };

      $.ajax({
        data: parametros,
        url: '../public/modelo-negocio/modelo/token-email-modelo-negocio.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          $(".LoaderPage").hide();

          if (response == 1) {
            alertify.message('El token fue enviado por correo electrónico');
          } else {
            alertify.error('Error al crear el token');
          }

        }
      });
    }

    function Firmar(idReporte) {

      var TokenValidacion = $('#TokenValidacion').val();

      var parametros = {
        "idReporte": idReporte,
        "TokenValidacion": TokenValidacion
      };

      if (TokenValidacion != "") {
        $('#TokenValidacion').css('border', '');

        $(".LoaderPage").show();

        $.ajax({
          data: parametros,
          url: '../public/modelo-negocio/modelo/firmar-modelo-negocio.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {

            $(".LoaderPage").hide();

            if (response == 1) {

              alertify.message('El Modelo de negocio fue firmado');
              ModeloNegocioVB(idReporte);

            } else {
              alertify.error('Error al firmar el Modelo de negocio');
            }

          }
        });

      } else {
        $('#TokenValidacion').css('border', '2px solid #A52525');
      }

    }

    function GuardarComentario(idReporte) {

      var Comentario = $('#Comentario').val();

      var parametros = {
        "idReporte": idReporte,
        "Comentario": Comentario
      };

      if (Comentario != "") {
        $('#Comentario').css('border', '');

        $.ajax({
          data: parametros,
          url: '../public/modelo-negocio/modelo/comentario-modelo-negocio.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {

            if (response == 1) {
              $('#Comentario').val('');

              alertify.success('Comentario agregado exitosamente');
              comentario(idReporte);
            } else {
              alertify.error('Error al agregar comentario');
            }

          }
        });

      } else {
        $('#Comentario').css('border', '2px solid #A52525');
      }

    }
    function comentario(idReporte) {

      $('#Modal').modal('show');
      $('#ModalContenido').load('../public/modelo-negocio/vistas/modal-comentario.php?idReporte=' + idReporte);
    }

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
    <div class="contendAG container cardAG p-3">
      <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
          <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
            <ol class="breadcrumb breadcrumb-caret">
              <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
                    class="fa-solid fa-chevron-left"></i> Modelo de Negocio</a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase"> Firma
              </li>
            </ol>
          </div>

          <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Firma
              </h3>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
              <button type="button" class="btn btn-labeled2 btn-primary float-end"
                onclick="comentario(<?= $GET_idReporte ?>)">
                <span class="btn-label2"><?= $spanAlert; ?></span> Comentarios
              </button>

            </div>
          </div>

          <hr>
        </div>

        <div class="col-12 col-sm-5 mb-3">
          <div class="text-secondary"><small>Titulo:</small></div>
          <h5><?= $Titulo; ?></h5>

          <div class="text-secondary mt-2"><small>Descripción:</small></div>
          <h6><?= $Descripcion; ?></h6>

          <div class="table-responsive">
            <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
              <thead class="tables-bg">
                <tr>
                  <th class="align-middle">Nombre del archivo</th>
                  <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>pdf.png">
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white">
                <?php
                if ($numero_documento > 0) {
                  while ($row_documento = mysqli_fetch_array($result_documento, MYSQLI_ASSOC)) {

                    $id = $row_documento['id'];

                    echo '<tr>';
                    echo '<th class="align-middle font-weight-light">' . $row_documento['nombre'] . '</th>';
                    echo '<td class="align-middle font-weight-light"><a href="../archivos/modelo-negocio/' . $row_documento['archivo'] . '" download><img src="' . RUTA_IMG_ICONOS . 'pdf.png"></a></td>';
                    echo '</tr>';

                  }
                } else {
                  echo "<tr><th colspan='3' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>

        </div>

        <div class="col-12 col-sm-7">
          <div id="CotenidoVB"></div>
        </div>

      </div>
    </div>

  </div>


  <div class="modal" id="Modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div id="ModalContenido"></div>
      </div>
    </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>


</body>

</html>