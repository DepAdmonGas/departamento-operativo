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
  <link href="<?=RUTA_CSS2;?>navbar-utilities.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  <script src="<?=RUTA_JS?>size-window.js"></script>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  

  <style media="screen">
  .grayscale {
      filter: opacity(50%); 
  }
  </style>

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  $('[data-toggle="tooltip"]').tooltip();
   sizeWindow();
 

    });

  function Regresar(){
   window.history.back();
  }
 
  function SelEstacion(idestacion){
  sizeWindow();
  $('#ListaSenalamientos').load('../public/admin/vistas/lista-senalamientos-dispensarios.php?idEstacion=' + idestacion); 
  } 

  function Agregar(idestacion){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('../public/admin/vistas/modal-agregar-senalamientos-dispensarios.php?idEstacion=' + idestacion);
  } 
 
  function agregarFila(){
  document.getElementById("tablaprueba").insertRow(-1).innerHTML = 
  '<td class="p-0 m-0"><input type="text" class="form-control p-0 m-0 border-0" name="dimension[]" /></td>' +
  '<td class="p-0 m-0"><input type="text" class="form-control p-0 m-0 border-0" name="aprobacion[]" /></td>' +
  '<td class="p-0 m-0"><input type="text" class="form-control p-0 m-0 border-0" name="modelo[]" /></td>' +
  '<td class="p-0 m-0"><input type="text" class="form-control p-0 m-0 border-0" name="numeroserie[]" /></td>' +
  '<td class="p-0 m-0"><input type="text" class="form-control p-0 m-0 border-0" name="material[]" /></td>';
}

function eliminarFila(){
  var table = document.getElementById("tablaprueba");
  var rowCount = table.rows.length;
  
  if(rowCount <= 1)
    alertify.error('No se puede eliminar el encabezado'); 
  else
    table.deleteRow(rowCount -1);
}

function Guardar(idEstacion){

var seleccionArchivos = document.getElementById("seleccionArchivos");
var seleccionArchivos_file = seleccionArchivos.files[0];
var seleccionArchivos_filePath = seleccionArchivos.value;

var Dispensario = $('#Dispensario').val();

var URL = "../public/admin/modelo/agregar-senalamientos-dispensario.php";
var data = new FormData();

data.append('idEstacion', idEstacion);
data.append('seleccionArchivos_file', seleccionArchivos_file);
data.append('Dispensario', Dispensario);
data.append('dato', 1);

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

var dimension = document.getElementsByName('dimension[]');
var aprobacion = document.getElementsByName('aprobacion[]');
var modelo = document.getElementsByName('modelo[]');
var numeroserie = document.getElementsByName('numeroserie[]');
var material = document.getElementsByName('material[]');

for (var x = 0; x < dimension.length; x++) 
{
var Valdimension = dimension[x];
var Valaprobacion = aprobacion[x];
var Valmodelo = modelo[x];
var Valnumeroserie = numeroserie[x];
var Valmaterial = material[x];
Detalle(data,Valdimension.value,Valaprobacion.value,Valmodelo.value,Valnumeroserie.value,Valmaterial.value);
}
SelEstacion(idEstacion)  
sizeWindow()     
$('#Modal').modal('hide');  
alertify.success('Registro agregado exitosamente.') 
}
});
}

  function Detalle(idSenalamiento,Valdimension,Valaprobacion,Valmodelo,Valnumeroserie,Valmaterial){

    var parametros = {
    "idSenalamiento" : idSenalamiento,
    "Valdimension" : Valdimension,
    "Valaprobacion" : Valaprobacion,
    "Valmodelo" : Valmodelo,
    "Valnumeroserie" : Valnumeroserie,
    "Valmaterial" : Valmaterial,
    "dato" : 1
    };

    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/agregar-senalamientos-especificaciones.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {
      sizeWindow()
    }
    });
    }

  function Eliminar(idEstacion,id){

    var parametros = {
    "id" : id,
    "dato" : 1
    };


alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/eliminar-senalamientos-dispensario.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    SelEstacion(idEstacion)  
    sizeWindow()  
    alertify.success('Registro eliminado exitosamente')  
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

    }

    function ModalEditar(idEstacion,id){
    $('#Modal').modal('show');  
    $('#ContenidoModal').load('../public/admin/vistas/modal-editar-senalamientos-dispensario.php?idEstacion=' + idEstacion + '&idSenalamiento=' + id);
    }
 
       function AgregarEspecificacion(idEstacion,idSenalamiento){

    var parametros = {
    "idSenalamiento" : idSenalamiento,
    "Valdimension" : "",
    "Valaprobacion" : "",
    "Valmodelo" : "",
    "Valnumeroserie" : "",
    "Valmaterial" : "",
    "dato" : 1
    }; 


    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/agregar-senalamientos-especificaciones.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    $('#ContenidoModal').load('../public/admin/vistas/modal-editar-senalamientos-dispensario.php?idEstacion=' + idEstacion + '&idSenalamiento=' + idSenalamiento);  

    }

    }
    });

   }

  function EliminarEspecificaciones(idEstacion,idSenalamiento,id){

    var parametros = {
    "id" : id,
    "dato" : 2
    }; 

    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/eliminar-senalamientos-dispensario.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
   SelEstacion(idEstacion) 
   sizeWindow()
     $('#ContenidoModal').load('../public/admin/vistas/modal-editar-senalamientos-dispensario.php?idEstacion=' + idEstacion + '&idSenalamiento=' + idSenalamiento);       
    }

    }
    });

   }

    function EditarEspecificaciones(e,idEstacion,idSenalamiento,id,dato){
   var contenido = e.value;

     var parametros = {
    "id" : id,
    "dato" : dato,
    "contenido" : contenido
    }; 

    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/agregar-senalamientos-especificaciones.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
      sizeWindow()
    SelEstacion(idEstacion)     
    }

    }
    });
   }

     function Editar(idEstacion,idSenalamiento){

var seleccionArchivos = document.getElementById("seleccionArchivos");
var seleccionArchivos_file = seleccionArchivos.files[0];
var seleccionArchivos_filePath = seleccionArchivos.value;

var Dispensario = $('#Dispensario').val();

var URL = "../public/admin/modelo/agregar-senalamientos-dispensario.php";
var data = new FormData();

data.append('idSenalamiento', idSenalamiento);
data.append('seleccionArchivos_file', seleccionArchivos_file);
data.append('Dispensario', Dispensario);
data.append('dato', 2);

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
SelEstacion(idEstacion)    
sizeWindow()
alertify.success('Registro editado exitosamente')   
$('#Modal').modal('hide');   
}

 
});
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



  <?php
  $sql_listaestacion = "SELECT id, nombre FROM tb_estaciones WHERE numlista <= 8 ORDER BY numlista ASC";
  $result_listaestacion = mysqli_query($con, $sql_listaestacion);
  while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
  $id = $row_listaestacion['id'];
  $estacion = $row_listaestacion['nombre'];


  if($estacion == "Palo Solo"){
    $dispensario = "- Bannett Pacif";

  }else if($estacion == "Interlomas" || $estacion == "San Agustin" || $estacion == "Esmegas" || $estacion == "Xochimilco" || $estacion == "Bosque Real"){
    $dispensario = "- Horizon II";

  }else if($estacion == "Gasomira" || $estacion == "Valle de Guadalupe"){
    $dispensario = "- Hong Yang";

  }else{
    $dispensario = "";
  }




  echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.' '.$dispensario.'
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
  <a class="text-dark" onclick="history.back()">Calcomanias PROFECO</a>
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

    <div class="modal" id="ModalComentario">
    <div class="modal-dialog">
      <div class="modal-content" style="margin-top: 83px;">
      <div id="DivContenidoComentario"></div>
      </div>
    </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>



</body>
</html>