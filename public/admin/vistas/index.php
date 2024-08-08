<?php
require ('app/help.php');

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

    function Regresar() { window.history.back(); }
    //function comunicadoAdmin(){window.location.href = "administracion/comunicados";}
    function IncidenciaAdmin() { window.location.href = "administracion/incidencias"; }
    function Corporativo() { window.location.href = "administracion/corporativo"; }
    function RecursosHumanos() { window.location.href = "recursos-humanos"; }
    function Importacion() { window.location.href = "administracion/importacion"; }
    function Almacen() { window.location.href = "administracion/almacen"; }
    function PedidosAdmin() { window.location.href = "administracion/pedidos"; }
    function ModeloNegocio() { window.location.href = "modelo-negocio"; }
    function ControlVolumetrico() { window.location.href = "administracion/control-volumetrico"; }
    function ProcedimientosAdmin() { window.location.href = "administracion/procedimientos"; }
    //function CSFAdmin(){window.location.href = "administracion/constancia-situacion-fiscal";}
    function ReportesDireccion() { window.location.href = "administracion/reportes"; }

    function LicitacionAdmin() { window.location.href = "administracion/licitacion-municipal"; }



    function VerSasisopa(Sasisopa, EstacionUser) {
      sessionStorage.setItem('EstacionUser', EstacionUser);
      var parametros = {
        "ValEstacion": Sasisopa
      };
      $.ajax({
        data: parametros,
        url: 'public/admin/modelo/editar-estacion.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {
        },
        success: function (response) {
          window.location.href = "../portal-sasisopa/";
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
    <nav class="navbar navbar-expand navbar-light navbar-bg">


      <?php
      $referencia = "href='" . PORTAL . "'";
      $nameBar = "Portal";
      if ($session_nompuesto == "Dirección") {
        $referencia = "href='" . SERVIDOR_ADMIN . "'";
        $nameBar = "AdmonGas";
      }
      ?>



      <div class="pointer">
        <a class="text-white" <?= $referencia ?>><?= $nameBar ?></a>
      </div>

      <div class="navbar-collapse collapse">

        <ul class="navbar-nav navbar-align">

          <li class="nav-item dropdown">
            <a class=" dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
              <i class="align-middle" data-feather="settings"></i>
            </a>


            <a class="nav-link dropdown-toggle d-none d-sm-inline-block pointer text-white" data-bs-toggle="dropdown">

              <img src="<?= RUTA_IMG_ICONOS . "usuarioBar.png"; ?>" class="avatar img-fluid rounded-circle" />

              <span class="text-white" style="padding-left: 10px;">
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

        <div class="col-12">
          <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
            <ol class="breadcrumb breadcrumb-caret">
              <li class="breadcrumb-item"><a <?= $referencia ?> class="text-uppercase text-primary pointer"><i
                    class="fa-solid fa-house"></i> Portal</a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase">Dirección de operaciones</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Dirección de
                operaciones</h3>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
              <?php if ($session_nompuesto == "Dirección de operaciones") { ?>
                <button type="button" class="btn btn-labeled2 btn-success float-end" onclick="ProcedimientosAdmin()">
                  <span class="btn-label2"><i class="fa-solid fa-briefcase"></i></span>Procedimientos
                </button>
              <?php } ?>
            </div>

          </div>

          <hr>
        </div>


        <div class="row">

          <!----------- 1 Corporativo  -------->
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
            <article class="plan card2 border-0 shadow position-relative" onclick="Corporativo()">

              <div class="inner">
                <div class="row">
                  <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-1"></i></span> </div>
                  <div class="col-10">
                    <h5 class="text-white text-center">Corporativo</h5>
                  </div>
                </div>

              </div>
            </article>
          </div>

          <!-------- --------- ------- --------->

          <!----------- 2 Recursos humanos  ------->
          <?php
          if (
            $session_nompuesto != "Contabilidad" and
            $session_nompuesto != "Comercializadora" and
            $session_nompuesto != "Dirección de operaciones servicio social" and
            $Session_IDUsuarioBD != 353
          ) {
            ?>
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
            <article class="plan card2 border-0 shadow position-relative" onclick="RecursosHumanos()">

              <div class="inner">
                <div class="row">
                  <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-2"></i></span> </div>
                  <div class="col-10">
                    <h5 class="text-white text-center">Recursos Humanos</h5>
                  </div>
                </div>

              </div>
            </article>
          </div>

          <?php
          }
          ?>
          <!-- ---- --------- ---------------->

          <!----------- 3 Importación  ------->
          <?php
          if (
            $session_nompuesto != "Contabilidad" and
            $Session_IDUsuarioBD != 332 and
            $Session_IDUsuarioBD != 353 and
            $Session_IDUsuarioBD != 354
          ) {
            ?>
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
            <article class="plan card2 border-0 shadow position-relative" onclick="Importacion()">

              <div class="inner">
                <div class="row">
                  <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-3"></i></span> </div>
                  <div class="col-10">
                    <h5 class="text-white text-center">Importación</h5>
                  </div>
                </div>

              </div>
            </article>
          </div>


          <?php
          }
          ?>
          <!-- ---- --------- ---------------->

          <!----------- 4 Almacen  ------->
          <?php if (
            $session_nompuesto != "Contabilidad" and
            $session_nompuesto != "Dirección de operaciones servicio social" and
            $Session_IDUsuarioBD != 353 and
            $Session_IDUsuarioBD != 354
          ) { ?>
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
            <article class="plan card2 border-0 shadow position-relative" onclick="Almacen()">

              <div class="inner">
                <div class="row">
                  <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-4"></i></span> </div>
                  <div class="col-10">
                    <h5 class="text-white text-center">Almacén</h5>
                  </div>
                </div>

              </div>
            </article>
          </div>

          <?php
          }
          ?>
          <!-- ---- --------- ---------------->

          <!----------- 5 Comercializadora  ------->

          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
            <article class="plan card2 border-0 shadow position-relative" onclick="PedidosAdmin()">

              <div class="inner">
                <div class="row">
                  <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-5"></i></span> </div>
                  <div class="col-10">
                    <h5 class="text-white text-center">Comercializadora</h5>
                  </div>
                </div>

              </div>
            </article>
          </div>
          
        </div>

        <?php if (
          $Session_IDUsuarioBD == 322 ||
          $Session_IDUsuarioBD == 342 ||
          $Session_IDUsuarioBD == 360 ||
          $Session_IDUsuarioBD == 359 ||
          $Session_IDUsuarioBD == 358 ||
          $Session_IDUsuarioBD == 19 ||
          $Session_IDUsuarioBD == 467 ||
          $Session_IDUsuarioBD == 468 ||
          $Session_IDUsuarioBD == 438
        ) { ?>


        <div class="col-12 mt-3">
          <div class="row">
          <hr>
            <div class="col-10">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">SASISOPA </h3>
            </div>
          </div>
        </div>

        <div class="row">
          <!----- INTERLOMAS ----->
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
            <article class="plan card2 border-0 shadow position-relative" onclick="VerSasisopa(1,<?= $Session_IDEstacion ?>)">

              <div class="inner">
                <div class="row">
                  <div class="col-2"> <span class="pricing"> <i class="fa-sharp-duotone fa-solid fa-gas-pump"></i></span> </div>
                  <div class="col-10">
                    <h5 class="text-white text-center">Interlomas</h5>
                  </div>
                </div>

              </div>
            </article>
          </div>

          <!----- PALO SOLO  ----->
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
            <article class="plan card2 border-0 shadow position-relative" onclick="VerSasisopa(2,<?= $Session_IDEstacion ?>)">

              <div class="inner">
                <div class="row">
                  <div class="col-2"> <span class="pricing"> <i class="fa-sharp-duotone fa-solid fa-gas-pump"></i></span> </div>
                  <div class="col-10">
                    <h5 class="text-white text-center">Palo Solo</h5>
                  </div>
                </div>

              </div>
            </article>
          </div>

          <!----- SAN AGUSTIN  ----->
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
            <article class="plan card2 border-0 shadow position-relative" onclick="VerSasisopa(3,<?= $Session_IDEstacion ?>)">

              <div class="inner">
                <div class="row">
                  <div class="col-2"> <span class="pricing"> <i class="fa-sharp-duotone fa-solid fa-gas-pump"></i></span> </div>
                  <div class="col-10">
                    <h5 class="text-white text-center">San Agustin</h5>
                  </div>
                </div>

              </div>
            </article>
          </div>


          <!----- GASOMIRA ----->
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
            <article class="plan card2 border-0 shadow position-relative" onclick="VerSasisopa(4,<?= $Session_IDEstacion ?>)">

              <div class="inner">
                <div class="row">
                  <div class="col-2"> <span class="pricing"> <i class="fa-sharp-duotone fa-solid fa-gas-pump"></i></span> </div>
                  <div class="col-10">
                    <h5 class="text-white text-center">
                      Gasomira
                    </h5>
                  </div>
                </div>

              </div>
            </article>
          </div>

          <!----- VALLE DE GUADALUPE ----->
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
            <article class="plan card2 border-0 shadow position-relative" onclick="VerSasisopa(5,<?= $Session_IDEstacion ?>)">

              <div class="inner">
                <div class="row">
                  <div class="col-2"> <span class="pricing"> <i class="fa-sharp-duotone fa-solid fa-gas-pump"></i></span> </div>
                  <div class="col-10">
                    <h5 class="text-white text-center">Valle de Guadalupe</h5>
                  </div>
                </div>

              </div>
            </article>
          </div>

          <!----- ESMEGAS ----->
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
            <article class="plan card2 border-0 shadow position-relative" onclick="VerSasisopa(6,<?= $Session_IDEstacion ?>)">

              <div class="inner">
                <div class="row">
                  <div class="col-2"> <span class="pricing"> <i class="fa-sharp-duotone fa-solid fa-gas-pump"></i></span> </div>
                  <div class="col-10">
                    <h5 class="text-white text-center">Esmegas</h5>
                  </div>
                </div>

              </div>
            </article>
          </div>
          <!----- XOCHIMILCO ----->
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
            <article class="plan card2 border-0 shadow position-relative" onclick="VerSasisopa(7,<?= $Session_IDEstacion ?>)">

              <div class="inner">
                <div class="row">
                  <div class="col-2"> <span class="pricing"> <i class="fa-sharp-duotone fa-solid fa-gas-pump"></i></span> </div>
                  <div class="col-10">
                    <h5 class="text-white text-center">Xochimilco</h5>
                  </div>
                </div>

              </div>
            </article>
          </div>
          <!----- BOSQUE REAL ----->
          <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
            <article class="plan card2 border-0 shadow position-relative" onclick="VerSasisopa(14,<?= $Session_IDEstacion ?>)">

              <div class="inner">
                <div class="row">
                  <div class="col-2"> <span class="pricing"> <i class="fa-sharp-duotone fa-solid fa-gas-pump"></i></span> </div>
                  <div class="col-10">
                    <h5 class="text-white text-center">Bosque Real</h5>
                  </div>
                </div>

              </div>
            </article>
          </div>

        </div>


        <?php } ?>

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