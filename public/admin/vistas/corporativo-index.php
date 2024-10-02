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
      localStorage.clear();
    });

    function Regresar() { window.history.back(); }
    function CorteDiario() { window.location.href = "../administracion/corte-diario"; }
    function SolicitudCheque() { window.location.href = "../administracion/solicitud-cheque"; }
    function IngresosFacturacion() { window.location.href = "../administracion/ingresos-facturacion"; }
    function EstimuloFiscal() { window.location.href = "../administracion/estimulo-fiscal"; }
    function DespachoFactura() { window.location.href = "../administracion/despacho-factura"; }
    function ReporteCre() { window.location.href = "../administracion/reporte-cre"; }
    function ContratosAdmin() { window.location.href = "../contratos/corporativo"; }
    function SegurosAdmin() { window.location.href = "../seguros"; }
    function Aceites() { window.location.href = "../administracion/aceites"; }
    function InventarioAceites() { window.location.href = "../administracion/inventario-aceites"; }
    function SolicitudVales() { window.location.href = "../solicitud-vales"; }

  window.addEventListener('pageshow', function (event) {
  if (event.persisted) {
  // Si la página está en la caché del navegador, recargarla
  window.location.reload();
  }
  });

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
                    <li aria-current="page" class="breadcrumb-item active text-uppercase"> Corporativo</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                Corporativo
              </h3>
            </div>
          </div>

        </div>
      </div>
      <hr>

      <div class="row mt-2">

        <!----------- Corte Diario  -------->

        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
          <article class="plan card2 border-0 shadow position-relative" onclick="CorteDiario()">
            <div class="inner">
              <div class="row">
                <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-1"></i></span> </div>
                <div class="col-10">
                  <h5 class="text-white text-center">Corte Diario</h5>
                </div>
              </div>
            </div>
          </article>
        </div>
        <!-------- --------- ------- --------->

        <!----------- Solicitud de cheques  -------->
        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
          <article class="plan card2 border-0 shadow position-relative" onclick="SolicitudCheque()">
            <div class="inner">
              <div class="row">
                <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-2"></i></span> </div>
                <div class="col-10">
                  <h5 class="text-white text-center">Solicitud de Cheques</h5>
                </div>
              </div>
            </div>
          </article>
        </div>

        <!----------- Despacho vs ventas  -------->
        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
          <article class="plan card2 border-0 shadow position-relative" onclick="DespachoFactura()">
            <div class="inner">
              <div class="row">
                <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-3"></i></span> </div>
                <div class="col-10">
                  <h5 class="text-white text-center">Despacho vs ventas</h5>
                </div>
              </div>
            </div>
          </article>
        </div>
        <!-------- --------- ------- --------->

        <!----------- Reportes estadísticos de la CRE  -------->
        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
          <article class="plan card2 border-0 shadow position-relative" onclick="ReporteCre()">
            <div class="inner">
              <div class="row">
                <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-4"></i></span> </div>
                <div class="col-10">
                  <h5 class="text-white text-center">Reportes estadísticos de la CRE</h5>
                </div>
              </div>
            </div>
          </article>
        </div>
        <!-------- --------- ------- --------->

        <!----------- Contratos  -------->
        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
          <article class="plan card2 border-0 shadow position-relative" onclick="ContratosAdmin()">
            <div class="inner">
              <div class="row">
                <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-5"></i></span> </div>
                <div class="col-10">
                  <h5 class="text-white text-center">Contratos</h5>
                </div>
              </div>
            </div>
          </article>
        </div>
        <!-------- --------- ------- --------->

        <!----------- Seguros  -------->
        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
          <article class="plan card2 border-0 shadow position-relative" onclick="SegurosAdmin()">
            <div class="inner">
              <div class="row">
                <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-6"></i></span> </div>
                <div class="col-10">
                  <h5 class="text-white text-center">Incidentes y accidentes(seguros)</h5>
                </div>
              </div>
            </div>
          </article>
        </div>
        <!-------- --------- ------- --------->

        <!----------- Aceites  -------->
        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
          <article class="plan card2 border-0 shadow position-relative" onclick="Aceites()">
            <div class="inner">
              <div class="row">
                <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-7"></i></span> </div>
                <div class="col-10">
                  <h5 class="text-white text-center">Lista de Aceites</h5>
                </div>
              </div>
            </div>
          </article>
        </div>

        <!----------- Inventario Aceites  -------->
        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
          <article class="plan card2 border-0 shadow position-relative" onclick="SolicitudVales()">
            <div class="inner">
              <div class="row">
                <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-8"></i></span> </div>
                <div class="col-10">
                  <h5 class="text-white text-center">Solicitud de Vales</h5>
                </div>
              </div>
            </div>
          </article>
        </div>

        <!-------- --------- ------- --------->

      </div>


    </div>
  </div>

  </div>

  <!---------- FUNCIONES - NAVBAR ----------->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>
  <!-- -- -- -- -- -- -- -- -- -- -- -- -- -->

</body>

</html>