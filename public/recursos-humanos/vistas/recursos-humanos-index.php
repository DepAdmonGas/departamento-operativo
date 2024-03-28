<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

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
function Organigrama(){window.location.href = "recursos-humanos-organigrama";}
function Formatos(){window.location.href = "recursos-humanos-formatos";}
function ListaFormatos(){window.location.href = "recursos-humanos-lista-formatos";}
function Personal(){window.location.href = "recursos-humanos-personal";}
function HorarioPersonal(){window.location.href = "recursos-humanos-horario-personal";}
function Nomina(){window.location.href = "recursos-humanos-nomina";}
function NominaEncargado(){window.location.href = "recibo-nomina";}
function Permisos(){window.location.href = "recursos-humanos-permisos";}
function Configuracion(){window.location.href = "recursos-humanos-configuracion";}
function Asistencia(){window.location.href = "recursos-humanos-asistencia";}
//------------------------------------------------------------------------------------------
function OrganigramaEstacion(){window.location.href = "recursos-humanos-estacion-organigrama";} 
function PersonalEstacion(){window.location.href = "recursos-humanos-estacion-personal";}
function HorarioPersonalEstacion(){window.location.href = "recursos-humanos-estacion-horario-personal";}
function AsistenciaEstacion(){window.location.href = "recursos-humanos-estacion-asistencia";}
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

  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3">

    <div class="row">
    <div class="col-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

     <h5>Recursos humanos</h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

<?php 
if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
?>

<div class="row">

<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12"> 

<!---------- CONTROL DIRRECCIÓN DE OPERACIONES (ESTACIONES) ---------->
<div class="col-12 mb-3"> 
<div class="border-0 p-3 bg-light">
<h6>Dirección de Operaciones</h6>
<hr>

<div class="row">
<!----- 1. Organigrama ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer bg-white" onclick="OrganigramaEstacion()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Organigrama</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>organigrama.png">
  </div>
  </div>
</div> 

<!----- 2. Control de Documentos del Personal ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer bg-white" onclick="PersonalEstacion()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Control de Documentos del Personal</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>personal.png">
  </div>
  </div>
</div> 

<!----- 3. Formatos (V2)----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer bg-white" onclick="FormatosEstacion()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Formatos</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>formatos.png">
  </div>
  </div>
</div> 


</div>
</div>
</div> 

<!---------- ESTACIONES (ENCARGADOS Y ASISTENTE ADMIN) ---------->
<div class="col-12 mb-3"> 
<div class="border-0 p-3 bg-light">
<h6>Estación</h6>
<hr>
<div class="row">
 
<!----- 2. Horario personal ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer bg-white" onclick="HorarioPersonalEstacion()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Horario personal</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>calendario.png">
  </div>
  </div>
  </div> 
 
<!----- 3. Biometricos (Asistencia) ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer bg-white" onclick="AsistenciaEstacion()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Biometricos</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>asistencia.png">
  </div>
  </div>
</div> 

<!----- 4. Recibos de nomina ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer bg-white" onclick="NominaV2ES()">           
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Recibos de nomina</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>nomina.png">
  </div>
  </div>
</div> 
 
<!----- 5. Permisos ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer bg-white" onclick="PermisosEstacion()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Permisos</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>permisos.png">
  </div>
  </div>
</div>  


<!----- 6. Programar Horario ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer bg-white" onclick="ProgramarHorario()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Programar Horario</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>temporizador.png">
  </div>
  </div>
</div> 


<!----- 7. Lista negra ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer bg-white" onclick="ListaNegraEstacion()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Lista negra</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>lista-negra.png">
  </div>
  </div>
</div> 

<!----- Otros apartados
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer" onclick="ConfiguracionEstacion()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Configuración</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>configuracion.png">
  </div>
  </div>
</div> 
----->

</div>
</div>
</div>


</div>


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

  <?php
  }else{
  ?>
 

<div class="row">
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12"> 

<!---------- CONTROL DIRRECCIÓN DE OPERACIONES ---------->
<div class="col-12 mb-3"> 
<div class="border-0 p-3 bg-light">
<h6>Dirección de Operaciones</h6>
<hr>

<div class="row">

<!----- 1. Organigrama ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer bg-white" onclick="Organigrama()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Organigrama</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>organigrama.png">
  </div>
  </div>
</div>

<!----- 2. Control de documentos del personal ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer bg-white"  onclick="Personal()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Control de Documentos del Personal</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>personal.png">
  </div>
  </div>
</div>

<!----- 3. Formatos (V2)----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer bg-white" onclick="ListaFormatos()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Formatos</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>formatos.png">
  </div>
  </div>
</div>


<!--  3. Formatos (V1)
  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">

  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer" onclick="Formatos()">  
  <?php
  $ToSolicitud = ToSolicitud($con);
  ?>

  <div class="row mx-1">
  <div class="col-12 mt-3">
    <span class="badge rounded-pill tables-bg float-end"> <?=$ToSolicitud?></span>
  </div>
  </div>

  <div class="col-12 text-center text-secondary mb-3">
  <h5>Formatos</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>formatos.png">
  </div>
  </div>
  </div> 

-->

</div>
</div>
</div>


<!---------- ESTACIONES ---------->
<div class="col-12 mb-3"> 
<div class="border-0 p-3 bg-light">
<h6>Estaciones</h6>
<hr>
<div class="row">

<!----- 2. Horario de personal ----->
<?php if($Session_IDUsuarioBD != 354){ ?>
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer bg-white" onclick="HorarioPersonal()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Horario personal</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>calendario.png">
  </div>
  </div>
</div>
<?php } ?>


<!----- 3. Biometricos (Asistencia) ----->
<?php if($Session_IDUsuarioBD != 354){ ?>
  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer bg-white" onclick="Asistencia()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Biometricos</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>asistencia.png">
  </div>
  </div>
  </div>  
<?php 
  }else{
  
  }  
?>

<!----- 4. Recibos de Nomina ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer bg-white" onclick="NominaV2()">     

  <div class="row mx-1">
  <div class="col-12 mt-3">
    <span class="badge rounded-pill tables-bg float-end"></span>
  </div>
  </div>

     
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Recibos de nomina</h5>  
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>nomina.png">
  </div>
  </div>
</div> 
 

<?php 
if($Session_IDUsuarioBD == 354){
?> 

<!----- 9. Rol de Comodines  ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer bg-white" onclick="RolComodines()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Rol de Comodines</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>calendario.png">
  </div>
  </div>
</div> 

<?php
}
?>



<!----- 5. Permisos ----->
<?php if($Session_IDUsuarioBD != 354){ ?>
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
 
  <?php
  $ToSolicitudPermisos = ToSolicitudPermisos($con);
  ?>

  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer bg-white" onclick="Permisos()">   

  <div class="row mx-1">
  <div class="col-12 mt-3">
  <span class="badge rounded-pill tables-bg float-end"> <?=$ToSolicitudPermisos?></span>
  </div>
  </div>

  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Permisos</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>permisos.png">
  </div>
  </div>

</div>  
<?php } ?>


<?php 
if($session_nompuesto == "Dirección de operaciones " || $Session_IDUsuarioBD != 354){
?>
<!----- 5. Incidencias de nomina ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer bg-white" onclick="IncidenciasNomina()">     

  <div class="row mx-1">
  <div class="col-12 mt-3">
    <span class="badge rounded-pill tables-bg float-end"></span>
  </div>
  </div>

     
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Incidencias de nomina</h5>  
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>incidente-nomina.png">
  </div>
  </div>
</div> 

<?php } ?>


<!----- 6. Baja de Personal ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer bg-white" onclick="BajaPersonal()">

  <?php
  $ToSolicitudBaja = ToSolicitudBaja($con);
  ?>

  <div class="row mx-1">
  <div class="col-12 mt-3">
    <span class="badge rounded-pill tables-bg float-end"> <?=$ToSolicitudBaja?></span>
  </div>
  </div>

  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Baja personal</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>baja-personal.png">
  </div>
  </div>
</div> 


<!----- 7. Lista Negra ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer bg-white" onclick="ListaNegra()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Lista negra</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>lista-negra.png">
  </div>
  </div>
</div> 


<!----- 8. Vacaciones ----->
<div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer bg-white" onclick="Vacaciones()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Vacaciones</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>vacaciones.png">
  </div>
  </div>
</div> 



<!-- Apartados Varios 
<?php if($Session_IDUsuarioBD != 354){ ?>
  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer" onclick="Configuracion()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Configuración</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>configuracion.png">
  </div>
  </div>
  </div>    
  <?php } ?>



  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer" onclick="Vacaciones()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Incidencias</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>vacaciones.png">
  </div>
  </div>
  </div> 


    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-2 mb-1">
  <div class="card card-menu-RH rounded shadow-sm p-0 mb-2 pointer" onclick="ManualesProcedimientos()">          
  <div class="col-12 text-center text-secondary mt-2 mb-3">
  <h5>Manuales de procedimientos</h5>
  <img class="pt-2" src="<?=RUTA_IMG_ICONOS;?>formatos.png">
  </div>
  </div>
  </div> 
-->


</div>
</div>
</div>
</div>



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

<?php
}
?>

  </div>
  </div>
  </div>

  </div>
  </div>

  </div>



      <div class="modal" id="Modal">
      <div class="modal-dialog modal-lg">
      <div class="modal-content" style="margin-top: 83px;">
      <div id="ContenidoModal"></div>
      </div>
      </div>
      </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

</body>
</html>