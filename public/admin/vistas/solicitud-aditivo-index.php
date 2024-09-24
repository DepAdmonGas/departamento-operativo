<?php
require ('app/help.php');

if ($Session_IDUsuarioBD == "") {
  header("Location:" . PORTAL . "");
}

function ToSolicitud($idEstacion, $con)
{

  $sql_lista = "SELECT * FROM op_solicitud_aditivo WHERE id_estacion = '" . $idEstacion . "' ORDER BY orden_compra DESC ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);
  $sumatoria = 0;
  $valor = 0;
  while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
    $idSolicitud = $row_lista['id'];
    $fecha_del_dia = date("Y-m-d");
    $fechaMas = date("Y-m-d", strtotime($row_lista['fecha'] . "+ 15 days"));
    $fecha_actual = strtotime($fecha_del_dia);
    $fecha_entrada = strtotime($fechaMas);


    if ($row_lista['status'] == 1) {

      if ($fecha_actual >= $fecha_entrada) {
        $valor = 0;
      } else {

        $sql_lista2 = "SELECT id FROM op_solicitud_aditivo_firma WHERE id_reporte = '" . $idSolicitud . "' ";
        $result_lista2 = mysqli_query($con, $sql_lista2);
        $numero_lista2 = mysqli_num_rows($result_lista2);

        if ($numero_lista2 > 0) {
          $valor = 0;
        } else {
          $valor = 1;
        }

      }

    } else if ($row_lista['status'] == 0) {
      $valor = 1;
    }

    $sumatoria += $valor;

  }

  return $sumatoria;
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
  <link href="<?= RUTA_CSS2; ?>navbar-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  <script src="<?= RUTA_JS ?>size-window.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

<!---------- LIBRERIAS DEL DATATABLE ---------->
<link
    href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css"
    rel="stylesheet">

  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");
      $('[data-toggle="tooltip"]').tooltip();
      sizeWindow();

      if (sessionStorage) {
        if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {
          idEstacion = sessionStorage.getItem('idestacion');
          pedidoAditivo(idEstacion);
          
        }
      }
    });

    function pedidoAditivo(idEstacion) {
      let targets;
      targets = [5,6,7];
      sessionStorage.setItem('idestacion', idEstacion);
      sizeWindow();
      $('#ListaSolicitud').load('../public/admin/vistas/lista-solicitud-aditivo.php?idEstacion=' + idEstacion, function () {
        $('#tabla-principal').DataTable({
          "language": {
            "url": '<?= RUTA_JS2 ?>' + "/es-ES.json"
          },
          "order": [[0, "desc"]],
          "lengthMenu": [15, 30, 50, 100],
          "columnDefs": [
            { "orderable": false, "targets": targets },
            { "searchable": false, "targets": targets }
          ]
        });
      });
    }

    function Regresar() {
      window.history.back();
    }

    function SelEstacion(idEstacion) {
      sizeWindow();
      sessionStorage.setItem('idestacion', idEstacion);
      pedidoAditivo(idEstacion);
      
    }

    function ModalComentario(idEstacion, id) {
      $('#ModalComentario').modal('show');
      $('#DivContenidoComentario').load('../public/admin/vistas/modal-comentarios-solicitud-aditivo.php?idReporte=' + id + '&idEstacion=' + idEstacion);
    }

    function GuardarComentario(idEstacion, idReporte) {

      var Comentario = $('#Comentario').val();

      var parametros = {
        "idReporte": idReporte,
        "Comentario": Comentario
      };

      if (Comentario != "") {
        $('#Comentario').css('border', '');

        $.ajax({
          data: parametros,
          url: '../public/admin/modelo/agregar-comentario-solicitud-aditivo.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {

            if (response == 1) {
              $('#Comentario').val('');
              SelEstacion(idEstacion)
              sizeWindow()
              $('#DivContenidoComentario').load('../public/admin/vistas/modal-comentarios-solicitud-aditivo.php?idReporte=' + idReporte + '&idEstacion=' + idEstacion);
            } else {
              alertify.error('Error al eliminar la solicitud');
            }

          }
        });

      } else {
        $('#Comentario').css('border', '2px solid #A52525');
      }
    }

    function ModalDetalle(id) {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('../public/corte-diario/vistas/modal-detalle-solicitud-aditivo.php?idReporte=' + id);
      //$('#ContenidoModal').load('../public/admin/vistas/modal-detalle-solicitud-aditivo.php?idReporte=' + id);
    }

    function Firmar(id) {
      window.location.href = "solicitud-aditivo-firmar/" + id;
    }

    function Pago(idEstacion, id) {
      $('#ModalComentario').modal('show');
      $('#DivContenidoComentario').load('../public/admin/vistas/modal-pagos-solicitud-aditivo.php?idReporte=' + id + '&idEstacion=' + idEstacion);
    }

    function AgregarPago(idEstacion, idReporte) {

      var data = new FormData();
      var url = '../public/admin/modelo/agregar-pago-solicitud-aditivo.php';

      Documento = document.getElementById("Documento");
      Documento_file = Documento.files[0];
      Documento_filePath = Documento.value;

      if (Documento_filePath != "") {
        $('#Documento').css('border', '');

        data.append('idReporte', idReporte);
        data.append('Documento_file', Documento_file);

        $(".LoaderPage").show();

        $.ajax({
          url: url,
          type: 'POST',
          contentType: false,
          data: data,
          processData: false,
          cache: false
        }).done(function (data) {

          if (data == 1) {
            $(".LoaderPage").hide();
            Pago(idEstacion, idReporte);
            SelEstacion(idEstacion)
            sizeWindow()
            alertify.success('Pago agregado exitosamente.');

          } else {
            $(".LoaderPage").hide();
            alertify.error('Error al guardar pago');
          }

        });

      } else {
        $('#Documento').css('border', '2px solid #A52525');
      }

    }

    function DescargarPDF(idReporte) {
      window.location.href = "../solicitud-aditivo-pdf/" + idReporte;
    }


    function EliminarDoc(idReporte, idEstacion) {

      var parametros = {
        "idReporte": idReporte
      };


      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: '../public/admin/modelo/eliminar-pago-solicitud-aditivo.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {

              if (response == 1) {

                Pago(idEstacion, idReporte);
                SelEstacion(idEstacion);
                sizeWindow();
                alertify.success('solicitud eliminada exitosamente.');

              } else {
                alertify.error('Error al eliminar la solicitud');
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();


    }


  </script>
</head>

<body class="bodyAG">

  <div class="LoaderPage"></div>

  <!---------- CONTENIDO Y BARRA DE NAVEGACION ---------->
  <div class="wrapper">

    <!---------- BARRA DE NAVEGACION ---------->
    <nav id="sidebar">

      <div class="sidebar-header text-center">
        <img class="" src="<?= RUTA_IMG_LOGOS . "Logo.png"; ?>" style="width: 100%;">
      </div>

      <ul class="list-unstyled components">

        <li>
          <a class="pointer" href="<?= SERVIDOR_ADMIN ?>">
            <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i>Menu
          </a>
        </li>

        <li>
          <a class="pointer" onclick="Regresar()">
            <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
          </a>
        </li>



        <?php
        $sql_listaestacion = "SELECT id, nombre, numlista FROM tb_estaciones WHERE numlista <= 8 ORDER BY numlista ASC";
        $result_listaestacion = mysqli_query($con, $sql_listaestacion);
        while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
          $id = $row_listaestacion['id'];
          $estacion = $row_listaestacion['nombre'];


          $ToSolicitud = ToSolicitud($id, $con);

          if ($ToSolicitud > 0) {
            $Nuevo = '<div class="float-end"><span class="badge bg-danger text-white rounded-circle"><small>' . $ToSolicitud . '</small></span></div>';
          } else {
            $Nuevo = '';
          }

 echo '  
            <li>
              <a class="pointer" onclick="SelEstacion('.$id.')">
              <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
              '.$Nuevo.' '.$estacion.'
              </a>
            </li>';
          
          
        }

        ?>
      </ul>
    </nav>


    <!---------- DIV - CONTENIDO ---------->
    <div id="content">
      <!---------- NAV BAR - PRINCIPAL (TOP) ---------->
      <nav class="navbar navbar-expand navbar-light navbar-bg">

        <i class="fa-solid fa-bars menu-btn rounded pointer" id="sidebarCollapse"></i>

        <div class="pointer">
          <a class="text-dark" onclick="history.back()">Pedido de aditivo</a>
        </div>


        <div class="navbar-collapse collapse">

          <div class="dropdown-divider"></div>

          <ul class="navbar-nav navbar-align">

            <li class="nav-item dropdown">
              <a class=" dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>


              <a class="nav-link dropdown-toggle d-none d-sm-inline-block pointer" data-bs-toggle="dropdown">

                <img src="<?= RUTA_IMG_ICONOS . "usuarioBar.png"; ?>" class="avatar img-fluid rounded-circle" />

                <span class="text-dark" style="padding-left: 10px;">
                  <?= $session_nompuesto; ?>
                </span>
              </a>

              <div class="dropdown-menu dropdown-menu-end">

                <div class="user-box">

                  <div class="u-text">
                    <p class="text-muted">Nombre de usuario:</p>
                    <h4><?= $session_nomusuario; ?></h4>
                  </div>

                </div>


                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= PERFIL_ADMIN ?>">
                  <i class="fa-solid fa-user" style="padding-right: 5px;"></i>Perfil
                </a>

                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?= RUTA_SALIR2 ?>salir">
                  <i class="fa-solid fa-power-off" style="padding-right: 5px;"></i> Cerrar Sesión
                </a>

              </div>
            </li>

          </ul>
        </div>

      </nav>

      <!---------- CONTENIDO PAGINA WEB---------->
      <div class="contendAG">
        <div class="row">
            <div class="col-12" id="ListaSolicitud"></div>
        </div>
      </div>
    </div>

  </div>


  <div class="modal" id="Modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div id="ContenidoModal"></div>
      </div>
    </div>
  </div>

  <div class="modal" id="ModalComentario">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div id="DivContenidoComentario"></div>
      </div>
    </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>navbar-functions.js"></script>

  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>


<!---------- LIBRERIAS DEL DATATABLE ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>


</body>

</html>