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

  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3"> 

    <div class="row">
    <div class="col-11">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

    <h5>Almacén</h5>
    
    </div>
    </div>

    </div>

    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12">
    <img width="24px" class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>telefono.png" onclick="ModalTelefono()">
    </div>
    </div>

    <hr>


<div class="row">

  <!-- Refacciones -->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-1 mt-2 ">
  <div class="card card-menuB rounded shadow-sm pointer"  onclick="Refacciones()">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-1 color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <h5>Refacciones</h5> 
  </div>
  </div>

  </div>
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


  <!-- Pedido Material -->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-1 mt-2 ">
  <div class="card card-menuB rounded shadow-sm pointer"  onclick="PedidoMaterial()">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-2 color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <h5>Orden de Mantenimiento</h5> 
  </div>
  </div>

  </div>
  </div>
  <!-- -->


  <!-- Mantenimiento -->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-1 mt-2 ">
  <div class="card card-menuB rounded shadow-sm pointer"  onclick="Mantenimiento()">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-3 color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <h5>Mantenimiento</h5> 
  </div>
  </div>

  </div>
  </div>


  <!-- Contratos -->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-1 mt-2 ">
  <div class="card card-menuB rounded shadow-sm pointer"  onclick="ContratosAdmin('almacen')">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-4 color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <h5>Contratos</h5> 
  </div>
  </div>

  </div>
  </div>
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


  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-1 mt-2 ">
  <div class="card card-menuB rounded shadow-sm pointer"  onclick="OrdenCompra()">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-5 color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <h5>Orden de compra</h5> 
  </div>
  </div>

  </div>
  </div>

  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-1 mt-2 ">
  <div class="card card-menuB rounded shadow-sm pointer"  onclick="Proveedores()">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-6 color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <h5>Proveedores</h5> 
  </div>
  </div>

  </div>
  </div>


  <!---------- ESTRUCTURA ---------->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-1 mt-2 ">
  <div class="card card-menuB rounded shadow-sm pointer"  onclick="Estructura()">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-7 color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <h5>Estructura</h5> 
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





<div class="modal" id="Modal">
<div class="modal-dialog" style="margin-top: 83px;">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Directorio</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<div class="table-responsive">
<table class="table table-sm table-bordered mb-0">
<thead class="tables-bg">
<tr>
<th class="align-middle text-center">Estación</th>
<th class="align-middle text-center">Nombre del encargado</th>
<th class="align-middle text-center">Número telefónico</th>
</tr>
</thead>
<tbody>
  <tr>
    <td class="align-middle text-center">Palo Solo</td>
    <td class="align-middle text-center">Marco Antonio</td>
    <td class="align-middle text-center">5617833419</td>
  </tr>
  <tr>
    <td class="align-middle text-center">Interlomas</td>
    <td class="align-middle text-center">Nepthali</td>
    <td class="align-middle text-center">5535663735</td>
  </tr>
  <tr>
    <td class="align-middle text-center">San Agustín</td>
    <td class="align-middle text-center">Eduardo Serrano</td>
    <td class="align-middle text-center">5534889569</td>
  </tr>
  <tr>
    <td class="align-middle text-center">Gasomira</td>
    <td class="align-middle text-center">Josué</td>
    <td class="align-middle text-center"></td>
  </tr>
  <tr>
    <td class="align-middle text-center">Valle de Guadalupe</td>
    <td class="align-middle text-center">Alberto Urbina</td>
    <td class="align-middle text-center">5544916432</td>
  </tr>
  <tr>
    <td class="align-middle text-center">Xochimilco</td>
    <td class="align-middle text-center">Sandra y Aldo</td>
    <td class="align-middle text-center">5543625779</td>
  </tr>
  <tr>
    <td class="align-middle text-center">Bosque Real</td>
    <td class="align-middle text-center">Ayala</td>
    <td class="align-middle text-center">5549449348</td>
  </tr>
  <tr>
    <td class="align-middle text-center">Autolavado</td>
    <td class="align-middle text-center">Freddy</td>
    <td class="align-middle text-center">5587962994</td>
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
