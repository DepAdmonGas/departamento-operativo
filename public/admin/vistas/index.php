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
  //function comunicadoAdmin(){window.location.href = "administracion/comunicados";}
  function IncidenciaAdmin(){window.location.href = "administracion/incidencias";}
  function Corporativo(){window.location.href = "administracion/corporativo";}
  function RecursosHumanos(){window.location.href = "recursos-humanos";}
  function Importacion(){window.location.href = "administracion/importacion";}
  function Almacen(){window.location.href = "administracion/almacen";}
  function PedidosAdmin(){window.location.href = "administracion/pedidos";}
  function ModeloNegocio(){window.location.href = "modelo-negocio";}
  function ControlVolumetrico(){window.location.href = "administracion/control-volumetrico";}
  function ProcedimientosAdmin(){window.location.href = "administracion/procedimientos";}
  //function CSFAdmin(){window.location.href = "administracion/constancia-situacion-fiscal";}
  function ReportesDireccion(){window.location.href = "administracion/reportes";}

  function LicitacionAdmin(){window.location.href = "administracion/licitacion-municipal";}

 
 
  function VerSasisopa(Sasisopa,EstacionUser){
  sessionStorage.setItem('EstacionUser', EstacionUser);
  var parametros = {
  "ValEstacion" : Sasisopa
  };
  $.ajax({
  data:  parametros,
  url:   'public/admin/modelo/editar-estacion.php',
  type:  'post',
  beforeSend: function() {
  },
  complete: function(){
  },
  success:  function (response) {
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

    if($session_nompuesto == "Dirección"){
    $referencia = "href='".SERVIDOR_ADMIN."'";
    $nameBar = "AdmonGas";
    }else{
    $referencia = "href='".PORTAL."'";
    $nameBar = "Portal";
    }

    ?>



  <div class="pointer">
  <a class="text-white" <?=$referencia?>><?=$nameBar?></a>
  </div>

  <div class="navbar-collapse collapse">

    <ul class="navbar-nav navbar-align">

    <li class="nav-item dropdown">
    <a class=" dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
    <i class="align-middle" data-feather="settings"></i>
    </a>


    <a class="nav-link dropdown-toggle d-none d-sm-inline-block pointer text-white" data-bs-toggle="dropdown">
    
    <img src="<?=RUTA_IMG_ICONOS."usuarioBar.png";?>" class="avatar img-fluid rounded-circle"/>

    <span class="text-white" style="padding-left: 10px;">
    <?=$session_nompuesto;?>  
    </span>
    </a> 
    
    <div class="dropdown-menu dropdown-menu-end">
    
    <div class="user-box">

    <div class="u-text">
    <p class="text-muted">Nombre de usuario:</p>
    <h4><?=$session_nomusuario;?></h4>
    </div>

    </div>

   
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="<?=PERFIL_ADMIN?>">
    <i class="fa-solid fa-user" style="padding-right: 5px;"></i>Perfil
    </a>
   
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="<?=RUTA_SALIR2?>salir">
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
  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3"> 
  <div class="row">
  <div class="col-12"> <h5 class="p-1">Dirección de operaciones</h5> <hr> </div>
  </div>

  <?php if ($session_nompuesto == "Dirección de operaciones") { ?>
  
  <div class="row ">
   
  <div class="col-12">
  
  <!-- <button type="button" class="btn btn-md btn-info float-end ms-2 mb-2 text-white" onclick="LicitacionAdmin()">Licitación Municipal</button> -->
  <!--<button type="button" class="btn btn-md btn-primary float-end ms-2 mb-2 text-white" onclick="CSFAdmin()">Constancia de Situacion Fiscal</button>  -->
  <button type="button" class="btn btn-md btn-success float-end ms-2 mb-2 text-white" onclick="ProcedimientosAdmin()">Procedimientos</button>  

  <!-- <button type="button" class="btn btn-md btn-info float-end ms-2 mb-2 text-white" onclick="IncidenciaAdmin()">Incidencias</button> -->
  <!--<button type="button" class="btn btn-md btn-primary float-end ms-2 mb-2" onclick="comunicadoAdmin()">Comunicados</button>-->

  </div>

  </div>
  <?php } ?>

  <div class="row mt-4">

  <!----------- 1 Corporativo  -------->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="Corporativo()">                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-1 color-CB"></i>
  </div> 
  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Corporativo</h5> 
  </div>
  </div>
  </div>
  </div>
  <!-------- --------- ------- --------->

  <!----------- 2 Recursos humanos  ------->
  <?php
  if ($session_nompuesto != "Contabilidad" AND 
  $session_nompuesto != "Comercializadora" AND 
  $session_nompuesto != "Dirección de operaciones servicio social" AND 
  $Session_IDUsuarioBD != 353) { 
  ?>
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="RecursosHumanos()">                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-2 color-CB"></i>
  </div> 
  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Recursos humanos</h5> 
  </div>
  </div>
  </div>
  </div>
  <?php
  }
  ?>
  <!-- ---- --------- ---------------->

  <!----------- 3 Importación  ------->
  <?php 
  if ($session_nompuesto != "Contabilidad" AND 
    $Session_IDUsuarioBD != 332  AND 
    $Session_IDUsuarioBD != 353  AND 
    $Session_IDUsuarioBD != 354) { 
  ?>
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="Importacion()">                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-3 color-CB"></i>
  </div> 
  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Importación</h5> 
  </div>
  </div>
  </div>
  </div>
  <?php 
  } 
  ?>
  <!-- ---- --------- ---------------->

  <!----------- 4 Almacen  ------->
  <?php if ($session_nompuesto != "Contabilidad" AND 
  $session_nompuesto != "Dirección de operaciones servicio social" AND 
  $Session_IDUsuarioBD != 353  AND 
  $Session_IDUsuarioBD != 354) { ?>
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="Almacen()">                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-4 color-CB"></i>
  </div> 
  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Almacén</h5> 
  </div>
  </div>
  </div>
  </div>
  <?php 
  } 
  ?>
  <!-- ---- --------- ---------------->

  <!----------- 5 Comercializadora  ------->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="PedidosAdmin()">                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-5 color-CB"></i>
  </div> 
  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Comercializadora</h5> 
  </div>
  </div>
  </div>
  </div>
 

  <!------- PUNTO 6. KPIS 

  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="">                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-6 color-CB"></i>
  </div> 
  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>KPI´S</h5> 
  </div>
  </div>
  </div>
  </div>

  ---------------->

  <!----------- PUNTO 7. MODELO DE NEGOCIO 
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="ModeloNegocio()">                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-7 color-CB"></i>
  </div> 
  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Modelo de negocio</h5> 
  </div>
  </div>
  </div>
  </div>
  ---------------->

  <!----------- PUNTO 8. CONTROL VOLUMETRICO
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="ControlVolumetrico()">                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-8 color-CB"></i>
  </div> 
  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Control volumétrico</h5> 
  </div>
  </div>
  </div>
  </div>
    ---------------->


<?php if($session_nompuesto == "Dirección"){ ?>
<!--
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-2 mt-2">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="ReportesDireccion()">                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon"> 
  <i class="fa-solid fa-9 color-CB"></i>
  </div> 
  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Reportes</h5> 
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

<?php if($Session_IDUsuarioBD == 322 || 
         $Session_IDUsuarioBD == 342 || 
         $Session_IDUsuarioBD == 360 || 
         $Session_IDUsuarioBD == 359 ||
         $Session_IDUsuarioBD == 358 ||
         $Session_IDUsuarioBD == 19  ||
         $Session_IDUsuarioBD == 467 ||
         $Session_IDUsuarioBD == 468 ||
         $Session_IDUsuarioBD == 438 ){ ?>

  <div class="col-12 mb-3">
  <div class="cardAG">

  <div class="border-0 p-3"> 

  <div class="row">
  <div class="col-12"><h5>SASISOPA</h5> <hr></div>
  </div>
 
  <div class="row">
  <!----- INTERLOMAS ----->
  <div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 mb-3 ">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="VerSasisopa(1,<?=$_SESSION["id_gas_usuario"];?>)">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon">
  <i class="fa-solid fa-gas-pump color-CB"></i>
  </div>

  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Interlomas</h5> 
  </div>
  </div>

  </div>
  </div>

  <!----- PALO SOLO  ----->
  <div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 mb-3 ">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="VerSasisopa(2,<?=$_SESSION["id_gas_usuario"];?>)">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon">
  <i class="fa-solid fa-gas-pump color-CB"></i>
  </div>

  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Palo Solo</h5> 
  </div>
  </div>

  </div>
  </div>


    <!----- SAN AGUSTIN  ----->
  <div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 mb-3 ">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="VerSasisopa(3,<?=$_SESSION["id_gas_usuario"];?>)">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon">
  <i class="fa-solid fa-gas-pump color-CB"></i>
  </div>

  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>San Agustin</h5> 
  </div>
  </div>

  </div>
  </div>



    <!----- GASOMIRA ----->
  <div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 mb-3 ">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="VerSasisopa(4,<?=$_SESSION["id_gas_usuario"];?>)">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon">
  <i class="fa-solid fa-gas-pump color-CB"></i>
  </div>

  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Gasomira</h5> 
  </div>
  </div>

  </div>
  </div>


    <!----- VALLE DE GUADALUPE ----->
  <div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 mb-3 ">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="VerSasisopa(5,<?=$_SESSION["id_gas_usuario"];?>)">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon">
  <i class="fa-solid fa-gas-pump color-CB"></i>
  </div>

  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Valle de Guadalupe</h5> 
  </div>
  </div>

  </div>
  </div>


    <!----- ESMEGAS ----->
  <div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 mb-3 ">
  <div class="card card-menuB rounded shadow-sm pointer p-3" onclick="VerSasisopa(6,<?=$_SESSION["id_gas_usuario"];?>)">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon">
  <i class="fa-solid fa-gas-pump color-CB"></i>
  </div>

  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Esmegas</h5> 
  </div>
  </div>

  </div>
  </div>

  <!----- XOCHIMILCO ----->
  <div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 mb-3 ">
  <div class="card card-menuB rounded shadow-sm pointer p-3" onclick="VerSasisopa(7,<?=$_SESSION["id_gas_usuario"];?>)">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon">
  <i class="fa-solid fa-gas-pump color-CB"></i>
  </div>

  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Xochimilco</h5> 
  </div>
  </div>

  </div>
  </div>

  <!----- BOSQUE REAL ----->
  <div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 mb-3 ">
  <div class="card card-menuB rounded shadow-sm pointer p-3"  onclick="VerSasisopa(14,<?=$_SESSION["id_gas_usuario"];?>)">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon">
  <i class="fa-solid fa-gas-pump color-CB"></i>
  </div>

  <div class="m-details ms-2" style="padding-top: 10px"> 
  <h5>Bosque Real</h5> 
  </div>
  </div>

  </div>
  </div>
 
  </div>

  </div>
  </div>
  </div>
  <?php } ?>

  </div>
  </div>
  </div>


<?php 
/*
    function totalaceites($IdReporte,$noaceite, $con){

    $sql_listaaceite = "SELECT * FROM op_corte_dia WHERE id_mes = '".$IdReporte."' ";
    $result_listaaceite = mysqli_query($con, $sql_listaaceite);
    while($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)){
      $id = $row_listaaceite['id'];

       $sql_listatotal = "SELECT * FROM op_aceites_lubricantes WHERE idreporte_dia = '".$id."' AND id_aceite = '".$noaceite."' LIMIT 1 ";
    $result_listatotal = mysqli_query($con, $sql_listatotal);
    while($row_listatotal = mysqli_fetch_array($result_listatotal, MYSQLI_ASSOC)){
      $cantidad = $cantidad + $row_listatotal['cantidad'];


    }

    }

    return $cantidad;

    }

$sql_year = "SELECT
op_corte_year.id,
op_corte_year.id_estacion,
op_corte_year.year,
op_corte_mes.id AS idMes,
op_corte_mes.id_year,
op_corte_mes.mes
FROM op_corte_year
INNER JOIN op_corte_mes
ON op_corte_year.id = op_corte_mes.id_year
WHERE op_corte_year.id_estacion = 7 AND year = 2021 ";
$result_year = mysqli_query($con, $sql_year);
while($row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC)){

$idMes = $row_year['idMes'];

$sql_listaaceites = "SELECT * FROM op_aceites_lubricantes_reporte WHERE id_mes = '".$idMes."' ORDER BY id_aceite ASC ";
    $result_listaaceites = mysqli_query($con, $sql_listaaceites);
while($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)){

$noaceite = $row_listaaceites['id_aceite'];
$totalaceites = totalaceites($idMes, $noaceite, $con);

$Total = $Total + $totalaceites;

}
}

echo $Total;
*/
?>
    
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  

  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
