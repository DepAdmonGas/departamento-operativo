<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}
  
?> 
<html lang="es">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dirección de operaciones</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <link rel="shortcut icon" href="<?=RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?=RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?=RUTA_CSS2 ?>alertify.css">
  <link rel="stylesheet" href="<?=RUTA_CSS2 ?>themes/default.rtl.css">
  <link href="<?=RUTA_CSS2;?>bootstrap.min.css" rel="stylesheet" />
  <link href="<?=RUTA_CSS2;?>navbar-general.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
 
  
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  });
 
  function Regresar(){window.history.back();}
  function CorteDiario(){window.location.href = "../administracion/corte-diario";}
  function SolicitudCheque(){window.location.href = "../administracion/solicitud-cheque";}
  function IngresosFacturacion(){window.location.href = "../administracion/ingresos-facturacion";}
  function EstimuloFiscal(){window.location.href = "../administracion/estimulo-fiscal";}
  function DespachoFactura(){window.location.href = "../administracion/despacho-factura";}
  function ReporteCre(){window.location.href = "../administracion/reporte-cre";}
  function ContratosAdmin(){window.location.href = "../contratos/corporativo";}
  function SegurosAdmin(){window.location.href = "../seguros";}
  function Aceites(){window.location.href = "../administracion/aceites";}
  function InventarioAceites(){window.location.href = "../administracion/inventario-aceites";}
  function SolicitudVales(){window.location.href = "../solicitud-vales";}

  </script>
  </head>

  <body>

  <div class="LoaderPage"></div>

  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
  <?php include_once "public/navbar/navbar-perfil.php";?>
  <!---------- CONTENIDO PAGINA WEB----------> 
  
  <div class="contendAG">
  <div class="row">  
  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3"> 
    <div class="row">
    <div class="col-12"> 

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

    <h5>Corporativo</h5>
     
    </div>
    </div>

    </div>
    </div>

    <hr>

  <div class="row mt-2">

  <!----------- Corte Diario  -------->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="CorteDiario()">                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-1 color-CB"></i>
  </div> 
  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Corte Diario</h5> 
  </div>
  </div>
  </div>
  </div>
  <!-------- --------- ------- --------->

  <!----------- Solicitud de cheques  -------->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="SolicitudCheque()">                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-2 color-CB"></i>
  </div> 
  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Solicitud de cheques</h5> 
  </div>
  </div>
  </div>
  </div>
  <!-------- --------- ------- --------->

  <!----------- Ingresos VS factura  
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="IngresosFacturacion()">                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-3 color-CB"></i>
  </div> 
  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Ingresos VS Facturación</h5> 
  </div>
  </div>
  </div>
  </div>
  --------->

  <!----------- Estímulo fiscal  
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="EstimuloFiscal()">                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-4 color-CB"></i>
  </div> 
  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Estímulo fiscal</h5> 
  </div>
  </div>
  </div>
  </div>
  --------- ------- --------->

  <!----------- Despacho vs ventas  -------->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="DespachoFactura()">                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-3 color-CB"></i>
  </div> 
  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Despacho vs ventas</h5> 
  </div>
  </div>
  </div>
  </div>
  <!-------- --------- ------- --------->

  <!----------- Reportes estadísticos de la CRE  -------->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="ReporteCre()">                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-4 color-CB"></i>
  </div> 
  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Reportes estadísticos de la CRE</h5> 
  </div>
  </div>
  </div>
  </div>
  <!-------- --------- ------- --------->

  <!----------- Contratos  -------->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="ContratosAdmin()">                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-5 color-CB"></i>
  </div> 
  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Contratos</h5> 
  </div>
  </div>
  </div>
  </div>
  <!-------- --------- ------- --------->

  <!----------- Seguros  -------->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="SegurosAdmin()">                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-6 color-CB"></i>
  </div> 
  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Incidentes y accidentes(seguros)</h5> 
  </div>
  </div>
  </div>
  </div>
  <!-------- --------- ------- --------->

  <!----------- Aceites  -------->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="Aceites()">                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-7 color-CB"></i>
  </div> 
  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Lista de Aceites</h5> 
  </div>
  </div>
  </div>
  </div>
  <!-------- --------- ------- --------->

  <!----------- Inventario Aceites  
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="InventarioAceites()">                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-1 color-CB"></i>
  <i class="fa-solid fa-0 color-CB"></i>
  </div> 
  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Inventario Aceites</h5> 
  </div>
  </div>
  </div>
  </div>
  --------- ------- --------->

  <!----------- Inventario Aceites  -------->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="SolicitudVales()">                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-8 color-CB"></i>
  </div> 
  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Solicitud de vales</h5> 
  </div>
  </div>
  </div>
  </div>
  <!-------- --------- ------- --------->

  </div>
  
  </div> 
  </div>
  </div> 

  </div>
  </div>
  </div>

  </div>

  <!---------- FUNCIONES - NAVBAR ----------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>
  <!-- -- -- -- -- -- -- -- -- -- -- -- -- -->

  </body>
  </html>
