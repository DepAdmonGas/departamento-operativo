<?php
require ('app/help.php');

function ToSolicitud($idEstacion, $con)
{
  $sql_lista = "SELECT id FROM op_pedido_papeleria WHERE id_estacion = '" . $idEstacion . "' AND (status >= 1 AND status < 2) ";
  $result_lista = mysqli_query($con, $sql_lista);
  return $numero_lista = mysqli_num_rows($result_lista);
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>selectize.css">
  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">

  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");
      sizeWindow();
      if (sessionStorage) {
        if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {
          idestacion = sessionStorage.getItem('idestacion');
          ListaPedido(idestacion)
        }
      }
    });

    function ListaPedido(idEstacion) {
      let targets;
      targets = [4,5];
      $('#ContenidoPrin').load('../public/admin/vistas/lista-pedido-papeleria.php?idEstacion=' + idEstacion, function () {
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

    function SelEstacion(id) {
      sessionStorage.setItem('idestacion', id);
      sizeWindow();
      ListaPedido(id)
    }

    function SelEstacionReturn(id) {
      ListaPedido(id)
    }


    function ListaPapeleria() {
      let targets;
      targets = [2, 3];
      $('#ContenidoPrin').load('../public/admin/vistas/lista-producto-papeleria.php', function () {
        $('#tabla-principal').DataTable({
          "language": {
            "url": '<?= RUTA_JS2 ?>' + "/es-ES.json"
          },
          "order": [[0, "asc"]],
          "lengthMenu": [15, 30, 50, 100],
          "columnDefs": [
            { "orderable": false, "targets": targets },
            { "searchable": false, "targets": targets }
          ]
        });
      });
    }
    function ModalNevo() {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('../public/admin/vistas/modal-agregar-producto-papeleria.php?idProducto=0');
    }

    function CreateUpdateProducto(idProducto) {
      var Producto = $('#Producto').val();

      if (Producto != "") {
        $('#Producto').css('border', '');

        var parametros = {
          "idProducto": idProducto,
          "Producto": Producto
        };

        $.ajax({
          data: parametros,
          url: '../public/admin/modelo/agregar-editar-papeleria.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {

            if (response == 1) {
              $('#Modal').modal('hide');
              ListaPapeleria()
              sizeWindow()
              if (idProducto == 0) {
                alertify.success('Producto agregado');
              } else {
                alertify.success('Producto editado exitoso');
              }
            } else {
              alertify.error('Error al agregar el producto');
            }

          }
        });


      } else {
        $('#Producto').css('border', '2px solid #A52525');
      }

    }

    function EliminarProducto(id) {

      var parametros = {
        "id": id
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: '../public/admin/modelo/eliminar-producto-papeleria.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {


              if (response == 1) {
                ListaPapeleria()
                sizeWindow()
                alertify.success('Producto eliminado exitosamente');
              } else {
                alertify.error('Error al eliminar el producto');
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

    }

    function EditarProducto(id) {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('../public/admin/vistas/modal-agregar-producto-papeleria.php?idProducto=' + id);
    }
    //------------------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------------------

    function NuevoPedido(idEstacion) {

      var parametros = {
        "idEstacion": idEstacion
      };

      $.ajax({
        data: parametros,
        url: '../public/admin/modelo/agregar-reporte-pedido-papeleria.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 0) {
            alertify.error('Error al agregar el reporte');
          } else {
            $('#Modal').modal('show');
            $('#ContenidoModal').load('../public/admin/vistas/modal-agregar-pedido-papeleria.php?idEstacion=' + idEstacion + '&idReporte=' + response);
            sizeWindow()
            SelEstacion(idEstacion)
          }

        }
      });
    }

    function AgregarItem(idEstacion, idReporte) {

      var Producto = $('#Producto').val();
      var OtroProducto = $('#OtroProducto').val();
      var Piezas = $('#Piezas').val();
      
      
      if (Producto != "") {
        $('#contenido-producto').css('border', '');
      if (Piezas != "") {
        $('#Piezas').css('border', '');

        var parametros = {
          "idEstacion": idEstacion,
          "idReporte": idReporte,
          "Producto": Producto,
          "OtroProducto": OtroProducto,
          "Piezas": Piezas
        };

        $.ajax({
          data: parametros,
          url: '../public/admin/modelo/agregar-producto-pedido-papeleria.php',
          type: 'post',
          beforeSend: function () {
          },
          complete: function () {

          },
          success: function (response) {

            if (response == 1) {
              alertify.success('Registro agregado exitosamente.');

              $('#ContenidoModal').load('../public/admin/vistas/modal-agregar-pedido-papeleria.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
            } else {
              alertify.error('Error al agregar el producto');
            }

          }
        });

      } else {
        $('#Piezas').css('border', '2px solid #A52525');
      }
    } else {
        $('#contenido-producto').css('border', '2px solid #A52525');
      }


    }

    function VerPedido(idEstacion, id) {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('../public/corte-diario/vistas/modal-detalle-pedido-papeleria.php?idReporte=' + id);
      //$('#ContenidoModal').load('../public/admin/vistas/modal-detalle-pedido-papeleria.php?idEstacion=' + idEstacion + '&idReporte=' + id);
    }

    function PedidoPDF(id) {
      window.location.href = "../pedido-papeleria/" + id;
    }

    function EditarPedido(idEstacion, idReporte) {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('../public/admin/vistas/modal-agregar-pedido-papeleria.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
    }

    function EliminarItem(id, idEstacion, idReporte) {

      var parametros = {
        "idItem": id
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: '../public/admin/modelo/eliminar-producto-pedido-papeleria.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {


              if (response == 1) {
                alertify.success('Registro eliminado exitosamente.');

                SelEstacion(idEstacion)
                sizeWindow()
                $('#ContenidoModal').load('../public/admin/vistas/modal-agregar-pedido-papeleria.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
              } else {
                alertify.error('Error al eliminar el pedido');
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

    }

    function FinalizarPedido(idEstacion, idReporte) {

      var parametros = {
        "idReporte": idReporte
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: '../public/corte-diario/modelo/finalizar-pedido-papeleria.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {


              if (response == 1) {
                $('#Modal').modal('hide');
                SelEstacion(idEstacion)
                sizeWindow()
                alertify.success('Pedido finalizado exitosamente');
              } else {
                alertify.error('Error al finalizar el pedido');
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea finalizar el pedido?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();


    }

    function PedidoEntregado(idEstacion, idReporte) {

      var parametros = {
        "idReporte": idReporte,
        "idEstacion": idEstacion
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: '../public/admin/modelo/entregar-pedido-papeleria.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {


              if (response == 1) {
                $('#Modal').modal('hide');
                SelEstacion(idEstacion)
                sizeWindow()
                alertify.success('Pedido entregado a la estación');
              } else {
                alertify.error('Error al entregar el pedido');
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿El pedido fue entregado a la estacion?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();


    }

    //--------------------------------------------------------------------------------
    function EliminarPedido(idEstacion, idReporte) {

      var parametros = {
        "idReporte": idReporte
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: '../public/admin/modelo/eliminar-pedido-papeleria.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {


              if (response == 1) {
                SelEstacion(idEstacion)
                sizeWindow()
                alertify.success('Pedido eliminado exitosamente.');

              } else {
                alertify.error('Error al eliminar el pedido');
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

    }

    //---------------------------------------------------------------------------------------------------

    function EditPiezas(id, idEstacion, idReporte) {

      var Piezas = $('#Piezas-' + id).val();

      var parametros = {
        "id": id,
        "Piezas": Piezas
      };
      $.ajax({
        data: parametros,
        url: '../public/admin/modelo/editar-item-pedido-papeleria.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {


          if (response == 1) {
            $('#ContenidoModal').load('../public/admin/vistas/modal-agregar-pedido-papeleria.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
            alertify.success('Piezas editadas exitosamente.');
            sizeWindow()
          } else {
            alertify.error('Error al editar el pedido');
          }

        }
      });
    }

    //------------------------------------------------------------------------------------------------------------------------

    function AlmacenPapeleria(id) {
      $('#ContenidoPrin').load('../public/admin/vistas/lista-inventario-papeleria.php?idEstacion=' + id);
    }

    function ModalNevoInventario(idEstacion) {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('../public/admin/vistas/modal-agregar-inventario-papeleria.php?idEstacion=' + idEstacion);
    }

    function CreateInventario(idEstacion) {

      var Producto = $('#Producto').val();
      var Piezas = $('#Piezas').val();

      var parametros = {
        "idEstacion": idEstacion,
        "Producto": Producto,
        "Piezas": Piezas
      };

      if (Producto != "") {
        $('.selectize-input').css('border', '');
        if (Piezas != "") {
          $('#Piezas').css('border', '');

          $.ajax({
            data: parametros,
            url: '../public/admin/modelo/agregar-inventario-papeleria.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {

              if (response == 1) {
                $('#Modal').modal('hide');
                AlmacenPapeleria(idEstacion)

                alertify.success('Producto agregado exitosamente.');
              } else {
                alertify.error('Error al agregar el producto');
              }

            }
          });

        } else {
          $('#Piezas').css('border', '2px solid #A52525');
        }
      } else {
        $('.selectize-input').css('border', '2px solid #A52525');
      }
    }

    function EliminarInventario(id, idEstacion) {

      var parametros = {
        "id": id
      };

      alertify.confirm('',
        function () {

          $.ajax({
            data: parametros,
            url: '../public/admin/modelo/eliminar-inventario-papeleria.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {


              if (response == 1) {
                AlmacenPapeleria(idEstacion)
                alertify.success('Producto eliminado exitosamente');
              } else {
                alertify.error('Error al eliminar el producto');
              }

            }
          });

        },
        function () {

        }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();

    }


    //---------------------------------------------------------------------------------------------------------
    function ReportePapeleria(id) {
      $('#ContenidoPrin').load('../public/admin/vistas/lista-reporte-papeleria.php?idEstacion=' + id);
    }

    function ModalDetalleReporte(idEstacion, id, idRefaccion) {
      $('#Modal').modal('show');
      $('#ContenidoModal').load('../public/admin/vistas/modal-detalle-reporte-papeleria.php?idEstacion=' + idEstacion + '&idReporte=' + id + '&idRefaccion=' + idRefaccion);
    }
    //-----------------------------------------------------------------------------------

    function FirmarPedido(idEstacion, id) {
      window.location.href = "pedido-papeleria-firmar/" + id;
    }
  </script>
</head>

<body>

  <div class="LoaderPage"></div>

  <!---------- CONTENIDO Y BARRA DE NAVEGACION ---------->
  <div class="wrapper">

    <!---------- BARRA DE NAVEGACION ---------->
    <nav id="sidebar">


      <div class="sidebar-header ">
        <img class="text-center" src="<?php echo RUTA_IMG_ICONOS . "Logo.png"; ?>" style="width: 100%;">
      </div>

      <ul class="list-unstyled components">

        <li>
          <a class="pointer" href="<?= SERVIDOR_ADMIN ?>">
            <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i>Menu
          </a>
        </li>


        <li>
          <a class="pointer" onclick="history.back()">
            <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
          </a>
        </li>

        <li>
          <a class="pointer" onclick="ListaPapeleria()">
            <i class="fa-solid fa-list" aria-hidden="true" style="padding-right: 10px;"></i>Catálogo de papeleria
          </a>
        </li>

        <?php
        $sql_listaestacion = "SELECT id, nombre, numlista FROM tb_estaciones WHERE numlista <= 8 ORDER BY numlista ASC";
        $result_listaestacion = mysqli_query($con, $sql_listaestacion);
        while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
          $id = $row_listaestacion['id'];

          if ($id == 8) {
            $estacion = "Otros Departamentos";
          } else {
            $estacion = $row_listaestacion['nombre'];
          }

          $ToSolicitud = ToSolicitud($id, $con);

          if ($ToSolicitud > 0) {
            $Nuevo = '<div class="float-end"><span class="badge bg-danger text-white rounded-circle"><small>' . $ToSolicitud . '</small></span></div>';
          } else {
            $Nuevo = '';
          }
        

            echo '  
            <li>
              <a class="pointer" onclick="SelEstacion(' . $id . ')">
              <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
              ' . $Nuevo . ' ' . $estacion . '
              </a>
            </li>';
          
          
        

        }

        $ToSolicitudOtros = ToSolicitud(8, $con);

        if ($ToSolicitudOtros > 0) {
          $NuevoOtros = '<div class="float-end"><span class="badge bg-danger text-white rounded-circle"><small>' . $ToSolicitudOtros . '</small></span></div>';
        } else {
          $NuevoOtros = '';
        }
        ?>
        <li>
          <a class="pointer" onclick="SelEstacion(8)">
            <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
            <?= $NuevoOtros; ?> Otros Departamentos
          </a>
        </li>








        
      </ul>
    </nav>



    <!---------- DIV - CONTENIDO ---------->
    <div id="content">
      <!---------- NAV BAR - PRINCIPAL (TOP) ---------->
      <nav class="navbar navbar-expand navbar-light navbar-bg">

        <i class="fa-solid fa-bars menu-btn rounded pointer" id="sidebarCollapse"></i>

        <div class="pointer">
          <a class="text-dark" onclick="history.back()">Pedido de Papeleria</a>
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
                <a class="dropdown-item" href="../perfil">
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
          <div class="col-12" id="ContenidoPrin"></div>
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