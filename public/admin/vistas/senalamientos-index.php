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
  <title>Departamento Operativo</title>
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
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" ></script>
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>selectize.css">
 
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  sizeWindow();

  });

  function Regresar(){
  window.history.back(); 
  }
 
  function Senalamientos(valor){ 
  sizeWindow();
  $('#ListaSenalamientos').load('../public/admin/vistas/lista-senalamientos.php?Senalamiento=' + valor); 
  }   

  function Agregar(Senalamiento){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('../public/admin/vistas/modal-agregar-senalamientos.php?Senalamiento=' + Senalamiento);
  } 

 
  function agregarFila(){
  document.getElementById("tablaprueba").insertRow(-1).innerHTML = 
  '<td class="p-0 m-0"><input type="text" class="form-control p-0 m-0 border-0" name="titulo[]" /></td><td class="p-0 m-0"><input type="text" class="form-control p-0 m-0 border-0" name="color[]" /></td>';
}

function eliminarFila(){
  var table = document.getElementById("tablaprueba");
  var rowCount = table.rows.length;
  
  if(rowCount <= 1)
    alert('No se puede eliminar el encabezado');
  else
    table.deleteRow(rowCount -1);
}

function Guardar(Senalamiento){

var seleccionArchivos = document.getElementById("seleccionArchivos");
var seleccionArchivos_file = seleccionArchivos.files[0];
var seleccionArchivos_filePath = seleccionArchivos.value;

var Dimension = $('#Dimension').val();
var Ubicacion = $('#Ubicacion').val();
var Reproduccion = $('#Reproduccion').val();
var vinil = $('#vinil').val();
var placa = $('#placa').val();

var URL = "../public/admin/modelo/agregar-senalamientos.php";
var data = new FormData();

data.append('Senalamiento', Senalamiento);
data.append('seleccionArchivos_file', seleccionArchivos_file);
data.append('Dimension', Dimension);
data.append('Ubicacion', Ubicacion);
data.append('Reproduccion', Reproduccion);
data.append('vinil', vinil);
data.append('placa', placa);
data.append('dato', 1);

$(".LoaderPage").show();

$.ajax({
url: URL,
type: 'POST',
contentType: false,
data: data,
processData: false,
cache: false
}).done(function(data){


if(data == 0){
alertify.error('Error al agregar');   
}else{

var titulo = document.getElementsByName('titulo[]');
var color = document.getElementsByName('color[]');
for (var x = 0; x < titulo.length; x++) 
{
var DTitulo = titulo[x];
var DColor = color[x];
Detalle(data,DTitulo.value,DColor.value);
}
Senalamientos(Senalamiento)       
$('#Modal').modal('hide');   
sizeWindow();
alertify.success('Registro eliminado exitosamente.');

$(".LoaderPage").hide();
}

 
});
}

function Detalle(idSenalamiento,detalleTitulo,detalleColor){

var parametros = {
    "idSenalamiento" : idSenalamiento,
    "detalleTitulo" : detalleTitulo,
    "detalleColor" : detalleColor,
    "dato" : 1
    };

    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/agregar-senalamientos-color.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {


    }
    });

}

    function Eliminar(Senalamiento,id){

    var parametros = {
    "id" : id,
    "dato" : 1
    };


alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/eliminar-senalamientos.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    Senalamientos(Senalamiento);  
    sizeWindow() 
    alertify.success('Registro eliminado exitosamente.');   
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

    }

    function ModalEditar(Senalamiento,id){
    $('#Modal').modal('show');  
    $('#ContenidoModal').load('../public/admin/vistas/modal-editar-senalamientos.php?Senalamiento=' + Senalamiento + '&idSenalamiento=' + id);
    }
 

    function EliminarColor(Senalamiento,idSenalamiento,idColor){

    var parametros = {
    "id" : idColor,
    "dato" : 2
    }; 

    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/eliminar-senalamientos.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    Senalamientos(Senalamiento); 
    sizeWindow()
    $('#ContenidoModal').load('../public/admin/vistas/modal-editar-senalamientos.php?Senalamiento=' + Senalamiento + '&idSenalamiento=' + idSenalamiento);      
    }

    }
    });

   }

   function AgregarColor(Senalamiento,idSenalamiento){

    var parametros = {
    "idSenalamiento" : idSenalamiento,
    "detalleTitulo" : "",
    "detalleColor" : "",
    "dato" : 1
    }; 

    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/agregar-senalamientos-color.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
      $('#ContenidoModal').load('../public/admin/vistas/modal-editar-senalamientos.php?Senalamiento=' + Senalamiento + '&idSenalamiento=' + idSenalamiento);     
    
    }

    }
    });

   }

   function EditarColor(e,Senalamiento,idSenalamiento,idColor,dato){
   var contenido = e.value;

     var parametros = {
    "idColor" : idColor,
    "dato" : dato,
    "contenido" : contenido
    }; 

    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/agregar-senalamientos-color.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    Senalamientos(Senalamiento);
    sizeWindow()     
    }

    }
    });
   }

   function Editar(Senalamiento,idSenalamiento){ 

var seleccionArchivos = document.getElementById("seleccionArchivos");
var seleccionArchivos_file = seleccionArchivos.files[0];
var seleccionArchivos_filePath = seleccionArchivos.value;

var Dimension = $('#Dimension').val();
var Ubicacion = $('#Ubicacion').val();
var Reproduccion = $('#Reproduccion').val();
var vinil = $('#vinil').val();
var placa = $('#placa').val();

var URL = "../public/admin/modelo/agregar-senalamientos.php";
var data = new FormData();

data.append('idSenalamiento', idSenalamiento);
data.append('seleccionArchivos_file', seleccionArchivos_file);
data.append('Dimension', Dimension);
data.append('Ubicacion', Ubicacion);
data.append('Reproduccion', Reproduccion);
data.append('vinil', vinil);
data.append('placa', placa);
data.append('dato', 2);

$(".LoaderPage").show();

$.ajax({
url: URL,
type: 'POST',
contentType: false,
data: data,
processData: false,
cache: false
}).done(function(data){


if(data == 0){
alertify.error('Error al agregar');   
}else{
Senalamientos(Senalamiento)   
sizeWindow()
alertify.success('Registro editado exitosamente.')    
$('#Modal').modal('hide');   

$(".LoaderPage").hide();
}

 
});
}

function SenalamientosDispensarios(){
window.location.href = "senalamientos-dispensario";   
}


  function AgregarManual(idSenalamiento){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('../public/admin/vistas/modal-archivos-senalamientos.php?idSenalamiento=' + idSenalamiento);
  } 


  function AgregarArchivo(idSenalamiento){
 
var Fecha = $('#Fecha').val();
var Descripcion = $('#Descripcion').val();

var Archivo = document.getElementById("Archivo");
var Archivo_file = Archivo.files[0];
var Archivo_filePath = Archivo.value;


var URL = "../public/admin/modelo/agregar-archivo-senalamientos.php";
var data = new FormData();

data.append('idSenalamiento', idSenalamiento);
data.append('Fecha', Fecha);
data.append('Descripcion', Descripcion);
data.append('Archivo_file', Archivo_file);
 
    if(Fecha != ""){
    $('#Fecha').css('border',''); 

    if(Descripcion != ""){
    $('#Descripcion').css('border',''); 

    if(Archivo_filePath != ""){
    $('#Archivo').css('border',''); 

$(".LoaderPage").show();

$.ajax({ 
url: URL,
type: 'POST',
contentType: false,
data: data,
processData: false,
cache: false
}).done(function(data){ 


if(data == 0){
alertify.error('Error al agregar');   
}else{
$('#ContenidoModal').load('../public/admin/vistas/modal-archivos-senalamientos.php?idSenalamiento=' + idSenalamiento);
alertify.success('Archivo agregado exitosamente.')
$(".LoaderPage").hide();  
}

});

    }else{
    $('#Archivo').css('border','2px solid #A52525'); 
    }

    }else{
    $('#Descripcion').css('border','2px solid #A52525'); 
    }

    }else{
    $('#Fecha').css('border','2px solid #A52525'); 
    }

  } 

 


  function EliminarArchivo(idArchivo,idSenalamiento){
    
   var parametros = {
  "idArchivo" : idArchivo
   };


   alertify.confirm('',
   function(){

    $(".LoaderPage").show();

    $.ajax({
    data:  parametros,   
    url:   '../public/admin/modelo/eliminar-archivo-senalamiento.php',
     type:  'post',
    beforeSend: function() {
    }, 
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    alertify.success('Archivo eliminado exitosamente.')
    $('#ContenidoModal').load('../public/admin/vistas/modal-archivos-senalamientos.php?idSenalamiento=' + idSenalamiento);
    $(".LoaderPage").hide();

    }else{
    alertify.error('Error al eliminar el archivo'); 
    $(".LoaderPage").hide();
 
    }

    }
    });

  },
  function(){

  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el archivo seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

 
  }
     


</script>
</head>

<body class="bodyAG"> 

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
    <a class="pointer" onclick="Senalamientos(1)">
        <i class="fa-solid fa-scale-balanced" aria-hidden="true" style="padding-right: 10px;"></i>NOM-003-SEGOB-2011
    </a>
  </li>

    <li>
    <a class="pointer" onclick="Senalamientos(2)">
    <i class="fa-solid fa-scale-balanced" aria-hidden="true" style="padding-right: 10px;"></i>NOM-005-ASEA-2016
    </a>
  </li>

  <li>
    <a class="pointer" onclick="Senalamientos(3)">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>IMAGEN G500
    </a>
  </li>

  <li>
    <a class="pointer" onclick="SenalamientosDispensarios()">

      <i class="fa-solid fa-note-sticky" aria-hidden="true" style="padding-right: 10px;"></i>CALCOMANIAS PROFECO
    </a>
  </li>
 

</ul>
</nav>

  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
 <nav class="navbar navbar-expand navbar-light navbar-bg" >
  
  <i class="fa-solid fa-bars menu-btn rounded pointer" 
  id="sidebarCollapse"></i>

  <div class="pointer">
  <a class="text-dark" onclick="history.back()">Señalamientos</a>
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
  
  <div class="col-12 mb-3">
  <div id="ListaSenalamientos" class="cardAG"></div>
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
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

</body>
</html>

