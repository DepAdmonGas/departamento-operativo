<?php
require('app/help.php');
$ClassRecursosHumanosGeneral->ValAsistencia($Session_IDEstacion,1);

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
 
  idEstacion = sessionStorage.getItem('idestacion');
  SelEstacion(idEstacion)

  } 
      
  }
 
  });  

    function Regresar(){
    sessionStorage.removeItem('idestacion');
    window.history.back();
    }


    function ConfiguracionBiometrico(valBiometrico){
    if(valBiometrico == 1){
    window.location.href = "recursos-humanos-configuracion";
    }    
    }


  function SelEstacion(idEstacion) {
  let targets;
  targets = [8];
  sizeWindow();  
  sessionStorage.setItem('idestacion', idEstacion);

  $('#ListaAsistencia').load('app/vistas/contenido/2-recursos-humanos/biometrico/lista-biometrico-estaciones.php?idEstacion=' + idEstacion, function() {
  $('#tabla_biometrico_' + idEstacion).DataTable({
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





    function SelEstacionReturn(idEstacion){
    sessionStorage.setItem('idestacion', idEstacion);
    $('#ListaAsistencia').load('public/recursos-humanos/vistas/contenido-recursos-humanos-asistencia.php?idEstacion=' + idEstacion);
  }


function ModalDetalleI(idPersonal,id,idEstacion){
$('#ModalIncidencias').modal('show');
$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-detalle-incidencias.php?idAsistencia=' + id);  
}  

function ModalIncidencias(idPersonal,id,idEstacion){
$('#ModalIncidencias').modal('show');
$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-incidencias.php?idAsistencia=' + id + '&idPersonal=' + idPersonal + '&idEstacion=' + idEstacion); 
}

function GuardarIncidencia(idAsistencia,idEstacion){

var Comentario = $('#Comentario').val();
 
if(document.querySelector('input[name="CheckBox"]:checked')) {
var incidencia = document.querySelector('input[name="CheckBox"]:checked').value;
$('#bordercheck').css('border','');
if(Comentario != ""){
$('#Comentario').css('border','');

alertify.confirm('',
function(){

var parametros = {
"idAsistencia" : idAsistencia,
"incidencia" : incidencia,
"Comentario" : Comentario
};

$.ajax({
data:  parametros,
url:   'public/recursos-humanos/modelo/agregar-incidencia.php',
type:  'POST',
        
beforeSend: function() {
$(".LoaderPage").show();
},

complete: function(){
},

success:  function (response) {

if(response == 1){
$(".LoaderPage").hide();
$('#ModalIncidencias').modal('hide'); 
alertify.success('Se creo la incidencia');
SelEstacion(idEstacion)
sizeWindow()
}else{
$(".LoaderPage").hide();
alertify.error('Error al crear la incidencia');
}
 
}
});

},
function(){
}).setHeader('Agregar Incidencia').set({transition:'zoom',message: '¿Desea agregar incidenia?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

}else{
$('#Comentario').css('border','2px solid #A52525');    
}
}else{
$('#bordercheck').css('border','2px solid #A52525'); 
}

}

function EditarSaldoTMR(idAsistencia){

var SueldoDiaTMR = $('#SueldoDiaTMR').val();

if(SueldoDiaTMR != ""){
$('#SueldoDiaTMR').css('border','');

alertify.confirm('',
function(){

var parametros = {
"idAsistencia" : idAsistencia,
"SueldoDiaTMR" : SueldoDiaTMR
};

$.ajax({
data:  parametros,
url:   'public/recursos-humanos/modelo/editar-sueldo-incidencia.php',
type:  'POST',
        
beforeSend: function() {
},
complete: function(){
},
success:  function (response) {

if(response == 1){

alertify.success('Se edito la incidencia');
$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-incidencias.php?idAsistencia=' + idAsistencia); 

}else{
$(".LoaderPage").hide();
alertify.error('Error al editar la incidencia');
}
 
}
});

},
function(){
}).setHeader('Editar sueldo').set({transition:'zoom',message: '¿Desea editar el sueldo del día?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

}else{
$('#SueldoDiaTMR').css('border','2px solid #A52525'); 
}

} 

function GuardarDoc(idPersonal,idAsistencia,idEstacion){
var data = new FormData();
var url = 'public/recursos-humanos/modelo/agregar-documento-incidencia.php';

var FechaInicio = $('#FechaIni').val();
var FechaFin = $('#FechaFin').val();
var SueldoDiaI = $('#SueldoDiaI').val();

var Documento = document.getElementById("Documento");
var Documento_file = Documento.files[0];
var Documento_filePath = Documento.value;
var Documento_ext = $("#Documento").val().split('.').pop();

if(Documento_ext == "pdf"){
if(FechaInicio < FechaFin){
$('#FechaFin').css('border',''); 

data.append('Documento_file', Documento_file);
data.append('idPersonal', idPersonal);
data.append('idAsistencia', idAsistencia);
data.append('idEstacion', idEstacion);
data.append('FechaInicio', FechaInicio);
data.append('FechaFin', FechaFin);
data.append('SueldoDiaI', SueldoDiaI);

$.ajax({
url: url,
type: 'POST',
contentType: false,
data: data,
processData: false,
cache: false
}).done(function(data){

if(data == 1){
alertify.success('Se agrego el documento');
$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-incidencias.php?idAsistencia=' + idAsistencia); 
SelEstacion(idEstacion)
  
}else{
alertify.error('Error al agregar el documento');
}
 
}); 

}else{
$('#FechaFin').css('border','2px solid #A52525'); 
}
}else{
$('#Resultado').html('<div class="text-center text-danger"><small>El formato debe ser PDF</small></div>');
}
}
//---------------------------------------------------------------------
//---------------------------------------------------------------------
function ModalReporte(idEstacion){
$('#ModalIncidencias').modal('show');
$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-reporte-asistencia.php?idEstacion=' + idEstacion); 
} 
 
function btnBuscar(idEstacion){ 
 
var Year = $('#Year').val();
var Mes = $('#Mes').val();

if(Year != ""){ 
$('#Year').css('border','');
if(Mes != ""){
$('#Mes').css('border',''); 

$('#ModalIncidencias').modal('hide');
//$('#ListaAsistencia').load('public/recursos-humanos/vistas/contenido-recursos-humanos-reporte-asistencia.php?idEstacion=' + idEstacion + '&Year=' + Year + '&Mes=' + Mes);
$('#ListaAsistencia').load('public/recursos-humanos/vistas/contenido-recursos-humanos-reporte-asistencia-v2.php?idEstacion=' + idEstacion + '&Year=' + Year + '&Mes=' + Mes + '&Val=1');        



}else{
$('#Mes').css('border','2px solid #A52525'); 
}
}else{
$('#Year').css('border','2px solid #A52525'); 
}

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
    <a class="pointer" onclick="Configuracion()">
    <i class="fa-solid fa-gear" aria-hidden="true" style="padding-right: 10px;"></i><b>Configuración</b>
    </a>
    </li>
 
  <?php

  $FInicio = date("Y").'-'.date("m").'-01';
  $FTermino = date("Y-m-t", strtotime($FInicio));

  $sql_listaestacion = "SELECT id, numlista, localidad FROM op_rh_localidades WHERE numlista <= 9 OR numlista = 10 ORDER BY numlista ASC";
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
    <a class="pointer" onclick="SelEstacion('.$id.')">
    <i class="'.$icon.'" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
}
  
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
  <a class="text-dark" onclick="history.back()">Recursos humanos</a>
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
  <div class="row"> <div class="col-12" id="ListaAsistencia"></div> </div>
  </div> 

  </div>

</div>


  <!---------- MODAL ----------> 
  <div class="modal fade" id="ModalIncidencias" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
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