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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  
  <script src="<?=RUTA_JS?>size-window.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  
 
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
    sizeWindow(); 

    if(sessionStorage){
    if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion') && sessionStorage.getItem('categoria') !== undefined && sessionStorage.getItem('categoria')) {

    idestacion = sessionStorage.getItem('idestacion');
    categoria = sessionStorage.getItem('categoria');

    if(categoria == 1){
    $('#ListaTerminales').load('../public/admin/vistas/lista-refacciones.php?idEstacion=' + idestacion);
    }else if(categoria == 3){
    $('#ListaTerminales').load('../public/admin/vistas/lista-reporte-transaccion.php?idEstacion=' + idestacion);
    } 
                  
    }      
    }    
   
  }); 

  function Regresar(){
  window.history.back();
  }

  function SelEstacion(id){
  sizeWindow();  
  sessionStorage.setItem('idestacion', id);
  sessionStorage.setItem('categoria', 1);
  $('#ListaTerminales').load('../public/admin/vistas/lista-refacciones.php?idEstacion=' + id);
  }

  function SelEstacionReturn(id){
  sessionStorage.setItem('idestacion', id);
  sessionStorage.setItem('categoria', 1);
  $('#ListaTerminales').load('../public/admin/vistas/lista-refacciones.php?idEstacion=' + id);
  }
    
  function Agregar(idEstacion){
  $('#Modal').modal('show');  
  $('#ContenidoModal').load('../public/admin/vistas/modal-agregar-refacciones.php?idEstacion=' + idEstacion);
  }    
  
function Guardar(idEstacion){
var seleccionArchivos = document.getElementById("seleccionArchivos");
var seleccionArchivos_file = seleccionArchivos.files[0];
var seleccionArchivos_filePath = seleccionArchivos.value;

var DescripcionRefaccion = $('#DescripcionRefaccion').val();
var NombreRefaccion = $('#NombreRefaccion').val();
var Unidad = $('#Unidad').val();
var EstadoR = $('#EstadoR').val();
var Costo = $('#Costo').val();

var Modelo = $('#Modelo').val();
var Marca = $('#Marca').val();
var Proveedor = $('#Proveedor').val();
var Contacto = $('#Contacto').val();
var Area = $('#Area').val();

var URL = "../public/admin/modelo/agregar-refaccion.php";
var data = new FormData();
 
data.append('idEstacion', idEstacion);
data.append('DescripcionRefaccion', DescripcionRefaccion);
data.append('NombreRefaccion', NombreRefaccion);
data.append('Unidad', Unidad);
data.append('EstadoR', EstadoR);
data.append('Costo', Costo);
data.append('seleccionArchivos_file', seleccionArchivos_file);
data.append('Modelo', Modelo);
data.append('Marca', Marca);
data.append('Proveedor', Proveedor);
data.append('Contacto', Contacto);
data.append('Area', Area);
 
$.ajax({
url: URL,
type: 'POST',
contentType: false,
data: data,
processData: false,
cache: false
}).done(function(data){
SelEstacion(idEstacion)
alertify.success('Refaccion agregada exitosamente.')      
$('#Modal').modal('hide');  
sizeWindow()
});

} 

    function Eliminar(idEstacion,id){

    var parametros = {
    "id" : id
    };

 
alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/eliminar-refaccion.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

 
    if (response == 1) {
    SelEstacion(idEstacion);   
    sizeWindow();  
    alertify.success('Refaccion eliminada exitosamente')
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

    }

    function ModalDetalle(idEstacion,id){      
    $('#Modal').modal('show');  
    $('#ContenidoModal').load('../public/admin/vistas/modal-detalle-refaccion.php?idEstacion=' + idEstacion + '&idRefaccion=' + id);
    } 
  
    function ModalMas(idEstacion,id){
    $('#Modal').modal('show');  
    $('#ContenidoModal').load('../public/admin/vistas/modal-unidades-refaccion.php?idEstacion=' + idEstacion + '&idRefaccion=' + id);
    } 

    function AgregarPiezas(idEstacion,id){

    var Unidades = $('#Unidades').val(); 

    var parametros = {
    "id" : id,
    "Unidades" : Unidades
    };

    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/agregar-unidad-refaccion.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

 
    if (response == 1) {
    ModalMas(idEstacion,id);
    SelEstacion(idEstacion);  
    sizeWindow();    
    }

    }
    }); 

    }  

    function Mantenimiento(id){
    $('#ListaTerminales').load('../public/admin/vistas/lista-reporte-refacciones.php?idEstacion=' + id);
    }
  
    function AgregarReporte(idEstacion){

    var parametros = {
    "idEstacion" : idEstacion
    };

    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/crear-reporte-refacciones.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    }, 
    success:  function (response) {
    
    if (response == 0) {
     alertify.error('Error al crear el reporte');   
    }else{
    Mantenimiento(idEstacion)   
    $('#Modal').modal('show');  
    $('#ContenidoModal').load('../public/admin/vistas/modal-reporte-refacciones.php?idEstacion=' + idEstacion + '&idReporte=' + response); 
    }

    } 
    });
 
    }

    function AgregarRR(idEstacion, idReporte){

    var Refaccion = $('#Refaccion').val();
    var Unidad = $('#Unidad').val();

    if (Refaccion != "") {
    $('#Refaccion').css('border','');
    if (Unidad != "") {
    $('#Unidad').css('border','');

    var parametros = {
    "idReporte" : idReporte,
    "Refaccion" : Refaccion,
    "Unidad" : Unidad
    };

    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/agregar-refaccion-reporte.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {    
    $('#ContenidoModal').load('../public/admin/vistas/modal-reporte-refacciones.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);   

    }else if(response == 0){
      alertify.error('Error al agregar la refaccion');
    }else if(response == 2){
      alertify.warning('No cuenta con suficientes unidades');
    }
 
    }
    });

    }else{
    $('#Hora').css('border','2px solid #A52525');
    }
    }else{
    $('#Refaccion').css('border','2px solid #A52525');
    }

    }

    function GuardarReporte(idEstacion,idReporte){

    var Fecha = $('#Fecha').val();
    var Hora = $('#Hora').val();
    var Dispensario = $('#Dispensario').val();
    var Motivo = $('#Motivo').val();

    var seleccionArchivos = document.getElementById("seleccionArchivos");
    var seleccionArchivos_file = seleccionArchivos.files[0];
    var seleccionArchivos_filePath = seleccionArchivos.value;

    var URL = "../public/admin/modelo/finalizar-refaccion-reporte.php";
    var data = new FormData();

    if (Fecha != "") {
    $('#Fecha').css('border','');
    if (Hora != "") {
    $('#Hora').css('border','');

    var parametros = {
    "idReporte" : idReporte,
    "Fecha" : Fecha,
    "Hora" : Hora,
    "Dispensario" : Dispensario,
    "Motivo" : Motivo
    };

    data.append('idReporte', idReporte);
    data.append('Fecha', Fecha);
    data.append('Hora', Hora);
    data.append('Dispensario', Dispensario);
    data.append('Motivo', Motivo);
    data.append('seleccionArchivos_file', seleccionArchivos_file);

    $.ajax({
    url: URL,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(response){

 
    if (response == 1) {
    $('#ContenidoModal').load('../public/admin/vistas/modal-reporte-refacciones.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);  
    Mantenimiento(idEstacion)     
    }else if(response == 0){
      alertify.error('Error al crear el reporte');
    }else if(response == 2){
      alertify.warning('No cuenta con suficientes unidades');
    }

  
    })
   

    }else{
    $('#Hora').css('border','2px solid #A52525');
    }
    }else{
    $('#Fecha').css('border','2px solid #A52525');
    }

    }

    function EditarReporte(idEstacion,idReporte){

    $('#Modal').modal('show');  
    $('#ContenidoModal').load('../public/admin/vistas/modal-reporte-refacciones.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte); 

    }
  
    function EliminarRefaccionReporte(idEstacion,idReporte,id,idRefaccion){

    var parametros = {
    "id" : id,
    "idRefaccion" : idRefaccion
    };

   alertify.confirm('',
   function(){

      $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/eliminar-refaccion-reporte.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

 
    if (response == 1) {
    $('#ContenidoModal').load('../public/admin/vistas/modal-reporte-refacciones.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

    }

    function EliminarReporte(idEstacion,id){

    var parametros = {
    "id" : id
    };


alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/eliminar-reporte-refaccion.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    Mantenimiento(idEstacion);  
    sizeWindow();    
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

    }

    function ModalDetalleReporte(idEstacion,id,idRefaccion){      
    $('#Modal').modal('show');  
    $('#ContenidoModal').load('../public/admin/vistas/modal-detalle-reporte-refaccion.php?idEstacion=' + idEstacion + '&idReporte=' + id + '&idRefaccion=' + idRefaccion);
    }
 

        function EliminarUnidad(idEstacion,id, idRefaccion){

    var parametros = {
    "id" : id,
    "idRefaccion" : idRefaccion
    };


  alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/eliminar-unidad-refaccion.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

 
    if (response == 1) {
    ModalMas(idEstacion,idRefaccion);
    SelEstacion(idEstacion) 
    sizeWindow();
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();


    }

     function ModalEditar(idEstacion,id){
    $('#Modal').modal('show');  
    $('#ContenidoModal').load('../public/admin/vistas/modal-editar-refacciones.php?idEstacion=' + idEstacion + '&idRefaccion=' + id);
    }


    function EditarRefaccion(idEstacion,id){

var seleccionArchivos = document.getElementById("seleccionArchivos");
var seleccionArchivos_file = seleccionArchivos.files[0];
var seleccionArchivos_filePath = seleccionArchivos.value;

Archivo = document.getElementById("Archivo");
Archivo_file = Archivo.files[0];
Archivo_filePath = Archivo.value;


var DescripcionRefaccion = $('#DescripcionRefaccion').val();
var NombreRefaccion = $('#NombreRefaccion').val();
var Unidad = $('#Unidad').val();
var EstadoR = $('#EstadoR').val();
var Costo = $('#Costo').val();

var Modelo = $('#Modelo').val();
var Marca = $('#Marca').val();
var Proveedor = $('#Proveedor').val();
var Contacto = $('#Contacto').val();
var Area = $('#Area').val();

var URL = "../public/admin/modelo/editar-refaccion.php";
var data = new FormData();
  
data.append('idEstacion', idEstacion);
data.append('idRefaccion', id);
data.append('DescripcionRefaccion', DescripcionRefaccion);
data.append('NombreRefaccion', NombreRefaccion);
data.append('Unidad', Unidad);
data.append('EstadoR', EstadoR);
data.append('Costo', Costo);
data.append('seleccionArchivos_file', seleccionArchivos_file);
data.append('Modelo', Modelo);
data.append('Marca', Marca);
data.append('Proveedor', Proveedor);
data.append('Contacto', Contacto);
data.append('Area', Area);
data.append('Archivo_file', Archivo_file);

$.ajax({
url: URL,
type: 'POST',
contentType: false,
data: data,
processData: false,
cache: false
}).done(function(data){
SelEstacion(idEstacion) 
alertify.success('Refaccion editada exitosamente.')      
$('#Modal').modal('hide'); 
sizeWindow(); 
});

}

function BuscarArea(Area, idEstacion){
 
if(Area == 0){
$('#ListaTerminales').load('../public/admin/vistas/lista-refacciones.php?idEstacion=' + idEstacion);
}else{
$('#ListaTerminales').load('../public/admin/vistas/lista-refacciones-reporte.php?idEstacion=' + idEstacion + '&idArea=' + Area); 
}
    
}  

function Buscar(e,idArea,idEstacion){
var Buscar = e.value;

    var parametros = {
    "Buscar" : Buscar,
    "idArea" : idArea,
    "idEstacion" : idEstacion
    };

    $.ajax({
    data:  parametros, 
    url:   '../public/admin/vistas/lista-refacciones-buscar.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {
    $('#BuscarRefacciones').html(response);
    }
    });
 
}
    

     
   
//-----------------------------------------------------------------------

function Transaccion(idEstacion){
sessionStorage.setItem('categoria', 3);
$('#ListaTerminales').load('../public/admin/vistas/lista-reporte-transaccion.php?idEstacion=' + idEstacion);
}
  
function ModalTransaccion(idEstacion){
window.location.href = "refacciones-transaccion/" + idEstacion; 
} 

function FirmarTransaccion(idEstacion,id){
window.location.href = "refacciones-transaccion-firmar/" + id; 
}

function ModalDetalleT(id){ 
$('#Modal').modal('show');  
$('#ContenidoModal').load('../public/admin/vistas/modal-detalle-refaccion-transaccion.php?idReporte=' + id);
} 

function DescargarTransaccion(id){
window.location.href = "refacciones-transaccion-pdf/" + id;
}

function EliminarTransaccion(idEstacion,id,estado){
    var estado;

    if(estado == 1){
        estado = "Editar";
        estadoName = '¿Desea realizar la devolucion a la estacion proveedora?';
        estadoAlert = 'Devolucion realizada exitosamente';
    }else if(estado == 2){
        estado = "Eliminar";
        estadoName = '¿Desea eliminar la información seleccionada?';
        estadoAlert = 'Registro eliminado exitosamente';
    }


    var parametros = {
    "id" : id,
    "estado" : estado
    };
 

  alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/eliminar-refaccion-transaccion.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {
 
      
    if (response == 1) {
    sessionStorage.setItem('categoria', 3);
    $('#ListaTerminales').load('../public/admin/vistas/lista-reporte-transaccion.php?idEstacion=' + idEstacion); 
    alertify.success(estadoAlert) 
    sizeWindow();  
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: estadoName ,labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

} 


function ComentarioTransaccion(idEstacion,idReporte){
$('#Modal').modal('show');  
$('#ContenidoModal').load('../public/admin/vistas/modal-comentarios-refaccion-transaccion.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);  
}
  


function GuardarComentario(idEstacion,idReporte){
    var Comentario = $('#Comentario').val();

    var parametros = {
    "idReporte" : idReporte,
    "Comentario" : Comentario
    };

    if(Comentario != ""){
    $('#Comentario').css('border',''); 

    $.ajax({ 
    data:  parametros,
    url:   '../public/admin/modelo/agregar-comentario-refaccion-transaccion.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    }, 
    success:  function (response) {

    if (response == 1) {
    $('#Comentario').val('');
    Transaccion(idEstacion)     
    sizeWindow();
    $('#ContenidoModal').load('../public/admin/vistas/modal-comentarios-refaccion-transaccion.php?idEstacion=' + idEstacion + '&idReporte=' + idReporte);  
    }else{
     alertify.error('Error al agregar el comentario');  
    }

    }
    });

    }else{
    $('#Comentario').css('border','2px solid #A52525'); 
    }

    }

    function Senalamientos(){window.location.href = "../administracion/senalamientos";}

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

  <ul class="list-unstyled components" >
    
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

$sql_listaestacion = "SELECT id, localidad, numlista FROM op_rh_localidades WHERE numlista <= 8 ORDER BY numlista ASC";
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


  echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.')">
    <i class="'.$icon.'" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
    
    }
?> 

  <li>
    <a class="pointer" onclick="SelEstacion(9)">
    <i class="fa-solid fa-car" aria-hidden="true" style="padding-right: 10px;"></i>
    Autolavado
    </a>
  </li>

    <li>
    <a class="pointer" onclick="SelEstacion(17)">
    <i class="fa-sharp fa-solid fa-shop" aria-hidden="true" style="padding-right: 10px;"></i>
    Almacen
    </a>
  </li>

  <li>
    <a class="pointer" onclick="Senalamientos()">
    <i class="fa-sharp fa-solid fa-shop" aria-hidden="true" style="padding-right: 10px;"></i>
    Señalamientos
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
  <a class="text-dark" onclick="history.back()">Inventario Refacciones</a>
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
  <a class="dropdown-item" href="../perfil">
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



  <div class="contendAG">
  <div class="row">  
  
  <div class="col-12">
  <div id="ListaTerminales" class="cardAG"></div>
  </div> 

  </div>
  </div> 


  </div>

</div>


<div class="modal" id="Modal">
  <div class="modal-dialog modal-lg" style="margin-top: 83px;">
    <div class="modal-content">
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

