<?php
require('app/help.php');

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
  <link href="<?=RUTA_CSS2;?>cards-utilities.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
 
  <script type="text/javascript">
  
  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  
  });
 
  function Regresar(){
  window.history.back();
  }

  function Refacciones(){window.location.href = "../administracion/refacciones";}
  function Pinturas(){window.location.href = "../administracion/pinturas";} 
  function Papeleria(){window.location.href = "../administracion/papeleria";}
  function Limpieza(){window.location.href = "../administracion/limpieza";}
  function PedidoMaterial(){window.location.href = "../administracion/pedido-material";} 
  function ModalTelefono(){$('#Modal').modal('show');}
  function OrdenCompra(){window.location.href = "../administracion/orden-compra";}
  function OrdenMantenimiento(){window.location.href = "../administracion/orden-mantenimiento";}
  function TerminalesPV(){window.location.href = "../administracion/terminales-tpv";}
  function CalibracionDispensarios(){window.location.href = "../administracion/calibracion-dispensarios";}
  function ContratosAdmin(){window.location.href = "../contratos/almacen";} 
  function Explosividad(){window.location.href = "../administracion/nivel-explosividad";}
  function MantenimientoPreventivo(){window.location.href = "../administracion/mantenimiento-preventivo";}
  function Mantenimiento(){window.location.href = "../administracion/mantenimiento";}
  function Proveedores(){window.location.href = "../administracion/proveedores";}
  function Estructura(){window.location.href = "../administracion/estructura";}

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

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Inicio</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Almacén</li>
  </ol>
  </div>
 
  <div class="row"> 
  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Almacén</h3> </div>
  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12"> 
  <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="ModalTelefono()">
  <span class="btn-label2"><i class="fa-regular fa-address-book"></i></span>Directorio</button>
  </div>  
  </div>

  <hr>
  </div>

  <!---------- Refacciones ---------->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-1">
  <article class="plan card2 border-0 shadow position-relative" onclick="Refacciones()">
          
  <div class="inner">
  <div class="row">
  <div class="col-2"> <span class="pricing">  <i class="fa-solid fa-1"></i></i></span> </div>
  <div class="col-10"><h5 class="text-white text-center">Refacciones</h5></div>
  </div>

  </div>
  </article>
  </div>

  <!---------- Orden de Mantenimiento ---------->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-1">
  <article class="plan card2 border-0 shadow position-relative" onclick="PedidoMaterial()">
          
  <div class="inner">
  <div class="row">
  <div class="col-2"> <span class="pricing">  <i class="fa-solid fa-2"></i></i></span> </div>
  <div class="col-10"><h5 class="text-white text-center">Orden de Mantenimiento</h5></div>
  </div>

  </div>
  </article>
  </div>


  <!---------- Mantenimiento ---------->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-1">
  <article class="plan card2 border-0 shadow position-relative" onclick="Mantenimiento()">
          
  <div class="inner">
  <div class="row">
  <div class="col-2"> <span class="pricing">  <i class="fa-solid fa-3"></i></i></span> </div>
  <div class="col-10"><h5 class="text-white text-center">Mantenimiento</h5></div>
  </div>

  </div>
  </article>
  </div>


  <!---------- Contratos ---------->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-1">
  <article class="plan card2 border-0 shadow position-relative" onclick="ContratosAdmin('almacen')">
          
  <div class="inner">
  <div class="row">
  <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-4"></i></i></span> </div>
  <div class="col-10"><h5 class="text-white text-center">Contratos</h5></div>
  </div>

  </div>
  </article>
  </div>

  <!---------- Orden de compra ---------->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-1">
  <article class="plan card2 border-0 shadow position-relative" onclick="OrdenCompra()">
          
  <div class="inner">
  <div class="row">
  <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-5"></i></i></span> </div>
  <div class="col-10"><h5 class="text-white text-center">Orden de compra</h5></div>
  </div>

  </div>
  </article>
  </div>
  
  <!---------- Proveedores ---------->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-1">
  <article class="plan card2 border-0 shadow position-relative" onclick="Proveedores()">
          
  <div class="inner">
  <div class="row">
  <div class="col-2"> <span class="pricing"> <i class="fa-solid fa-6"></i></i></span> </div>
  <div class="col-10"><h5 class="text-white text-center">Proveedores</h5></div>
  </div>

  </div>
  </article>
  </div>

    <!-- -->

  <!-- Inventario de Pinturas 
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-1 mt-2 ">
  <div class="card card-menuB rounded shadow-sm pointer"  onclick="Pinturas()">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-2 color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <h5>Inventario de Pinturas</h5> 
  </div>
  </div>

  </div>
  </div>
  -->


  <!-- Papeleria
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-1 mt-2 ">
  <div class="card card-menuB rounded shadow-sm pointer"  onclick="Papeleria()">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-3 color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <h5>Papeleria</h5> 
  </div>
  </div>

  </div>
  </div>
  -->

  <!-- Artículos de limpieza 
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-1 mt-2 ">
  <div class="card card-menuB rounded shadow-sm pointer"  onclick="Limpieza()">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-4 color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <h5>Artículos de limpieza</h5> 
  </div>
  </div>

  </div>
  </div>
  -->







  <!-- -->

<?php if ($session_nompuesto != "Contabilidad" && $session_nompuesto != "Dirección de operaciones servicio social") { ?>
<!--
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-1 mt-2 ">
  <div class="card card-menuB rounded shadow-sm pointer"  onclick="OrdenCompra()">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-7 color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <h5>Orden de compra</h5> 
  </div>
  </div>

  </div>
  </div>
 
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-1 mt-2 ">
  <div class="card card-menuB rounded shadow-sm pointer"  onclick="OrdenMantenimiento()">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-8 color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <h5>Orden de mantenimiento</h5> 
  </div>
  </div>

  </div>
  </div>
-->
<?php } ?>


  </div>
  </div>
  </div>
  </div>



<div class="modal" id="Modal">
<div class="modal-dialog modal-lg">
<div class="modal-content ">
<div class="modal-header">
<h5 class="modal-title">Directorio</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<div class="table-responsive">
<table class="custom-table mt-2" style="font-size: 12.5px;" width="100%">
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
