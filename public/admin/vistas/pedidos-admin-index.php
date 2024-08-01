<?php
require ('app/help.php');

if ($Session_IDUsuarioBD == "") {
  header("Location:" . PORTAL . "");
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
  <link href="<?= RUTA_CSS2; ?>cards-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <script src="<?= RUTA_JS2 ?>home-general-functions.js"></script>

  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");

    });

    function Regresar() {
      window.history.back();
    }

    function Pinturas() {
      window.location.href = "../administracion/pinturas";
    }

    function Papeleria() {
      window.location.href = "../administracion/papeleria";
    }

    function Limpieza() {
      window.location.href = "../administracion/limpieza";
    }

    function ModalTelefono() {
      $('#Modal').modal('show');
    }

    function SolicitudAditivo() {
      window.location.href = "../administracion/solicitud-aditivo";
    }


    function CamionetaSaveiro() {
      window.location.href = "../administracion/camioneta-saveiro";

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
              <li class="breadcrumb-item"><a onclick="history.go(-1)" class="text-uppercase text-primary pointer"><i
                    class="fa-solid fa-house"></i> Inicio</a></li>
              <li class="breadcrumb-item"><a class="text-uppercase pointer"> Comercializadora</a></li>
            </ol>
          </div>
          <div class="row">
            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                Comercializadora
              </h3>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
              <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="ModalTelefono()">
                <span class="btn-label2"><i class="fa fa-address-book"></i></span>Directorio</button>
            </div>
          </div>

        </div>

      </div>
      <hr>
      <div class="row">

        <!---------- PINTURAS ---------->

        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
          <article class="plan card2 border-0 shadow position-relative" onclick="Pinturas()">
            <div class="inner">
              <div class="row">
                <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-paint-roller"></i></span> </div>
                <div class="col-10">
                  <h5 class="text-white text-center">Pedido de Pinturas</h5>
                </div>
              </div>
            </div>
          </article>
        </div>

        <!---------- PAPELERIA ---------->

        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
          <article class="plan card2 border-0 shadow position-relative" onclick="Papeleria()">
            <div class="inner">
              <div class="row">
                <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-pen-ruler"></i></span> </div>
                <div class="col-10">
                  <h5 class="text-white text-center">Pedido de Papeleria</h5>
                </div>
              </div>
            </div>
          </article>
        </div>

        <!---------- Limpieza ---------->

        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
          <article class="plan card2 border-0 shadow position-relative" onclick="Limpieza()">
            <div class="inner">
              <div class="row">
                <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-broom"></i></span> </div>
                <div class="col-10">
                  <h5 class="text-white text-center">Pedido de Artículos de Limpieza</h5>
                </div>
              </div>
            </div>
          </article>
        </div>

        <!---------- Aditivo ---------->

        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
          <article class="plan card2 border-0 shadow position-relative" onclick="SolicitudAditivo()">
            <div class="inner">
              <div class="row">
                <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-oil-can"></i></span> </div>
                <div class="col-10">
                  <h5 class="text-white text-center">Pedido de Aditivo</h5>
                </div>
              </div>
            </div>
          </article>
        </div>

        <?php if ($session_nompuesto == "Dirección de operaciones" || $session_nompuesto == "Contabilidad" || $Session_IDUsuarioBD == 3) { ?>

          <!---------- Camionte ---------->

          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
            <article class="plan card2 border-0 shadow position-relative" onclick="CamionetaSaveiro()">
              <div class="inner">
                <div class="row">
                  <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-truck-moving"></i></span> </div>
                  <div class="col-10">
                    <h5 class="text-white text-center">Camioneta Saveiro</h5>
                  </div>
                </div>
              </div>
            </article>
          </div>

        <?php } ?>


      </div>

    </div>
  </div>





  <div class="modal" id="Modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Directorio</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="table-responsive">
            <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
              <thead class="tables-bg">
                <tr>
                  <th class="align-middle text-center">Estación</th>
                  <th class="align-middle text-center">Nombre del encargado</th>
                  <th class="align-middle text-center">Número telefónico</th>
                </tr>
              </thead>
              <tbody class="bg-light">
                <tr>
                  <th class="align-middle text-center no-hover2">Palo Solo</th>
                  <td class="align-middle text-center no-hover2">Marco Antonio</td>
                  <td class="align-middle text-center no-hover2">5617833419</td>
                </tr>
                <tr>
                  <th class="align-middle text-center no-hover2">Interlomas</th>
                  <td class="align-middle text-center no-hover2">Nepthali</td>
                  <td class="align-middle text-center no-hover2">5535663735</td>
                </tr>
                <tr>
                  <th class="align-middle text-center no-hover2">San Agustín</th>
                  <td class="align-middle text-center no-hover2">Eduardo Serrano</td>
                  <td class="align-middle text-center no-hover2">5534889569</td>
                </tr>
                <tr>
                  <th class="align-middle text-center no-hover2">Gasomira</th>
                  <td class="align-middle text-center no-hover2">Josué</td>
                  <td class="align-middle text-center no-hover2"></td>
                </tr>
                <tr>
                  <th class="align-middle text-center no-hover2">Valle de Guadalupe</th>
                  <td class="align-middle text-center no-hover2">Alberto Urbina</td>
                  <td class="align-middle text-center no-hover2">5544916432</td>
                </tr>
                <tr>
                  <th class="align-middle text-center no-hover2">Xochimilco</th>
                  <td class="align-middle text-center no-hover2">Sandra y Aldo</td>
                  <td class="align-middle text-center no-hover2">5543625779</td>
                </tr>
                <tr>
                  <th class="align-middle text-center no-hover2">Bosque Real</th>
                  <td class="align-middle text-center no-hover2">Ayala</td>
                  <td class="align-middle text-center no-hover2">5549449348</td>
                </tr>
                <tr>
                  <th class="align-middle text-center no-hover2">Autolavado</th>
                  <td class="align-middle text-center no-hover2">Freddy</td>
                  <td class="align-middle text-center no-hover2">5587962994</td>
                </tr>
              </tbody>
            </table>
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