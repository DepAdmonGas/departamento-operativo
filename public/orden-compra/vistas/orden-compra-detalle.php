<?php
require ('app/help.php');

if ($Session_IDUsuarioBD == "") {
  header("Location:" . PORTAL . "");
}

$sql = "SELECT * 
FROM op_orden_compra WHERE id = '" . $GET_idReporte . "' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
  $no_control = $row['no_control'];
  $porcentaje_total = $row['porcentaje_total'];
  $cargo = $row['cargo'];

  $explode = explode(" ", $row['fecha']);
  $Fecha = $explode[0];
  $estatus = $row['estatus'];
}


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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");
      ContenidoEstaciones(<?= $GET_idReporte; ?>)
      ContenidoProveedor(<?= $GET_idReporte; ?>)
      ContenidoArticulos(<?= $GET_idReporte; ?>)
      ContenidoRefacturacion(<?= $GET_idReporte; ?>)

    });

    function Regresar() {
      window.history.back();
    }


    function ContenidoEstaciones(idReporte) {
      $('#ContenidoEstaciones').load('../../public/orden-compra/vistas/lista-estaciones.php?idReporte=' + idReporte + '&idStatus=' + 1);
    }

    function ContenidoProveedor(idReporte) {
      $('#ContenidoProveedor').load('../../public/orden-compra/vistas/lista-proveedor.php?idReporte=' + idReporte + '&idStatus=' + 1);
    }

    function ContenidoArticulos(idReporte) {
      $('#ContenidoArticulos').load('../../public/orden-compra/vistas/lista-producto.php?idReporte=' + idReporte + '&idStatus=' + 1);
    }

    function ContenidoRefacturacion(idReporte) {
      $('#ContenidoRefacturacion').load('../../public/orden-compra/vistas/lista-refacturacion.php?idReporte=' + idReporte + '&idStatus=' + 1);
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
    <div class="contendAG container">
      <div class="row">

        <div class="col-12 mb-3">
          <div class="cardAG">
            <div class="border-0 p-3">

              <div class="row">

                <div class="col-12">
                  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
                    <ol class="breadcrumb breadcrumb-caret">
                      <li class="breadcrumb-item"><a onclick="history.back()"
                          class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i>
                          Orden de Compra</a></li>
                      <li aria-current="page" class="breadcrumb-item active">FORMULARIO ORDEN DE COMPRA</li>
                    </ol>
                  </div>

                  <div class="row">
                    <div class="col-12">
                      <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Formulario
                        Orden de Compra</h3>
                    </div>
                  </div>

                  <hr>
                </div>

                <div class="col-12 mb-2">
                  <h6>INFORMACIÓN GENERAL</h6>
                </div>

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                  <div class="mb-1">No. De control: <b>00<?= $no_control ?></b></div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                  <div class="mb-1">Dep. Almacén</div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                  <div class="mb-1">Ref. Operativa</div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                  <div class="mb-1"><b>Cargo: </b><?=$cargo; ?></div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                  <div class="mb-1"><b>Refacturación </b><?= $porcentaje_total; ?> %</div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2">
                  <div class="mb-1"><b>Fecha: </b><?= FormatoFecha($Fecha); ?></div>
                </div>
                <div class="col-12 mb-2">
                  <div id="ContenidoEstaciones"></div>                  
                </div>
                <div class="col-12 mb-2">
                  <div id="ContenidoProveedor"></div>
                </div>
              </div>

              <div class="row">

                <!---------- TABLA AGREGAR PROVEEDOR ---------->
                <?php
                $sql_proveedor = "SELECT * FROM op_orden_compra_proveedor WHERE id_ordencompra = '" . $GET_idReporte . "' ";
                $result_proveedor = mysqli_query($con, $sql_proveedor);
                $numero_proveedor = mysqli_num_rows($result_proveedor);

                if ($numero_proveedor > 2) {
                  $ocultarM = "";
                } else {
                  $ocultarM = "d-none";
                }

                ?>

                <div class="col-12 mb-3 <?= $ocultarM ?>">
                  <div id="ContenidoArticulos"></div>
                </div>


                <div class="col-12 mb-3 <?= $ocultarM ?>">
                  <div id="ContenidoRefacturacion"></div>
                </div>

              </div>



              <div class="col-12">
                <div class="row">
                  <?php

                  $sql_firma = "SELECT * FROM op_orden_compra_firma WHERE id_ordencompra = '" . $GET_idReporte . "' ";
                  $result_firma = mysqli_query($con, $sql_firma);
                  $numero_firma = mysqli_num_rows($result_firma);
                  while ($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)) {

                    $explode = explode(' ', $row_firma['fecha']);

                    if ($row_firma['tipo_firma'] == "A") {
                      $TipoFirma = "Elaboró";
                      $Detalle = '<th class="text-center no-hover2"><img src="../../imgs/firma/' . $row_firma['firma'] . '" width="70%"></th>';
                    } else if ($row_firma['tipo_firma'] == "B") {
                      $TipoFirma = "Vo.Bo";
                      $Detalle = '<th class="text-center no-hover2 p-2"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: ' . FormatoFecha($explode[0]) . ', ' . date("g:i a", strtotime($explode[1])) . '</b></small></th>';

                    }
                    echo '<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                            <div class="table-responsive">
                              <table class="custom-table" width="100%">
                                <thead class="tables-bg">
                                  <tr>
                                    <th class="align-middle text-center">' . $TipoFirma . '</th>
                                  </tr>
                                </thead>
                                <tbody class="bg-light">
                                <tr>
                                '.$Detalle.'
                                </tr>
                                <tr>
                                 <th class="p-2 no-hover2">' . Personal($row_firma['id_usuario'], $con) . '</th>
                                </tr>
                                 </tbody>
                              </table>
                            </div>
                          </div>';
                  }

                  ?>
                </div>
              </div>
            </div>

          </div>

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