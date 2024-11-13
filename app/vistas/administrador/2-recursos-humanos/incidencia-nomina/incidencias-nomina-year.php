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
  <link href="<?=RUTA_CSS2;?>navbar-utilities.min.css" rel="stylesheet" />
  <link href="<?=RUTA_CSS2;?>cards-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <script src="<?=RUTA_JS?>size-window.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
 
  <script type="text/javascript">
  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  sizeWindow();

  if(sessionStorage){
  if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {

  idEstacion = sessionStorage.getItem('idestacion');
  year = sessionStorage.getItem('year');
  semana = sessionStorage.getItem('semana');

  SelEstacion(idEstacion,year,semana)
  }  
      
  }
 
  });  

  function Regresar(){
  window.history.back();
  }


  function SelEstacion(idEstacion,year,semana){
  sizeWindow();  
  sessionStorage.setItem('idestacion', idEstacion);
  sessionStorage.setItem('year', year);
  sessionStorage.setItem('semana', semana);

  let referencia, targets;
  targets = [10, 11, 12];

  $('#ListaIncidencia').load('../app/vistas/administrador/2-recursos-humanos/incidencia-nomina/lista-incidencias-nomina.php?idEstacion=' + idEstacion + '&year=' + year + '&semana=' + semana, function() {
  $('#tabla_incidencias_' + idEstacion + '_' + year + '_' + semana).DataTable({
    "stateSave": true,
    "language": {
    "url": "<?=RUTA_JS2?>/es-ES.json"
    },
    "order": [[0, "asc"]],
    "lengthMenu": [25, 50, 75, 100],
    "columnDefs": [
    { "orderable": false, "targets": targets },
    { "searchable": false, "targets": targets }
    ]
    });
    });
 
  }
  
  function SelNoSemana(idEstacion,year){
  sizeWindow();
  var semana = $('#SemanaEstacion_' + idEstacion).val();
  sessionStorage.setItem('semana', semana);

  SelEstacion(idEstacion,year,semana)
  }


  function RolComodines(){
  window.location.href = "../recursos-humanos-rol-comodines";
  sessionStorage.removeItem('idEstacion');
  sessionStorage.removeItem('year');
  sessionStorage.removeItem('semana');
  }

  function RolDiaDoble(year){
  window.location.href = "../recursos-humanos-dia-doble/" + year;
  sessionStorage.removeItem('idEstacion');
  sessionStorage.removeItem('year');
  sessionStorage.removeItem('semana');
  }

  </script>
  </head>

  <body> 
  <div class="LoaderPage"></div>
  
  <!---------- CONTENIDO Y BARRA DE NAVEGACION ---------->
  <div class="wrapper"> 
  <!---------- BARRA DE NAVEGACION ---------->
  <nav id="sidebar">
          
  <div class="sidebar-header text-center">
  <img class="" src="<?=RUTA_IMG_LOGOS."Logo.png";?>" style="width: 100%;">
  </div>

  <ul class="list-unstyled components">
   
  <li id="menu-item">
  <a class="pointer" href="<?=SERVIDOR_ADMIN?>">
  <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i>Menu
  </a>
  </li>

  <!---------- SESIONES CLEAN ---------->
  <script>
  document.addEventListener('DOMContentLoaded', function () {
  var menuItem = document.getElementById('menu-item');
    
  menuItem.addEventListener('click', function () {
  sessionStorage.removeItem('idEstacion');
  sessionStorage.removeItem('year');
  sessionStorage.removeItem('semana');
  });
  });
  </script>


  <li>
    <a class="pointer" onclick="Regresar()">
    <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
    </a>
    </li>

  <?php
  // Obtener la fecha actual
  $currentDate = time(); // Puedes usar una fecha específica con strtotime() si lo deseas

  // Calcular el número de día de la semana (de 1 a 7, donde 4 es jueves y 3 es miércoles)
  $diaSemana = date('N', $currentDate);

  // Si la semana termina el miércoles, ajustamos la fecha para obtener el inicio de la semana
  if ($diaSemana >= 4) {
  $inicioSemana = strtotime('last Wednesday', $currentDate);
  } else {
  $inicioSemana = strtotime('Wednesday last week', $currentDate);
  }

  // Obtener el número de semana actual considerando que la semana comienza el jueves (4)
  $GET_semana = date('W', $inicioSemana);


  $sql_listaestacion = "SELECT id, numlista, localidad FROM op_rh_localidades WHERE numlista <= 9 ORDER BY numlista ASC";
  $result_listaestacion = mysqli_query($con, $sql_listaestacion);
  while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
  $id = $row_listaestacion['id'];
  $estacion = $row_listaestacion['localidad'];

  if($estacion == "Comodines"){
    $icon = "fa-solid fa-users";

  }else if($estacion == "Autolavado"){
    $icon = "fa-solid fa-car";

  }else if($estacion == "Almacen"){
    $icon = "fa-sharp fa-solid fa-shop";

  }else if($estacion == "Directivos"){
    $icon = " fa-solid fa-user-tie"; 

  }else if($estacion == "Servicio Profesionales Operación Servicio y Mantenimiento de Personal"){
    $icon = "fa-solid fa-screwdriver-wrench";

  }else if($estacion == "Dirección de operaciones" ||
    $estacion == "Departamento Gestión" ||
    $estacion == "Departamento Jurídico" ||
    $estacion == "Departamento Mantenimiento" ||
    $estacion == "Departamento Sistemas"){
    $icon = "fa-solid fa-briefcase"; 

  }else{
    $icon = "fa-solid fa-gas-pump";    
  }

  if($id <> 8){
  echo '  
  <li>
  <a class="pointer" onclick="SelEstacion('.$id.','.$GET_year.','.$GET_semana.')">
  <i class="'.$icon.'" aria-hidden="true" style="padding-right: 10px;"></i> '.$estacion.'
  </a>
  </li>';
  }
  
  }
  ?> 

  <li id="menu-item">
  <a class="pointer" onclick="RolDiaDoble(<?=$GET_year?>)">
  <i class="fa-regular fa-calendar-days"></i> Dia Doble
  </a>
  </li>

  <li id="menu-item">
  <a class="pointer" onclick="RolComodines()">
  <i class="fa-solid fa-people-arrows"></i> Rol de cubre encargados
  </a>
  </li>

  </ul>
  </nav>

  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
  <nav class="navbar navbar-expand navbar-light navbar-bg" >
  
  <i class="fa-solid fa-bars menu-btn rounded pointer" id="sidebarCollapse"></i>

  <div class="pointer"><a class="text-dark" onclick="history.back()">Recursos humanos incidencia de nomina</a></div>
 
  <div class="navbar-collapse collapse">
  <div class="dropdown-divider"></div>

  <ul class="navbar-nav navbar-align">

  <li class="nav-item dropdown">
  <a class=" dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
  <i class="align-middle" data-feather="settings"></i>
  </a>

 
  <a class="nav-link dropdown-toggle d-none d-sm-inline-block pointer" data-bs-toggle="dropdown">
  <img src="<?=RUTA_IMG_ICONOS."usuarioBar.png";?>" class="avatar img-fluid rounded-circle"/>
  <span class="text-dark" style="padding-left: 10px;"><?=$session_nompuesto;?>  </span>
  </a>
  
  <div class="dropdown-menu dropdown-menu-end">
  
  <div class="user-box">
  <div class="u-text">
  <p class="text-muted">Nombre de usuario:</p>
  <h4><?=$session_nomusuario;?></h4>
  </div>
  </div>

  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="<?=PERFIL_ADMIN?>"><i class="fa-solid fa-user" style="padding-right: 5px;"></i>Perfil</a>
 
  <div class="dropdown-divider"></div>
  <a class="dropdown-item" href="<?=RUTA_SALIR2?>salir"><i class="fa-solid fa-power-off" style="padding-right: 5px;"></i> Cerrar Sesión</a>
  
  </div>

  </li>
  
  </ul>
  </div>

  </nav>
 
  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG">
  <div class="row">  
  
  <div class="col-12" id="ListaIncidencia"></div> 

  </div>
  </div> 

  </div>

  </div>


  <!---------- MODAL ----------> 
  <div class="modal fade" id="ModalIncidencias" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="ContenidoModal">
  </div>
  </div>
  </div>

  <!---------- MODAL COVID (RIGHT)---------->  
  <div class="modal right fade" id="ModalIncidencia" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
  <div class="modal-content" id="DivIncidencia"></div>
  </div>
  </div>
  

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>

</body>
</html>