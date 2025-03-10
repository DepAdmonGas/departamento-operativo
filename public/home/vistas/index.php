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
  listaMenu()
  });


  //---------- LISTADO DE ACTIVIDADES USUARIOS ----------//
  function listaMenu(){
  $('#DivlistaMenuDO').load('public/home/vistas/lista-menu.php');    
  } 

  //---------- RUTAS DIRECCION DE OPERACIONES ----------//
  function rutaMenuDO(ruta){
  window.location.href = ruta;
  }


  function Regresar(){
   window.history.back();
  }


function SolicitudVales(){
window.location.href = "solicitud-vales";  
}

function SolicitudCheque(){
window.location.href = "solicitud-cheque";  
}

  function Aceites(){
    window.location.href = "aceites";
  }


  function TerminalesPV(){
   window.location.href = "terminales-tpv"; 
  }

function PrecioCombustible(){
 window.location.href = "administracion/precio-combustible";   
}

function Refacciones(){
 window.location.href = "refacciones";  
}

function Pinturas(){
 window.location.href = "pinturas";   
}

function Papeleria(){
 window.location.href = "papeleria"; 
}

function Limpieza(){ 
window.location.href = "limpieza"; 
}

 
function SolicitudAditivo(){
window.location.href = "solicitud-aditivo";   
}

function Embarques(){
window.location.href = "administracion/embarques";  
}

function OrdenMantenimiento(){
window.location.href = "orden-mantenimiento";   
}
function OrdenServicio(){
window.location.href = "orden-servicio";
}
 
function OrdenCompra(){
window.location.href = "orden-compra";
}

function ReciboNomina(){
  window.location.href = "recibo-nomina";  
}

function ReciboNominaV2(){
  window.location.href = "recibos-nomina";
}

  function RecursosHumanos(){
  window.location.href = "recursos-humanos";   
  }

  function Almacen(){
   window.location.href = "administracion/almacen";   
  }

  function PedidoMaterial(){
   window.location.href = "pedido-material";  
  }

  function CalibracionDispensarios(){
     window.location.href = "calibracion-dispensarios"; 
  }

  function MedicionExplosividad(){
    window.location.href = "nivel-explosividad"; 
  }


  function comunicadoEncargado(){
  window.location.href = "comunicados"; 
  }

  function AcuseRecepcionAuditor(){
    window.location.href = "administracion/acuses-recepcion"; 

  }


  function DescargaTuxpanAuditor(){
    window.location.href = "descarga-tuxpan"; 

  }

  </script>
  </head>
  <body>

<div class="LoaderPage"></div> 
 

<?php 
if ($session_nompuesto == "Auditor") {
  $onclickF = '';
  $nombreBar = 'Admongas';


}else{
  $onclickF = 'href="'.PORTAL.'"';
  $nombreBar = 'Portal';

}
  
?>




  <!---------- CONTENIDO DE PAGINA WEB ----------> 
  <div id="content">

  <!---------- NAV BAR (TOP) ---------->   
   <nav class="navbar navbar-expand navbar-light navbar-bg">

  <div class="pointer">
  <a class="text-white" <?=$onclickF?>><?=$nombreBar?></a>
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

  <!---------- CONTENIDO ----------> 
  <div class="contendAG">  


  <div class="col-12 mb-3 cardAG">
  <div class="border-0 p-3 mb-3"> 

  <div class="row">
  <div class="col-12"> <h5>Dirección de operaciones</h5> </div>
 </div>

  <hr>

  <div class="row">

<?php if ($session_nompuesto == "Encargado") { ?>

<div class="col-12 mb-2">
  <?php
  $sql_listComunicados = "SELECT * FROM tb_comunicados_do ORDER BY id_comunicado DESC ";  
  $result_listComunicados = mysqli_query($con, $sql_listComunicados);
  $numero_listComunicados = mysqli_num_rows($result_listComunicados);


  $sql_listComunicadosUsu = "SELECT * FROM tb_comunicados_grte WHERE id_gerente = ".$Session_IDUsuarioBD." "; 
  $result_listComunicadosUsu = mysqli_query($con, $sql_listComunicadosUsu);
  $numero_listComunicadosUsu = mysqli_num_rows($result_listComunicadosUsu);

  $vistaComunicados = $numero_listComunicados - $numero_listComunicadosUsu;


  if($vistaComunicados == 0){
   $spanAlert = '';  
  }else{
  $spanAlert = '<span class="ml-1 badge bg-danger text-white rounded-circle">
    <small>'.$vistaComunicados.'</small>
   </span> ';
  }

  ?>

<button type="button" class="btn btn-md btn-primary float-end" onclick="comunicadoEncargado()">Comunicados <?=$spanAlert;?></button>
</div>

<?php } ?>


  <div id="DivlistaMenuDO"></div>

  </div>
  </div>
  </div>
 
  </div>
  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script
  


  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
