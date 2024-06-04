<?php
require('app/help.php');

function ToSolicitud($con){
$sql_lista = "SELECT id FROM op_rh_formatos WHERE (status BETWEEN 1 AND 2) AND (formato IN (1, 2, 3, 4, 6)) ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
}

function ToSolicitudPermisos($con){
$sql_lista = "SELECT id FROM op_rh_permisos WHERE (estado BETWEEN 0 AND 1)";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
}

function ToSolicitudBaja($con){
$sql_lista = "SELECT id FROM op_rh_personal_baja WHERE estado_proceso <> 2";
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
  <link rel="shortcut icon" href="<?=RUTA_IMG_ICONOS?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?=RUTA_IMG_ICONOS?>/icono-web.png">
  <link rel="stylesheet" href="<?=RUTA_CSS2?>alertify.css">
  <link rel="stylesheet" href="<?=RUTA_CSS2?>themes/default.rtl.css">
  <link href="<?=RUTA_CSS2?>bootstrap.min.css" rel="stylesheet" />
  <link href="<?=RUTA_CSS2?>navbar-general.min.css" rel="stylesheet" />
  <link href="<?=RUTA_CSS2?>cards-utilities.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script type="text/javascript">
 
  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  });  
 
function Regresar(){window.history.back();}
function Organigrama(){window.location.href = "recursos-humanos-organigrama";}
function Formatos(){window.location.href = "recursos-humanos-formatos";}
function ListaFormatos(){window.location.href = "recursos-humanos-lista-formatos";}
function Personal(){window.location.href = "recursos-humanos-personal";}
function HorarioPersonal(){window.location.href = "recursos-humanos-horario-personal";}
function Nomina(){window.location.href = "recursos-humanos-nomina";}
function NominaEncargado(){window.location.href = "recibo-nomina";}
function Permisos(){window.location.href = "recursos-humanos-permisos";}
function Configuracion(){window.location.href = "recursos-humanos-configuracion";}
function Asistencia(){window.location.href = "recursos-humanos-biometrico";}
//------------------------------------------------------------------------------------------
function OrganigramaEstacion(){window.location.href = "recursos-humanos-estacion-organigrama";} 
function PersonalEstacion(){window.location.href = "recursos-humanos-estacion-personal";}
function HorarioPersonalEstacion(){window.location.href = "recursos-humanos-estacion-horario-personal";}
function AsistenciaEstacion(){window.location.href = "recursos-humanos-estacion-biometrico";}
function ListaNegraEstacion(){window.location.href = "recursos-humanos-estacion-lista-negra";}
function ConfiguracionEstacion(){window.location.href = "recursos-humanos-estacion-configuracion";}
function FormatosEstacion(){window.location.href = "recursos-humanos-estacion-formatos";}
//------------------------------------------------------------------------------------------
function ProgramarHorario(){window.location.href = "recursos-humanos-estacion-programar-horario";}
function PermisosEstacion(){window.location.href = "recursos-humanos-estacion-permisos";}
function ListaNegra(){window.location.href = "recursos-humanos-lista-negra";}
function BajaPersonal(){window.location.href = "recursos-humanos-baja-personal";}
function Vacaciones(){window.location.href = "recursos-humanos-vacaciones";}
function ManualesProcedimientos(){window.location.href = "administracion/manual-procedimiento";}

function NominaV2(){window.location.href = "recursos-humanos-recibos-nomina";}
function NominaV2ES(){window.location.href = "recibos-nomina";}

function RolComodines(){window.location.href = "recursos-humanos-roles";}
function IncidenciasNomina(){window.location.href = "recursos-humanos-incidencia-nomina";}
 
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
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Recursos humanos</li>
  </ol>
  </div>
   
  <div class="row"> 
  <div class="col-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Recursos humanos</h3> </div>
  </div>

  <hr>
  </div>
  
  
  <?php 
  if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
  include_once "app/vistas/personal-general/2-recursos-humanos/contenido-recursos-humanos.php";
  
  }else{
  include_once "app/vistas/administrador/2-recursos-humanos/contenido-recursos-humanos.php";

  }

  ?>

  <!---------- LAS 4T ---------->
  <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 mb-1 mt-2"> 
  <div class="p-2" style="background: #215d98">
  <h3 class="text-center text-white">4 T</h3>

  <ol class="text-white">
  <dt><h5>Transferir</h5></dt>
  <dt><h5>Transformar</h5></dt>
  <dt><h5>Tolerar</h5></dt>
  <dt><h5>Terminar</h5></dt>
  </ol>

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