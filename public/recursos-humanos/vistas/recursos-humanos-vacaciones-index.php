<?php
require('app/help.php');

function ToSolicitudVacaciones($idEstacion, $year, $con){
$sql_lista = "SELECT id FROM op_rh_formatos WHERE formato = 6 AND status = 1  AND id_localidad = '".$idEstacion."' AND YEAR(fecha) = '".$year."'";
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
  <link href="<?=RUTA_CSS2;?>navbar-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <script src="<?=RUTA_JS?>size-window.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
  <script type="text/javascript" src="<?=RUTA_JS ?>alertify.js"></script> 

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  sizeWindow();

  if(sessionStorage){
  if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {
  idestacion = sessionStorage.getItem('idestacion');
  SelEstacion(idestacion,<?=$fecha_year;?>) 
  }
  }
 
  });

  function Regresar(){
  sessionStorage.removeItem('idestacion');
  window.history.back();
  }


  function Tabulador(){
  sizeWindow();

  $('#ListaNegra').load('public/recursos-humanos/vistas/contenido-recursos-humanos-tabulador.php', function() {
  $('#tabla_tabulador').DataTable({
  "language": {
  "url": "<?=RUTA_JS2?>/es-ES.json"
  },
  "order": [[1, "asc"]],
  "lengthMenu": [15, 30, 50, 100]
  });
  });
  
  }

  function SelEstacion(idEstacion,Year){
  let targets;
  sizeWindow();
  sessionStorage.setItem('idestacion', idEstacion);
  targets = [5, 10, 11, 12];

  $('#ListaNegra').load('public/recursos-humanos/vistas/contenido-recursos-humanos-vacaciones.php?idEstacion=' + idEstacion + '&Year=' + Year, function() {
  $('#tabla_vacaciones_' + idEstacion + '_' + Year).DataTable({
  "language": {
  "url": "<?=RUTA_JS2?>/es-ES.json"
  },
  "order": [[0, "asc"]],
  "lengthMenu": [15, 30, 50, 100],
  "columnDefs": [
  { "orderable": false, "targets": targets },
  { "searchable": false, "targets": targets }
  ]
  });
  });
  
  }


  function Modal(idEstacion){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-baja-personal.php?idEstacion=' + idEstacion);
  }  

  function ModalDetalle(id){
  $('#Modal').modal('show');
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-pago-vacaciones.php?id=' + id);
  } 

  function Descargar(id){
  window.location.href = "recursos-humanos-vacaciones-pdf/" + id;  
  }
  function FirmarPV(id){
  window.location.href = "recursos-humanos-vacaciones-firmar/" + id;  
  }

  //---------------------------------------------------------------------
  function Formulario(Formato,idEstacion){
  var parametros = {
  "idEstacion" : idEstacion,
  "Formato" : Formato
  };

  $.ajax({
  data:  parametros,
  url:   'public/recursos-humanos/modelo/agregar-formato.php',
  type:  'post',
  beforeSend: function() {
    
  },
  complete: function(){

  },
  success:  function (response) {

  if (response != 0) {
  SelEstacion(idEstacion);

  sessionStorage.setItem('idestacion', idEstacion);
  window.location.href = "recursos-humanos-formulario-vacaciones-personal/" + idEstacion + '/' + response; 
    
  }else{
  alertify.error('Error al crear');  
  }

  }
  });
 
  }

  function EditFormulario(idEstacion,idReporte,Formato){

    sessionStorage.setItem('idestacion', idEstacion);
    window.location.href = "recursos-humanos-formulario-vacaciones-personal/" + idEstacion + '/' + Formato; 

}

function DeleteFormulario(idEstacion,idPersonal,Year,id){

     alertify.confirm('',
     function(){

    var parametros = {
        "idFormulario" : id
        };

        $.ajax({
        data:  parametros,
        url:   'public/recursos-humanos/modelo/formulario-alta-eliminar.php',
        type:  'post',
        beforeSend: function() {
        },
        complete: function(){

        },
        success:  function (response) {

          if(response == 1){
          SelEstacion(idEstacion, Year)
          $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-formulario5.php?idPersonal=' + idPersonal + '&Year=' + Year);
          }else{
          alertify.error('Error al eliminar');    
          }

        }
        });

     },
     function(){

     }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

    }

  function ModalComentario(idEstacion,idPersonal,Year){
  $('#ModalComentario').modal('show');  
  $('#ContenidoModalComentario').load('public/recursos-humanos/vistas/modal-comentarios-vacaciones.php?idPersonal=' + idPersonal + '&Year=' + Year + '&idEstacion=' + idEstacion );
  }

  function regresarModal(idPersonal,Year){
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-formulario5.php?idPersonal=' + idPersonal + '&Year=' + Year);

  }

  function GuardarComentario(idPersonal,Year,idEstacion){

    var Comentario = $('#Comentario').val();

    var parametros = {
    "idPersonal" : idPersonal,
    "Year" : Year,
    "Comentario" : Comentario
    };

    if(Comentario != ""){
    $('#Comentario').css('border',''); 

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/agregar-comentario-vacaciones.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    $('#Comentario').val('');
    SelEstacion(idEstacion, Year)   
    sizeWindow(); 
    $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-comentarios-vacaciones.php?idPersonal=' + idPersonal + '&Year=' + Year + '&idEstacion=' + idEstacion );
    }else{
     alertify.error('Error al guardar el comentario');  
    }

    }
    });

    }else{
    $('#Comentario').css('border','2px solid #A52525'); 
    }

    }

    function Firmar(idEstacion,idFormato){
    sessionStorage.setItem('idestacion', idEstacion);
    window.location.href = "recursos-humanos-formatos-firma/" + idFormato; 
    }

    function DescargarPDF(idFormato){
    window.location.href = "recursos-humanos-formatos-pdf/" + idFormato;  
    }

    function detalleVacaciones2(idReporte,idPersonal,year){
    $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-vacaciones-personal.php?idReporte=' + idReporte + '&idPersonal=' + idPersonal + '&year=' + year);

    }

    
    function DetalleFormulario(idFormato,Year,Formato){

    $('#Modal').modal('show');  
    if(Formato == 1){
    $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-formulario1.php?idFormato=' + idFormato);
    }else if(Formato == 2){
     $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-formulario2.php?idFormato=' + idFormato);
    }else if(Formato == 3){
    $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-formulario3.php?idFormato=' + idFormato);
    }else if(Formato == 4){
    $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-formulario4.php?idFormato=' + idFormato);
    }else if(Formato == 5){
    $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-formulario5.php?idPersonal=' + idFormato + '&Year=' + Year);
    }else if(Formato == 6){
    $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-formulario6.php?idFormato=' + idFormato);
    }
   
    }

  function ModalBuscar(idEstacion){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-buscar-vacaciones.php?idEstacion=' + idEstacion);
  }

  function Buscar(idEstacion){
  let Year = $('#Year').val();

  if(Year != ""){
  $('#Year').css('border',''); 

  $('#Modal').modal('hide');  
  SelEstacion(idEstacion, Year);

  }else{
  $('#Year').css('border','2px solid #A52525'); 
  }
  }

  window.addEventListener('pageshow', function(event) {
  if (event.persisted) {
  // Si la página está en la caché del navegador, recargarla
  window.location.reload();
  }
  });

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
   
    <li>
    <a class="pointer" href="<?=SERVIDOR_ADMIN?>">
    <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i>Menu
    </a>
    </li>


    <li>
    <a class="pointer" onclick="Regresar()">
    <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
    </a>
    </li>
 
   <li>
    <a class="pointer" onclick="Tabulador()">
    <i class="fa-solid fa-screwdriver-wrench" aria-hidden="true" style="padding-right: 10px;"></i>Tabulador
    </a>
  </li>

  <?php

  $FInicio = date("Y").'-'.date("m").'-01';
  $FTermino = date("Y-m-t", strtotime($FInicio));

  $GET_year_actual = date("Y");


  $sql_listaestacion = "SELECT id, numlista, localidad FROM op_rh_localidades WHERE numlista <= 8 OR numlista = 10 OR numlista = 12 OR numlista = 14 OR numlista = 15 OR numlista = 16  OR numlista = 17 ORDER BY numlista ASC";
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


$ToSolicitud = ToSolicitudVacaciones($id,$GET_year_actual,$con);

  if($ToSolicitud > 0){
    $Total = '<div class="float-end"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToSolicitud.'</small></span></div>';
  }else{
   $Total = ''; 
  }


  echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.','.$fecha_year.')">
    <i class="'.$icon.'" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$Total .' '.$estacion.'
    </a>
  </li>';

  }
  ?> 


</ul>
</nav>

  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
 <nav class="navbar navbar-expand navbar-light navbar-bg" >
  
  <i class="fa-solid fa-bars menu-btn rounded pointer" 
  id="sidebarCollapse"></i>

  <div class="pointer">
  <a class="text-dark" onclick="history.back()">Vacaciones</a>
  </div>
 
   
  <div class="navbar-collapse collapse">

  <div class="dropdown-divider"></div>

  <ul class="navbar-nav navbar-align">

  <li class="nav-item dropdown">
  <a class=" dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
  <i class="align-middle" data-feather="settings"></i>
  </a>

 
  <a class="nav-link dropdown-toggle d-none d-sm-inline-block pointer" data-bs-toggle="dropdown">
  
  <img src="<?=RUTA_IMG_ICONOS."usuarioBar.png";?>" class="avatar img-fluid rounded-circle"/>

  <span class="text-dark" style="padding-left: 10px;">
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
  <div class="col-12" id="ListaNegra"></div> 
  </div>
  </div> 

  </div>

<!---------- MODAL COMENTARIO ----------> 
<div class="modal fade" id="ModalComentario" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
  <div class="modal-content" id="ContenidoModalComentario">
  </div>
  </div>
  </div>


  <!---------- MODAL 1 ----------> 
  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="ContenidoModal">
  </div>
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