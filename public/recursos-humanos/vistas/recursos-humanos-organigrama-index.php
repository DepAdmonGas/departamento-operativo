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
  <!---------- LIBRERIAS DEL DATATABLE ---------->
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  sizeWindow(); 

  if(sessionStorage){
  if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {

  idEstacion = sessionStorage.getItem('idestacion');


  let targetsOrganigrama = [3];
  $('#ContenidoOrganigrama').load(
  'app/vistas/contenido/2-recursos-humanos/organigrama/contenido-organigrama.php?idEstacion=' + idEstacion + "&idOrganigrama=0", 
  function() {
    // Destruir DataTable si ya está inicializado
    if ($.fn.DataTable.isDataTable('#tabla_organigrama')) {
      $('#tabla_organigrama').DataTable().destroy();
    }

    // Inicializar DataTable nuevamente
    $('#tabla_organigrama').DataTable({
      "stateSave": true,
      "language": {
        "url": "<?=RUTA_JS2?>/es-ES.json"
      },
      "order": [[0, "desc"]],
      "lengthMenu": [25, 50, 75, 100],
      "columnDefs": [
        { "orderable": false, "targets": targetsOrganigrama },
        { "searchable": false, "targets": targetsOrganigrama }
      ]
    });

    // Cargar la tabla de plantilla dentro del mismo callback
    $('#tabla_plantilla').load(
      'app/vistas/contenido/2-recursos-humanos/organigrama/lista-plantilla-estacion.php?idEstacion=' + idEstacion, 
      function() {
        let dato = "";
        buscarNombres(dato, idEstacion);
      }
    );
  }
);



  }       
  } 
   
  });
  

  function Regresar(){
  sessionStorage.removeItem('idestacion');
  window.history.back();
  }


  //---------- CONTENIDO ORGANIGRAMA ---------
  function SelEstacion(idEstacion, idOrganigrama) {
  if (idOrganigrama > 0) {
  // Lógica específica para idOrganigrama mayor que 0
  } else {
  sizeWindow(); 
  }

  sessionStorage.setItem('idestacion', idEstacion);
  
  $('#ContenidoOrganigrama').load('app/vistas/contenido/2-recursos-humanos/organigrama/contenido-organigrama.php?idEstacion=' + idEstacion + "&idOrganigrama=" + idOrganigrama, function() {
  // Una vez que el contenido de #ContenidoOrganigrama se haya cargado
  $('#tabla_plantilla').load('app/vistas/contenido/2-recursos-humanos/organigrama/lista-plantilla-estacion.php?idEstacion=' + idEstacion, function() {
  // Una vez que #tabla_plantilla se haya cargado completamente
  // Aquí es más seguro llamar a buscarNombres
  let dato = "";
  buscarNombres(dato, idEstacion);
  });
  });
  }


  //---------- CONTENIDO SELECT USUARIOS (DINAMICO) ---------
  function buscarNombres(e, idEstacion) {
  
  let dato = e.value;

  let parametros = {
  "dato" : dato,
  "idEstacion" : idEstacion
  };

  $.ajax({
  data:  parametros,
  url:   'app/vistas/contenido/2-recursos-humanos/organigrama/select-plantilla-usuarios.php',
  type: 'GET',
  beforeSend: function() {

  },
  complete: function(){

  },
  success:  function (response) {

  $('#listaNombres_' + idEstacion).html(response);

  }
  });

  } 

  //---------- VALIDAR PLANTILLA DEL ORGANIGRAMA ---------
  function datosPlantilla(e, idPlantilla, idEstacion, consulta) {
    
  // Si consulta es 2, solo validar y mostrar un mensaje
  if (consulta == 2) {
  var empleado = $('#NombresCompleto_' + idPlantilla).val(); // Obtener el nombre completo seleccionado
  var empleadoId = null; // Variable para almacenar el id del empleado
  // Buscar el id del empleado correspondiente al nombre seleccionado en el datalist específico
  $('#listaNombres_' + idEstacion + ' option').each(function() {
  if ($(this).val() === empleado) {
  empleadoId = $(this).data('id');
  return false; // Salir del bucle si se encuentra el empleado
  }
  });

  if (empleadoId) {
  actualizarDatos(idPlantilla, empleadoId, consulta);
    
  }else{
  actualizarDatos(idPlantilla, empleado, 3);

  }
  
    
  }else{
  var valor = e.value;

  if(valor == ""){
  alertify.error('Debes de ingresar la descripcion del puesto');

  }else{
  actualizarDatos(idPlantilla, valor, consulta);

  }

  }

  }

  //---------- VALIDAR PLANTILLA DEL ORGANIGRAMA ---------
  function actualizarDatos(idPlantilla, valor, consulta){
  
  var parametros = {
  "idPlantilla" : idPlantilla,
  "valor" : valor,
  "consulta" : consulta
  };
        
  $.ajax({
  data:  parametros,
  url:  'public/recursos-humanos/modelo/editar-fila-plantilla.php',
  type: 'post',   
  beforeSend: function () {
      // Puedes añadir algún indicador de carga aquí
  },
  complete: function () {

  },
  success: function (response) {

  if(response == 1){

  if(consulta == 2 || consulta == 3){
  location.reload();

  }else{
  alertify.success('Registro actualizado exitosamente.');

  }

  }else{
  alertify.error('Error al actualizar el registro.');

  }

  }
  });
  
  }

  function Mas(idEstacion){
  $('#Modal').modal('show');  
  //$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-organigrama-estacion.php?idEstacion=' + idEstacion);   
  $('#ContenidoModal').load('app/vistas/contenido/2-recursos-humanos/organigrama/modal-agregar-organigrama.php?idEstacion=' + idEstacion);
  }

  function Guardar(idEstacion) {

  var seleccionArchivos = document.getElementById("seleccionArchivos");
  var seleccionArchivos_file = seleccionArchivos.files[0];
  var seleccionArchivos_filePath = seleccionArchivos.value;
  var Observaciones = $('#Observaciones').val();
  var input = $("#seleccionArchivos").val()
  var extencion = input.split(".").pop().toLowerCase();

  //var URL = "public/recursos-humanos/modelo/agregar-organigrama-estacion.php";
  var URL = "app/controlador/2-recursos-humanos/controladorOrganigrama.php";
  var data = new FormData();

  data.append('idEstacion', idEstacion);
  data.append('seleccionArchivos_file', seleccionArchivos_file);
  data.append('Observaciones', Observaciones);
  data.append('accion', 'guardar-organigrama');

  if (input != "") {
  $("#seleccionArchivos").css('border', '');

  if (extencion == "jpg" || extencion == "png" || extencion == "jpeg" || extencion == "JPG" || extencion == "PNG" || extencion == "JPEG") {
  $("#Mensaje").html('');

  $.ajax({
  url: URL,
  type: 'POST',
  contentType: false,
  data: data,
  processData: false,
  cache: false
  }).done(function (data) {

  if (data == 1) {
  SelEstacion(idEstacion,0)
  $('#Modal').modal('hide');  
  alertify.success('Organigrama agregado exitosamente.');
  sizeWindow();

  } else {
  alertify.error('Error al agregar organigrama.');
  }
  });


  } else {
  alertify.error('La imagen debe ser .JPG o .PNG');
  }

  } else {
  $("#seleccionArchivos").css('border', '2px solid #A52525');
  }
  }


  function Eliminar(idEstacion,idOrganigrama){
  sizeWindow();
    var parametros = {
    "idOrganigrama" : idOrganigrama
    };

 alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/eliminar-organigrama-estacion.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    SelEstacion(idEstacion,0)
    sizeWindow();
    alertify.success('Organigrama eliminado exitosamente.');

    }else{
    alertify.error('Error al eliminar');
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

}

function ModalCP(idPlantilla){
$('#Modal').modal('show');  
$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-contrato-perfil.php?idPlantilla=' + idPlantilla); 
}

function GuardarCP(idPlantilla){
var NomDocumento = $('#NomDocumento').val();

var Archivo = document.getElementById("Archivo");
var seleccionArchivos_file = Archivo.files[0];
var seleccionArchivos_filePath = Archivo.value;

var input = $("#Archivo").val()
var extencion = input.split(".").pop().toLowerCase();

var URL = "public/recursos-humanos/modelo/agregar-organigrama-documentos.php";
var data = new FormData();
 
if(NomDocumento != "" ){
if( extencion == "pdf" || extencion == "PDF" ){

data.append('idPlantilla', idPlantilla);
data.append('seleccionArchivos_file', seleccionArchivos_file);
data.append('NomDocumento', NomDocumento);
 
$.ajax({
url: URL,
type: 'POST',
contentType: false,
data: data,
processData: false,
cache: false
}).done(function(data){

alertify.success('Documentacion actualizada exitosamente.');
$('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-contrato-perfil.php?idPlantilla=' + idPlantilla); 

});

}else{
$("#Respuesta").html('<div class="alert alert-warning text-center" role="alert">Solo se permiten archivos en formato PDF</div>');
}
}else{
$("#NomDocumento").css('border','2px solid #A52525');
}

}

function EliminarCP(idPlantilla, tipo){
var parametros = {
"idPlantilla" : idPlantilla,
"tipo" : tipo
};

 alertify.confirm('',
 function(){

    $.ajax({
    data:  parametros,
    url:   'public/recursos-humanos/modelo/eliminar-organigrama-contrato-perfil.php',
    type:  'post',
    beforeSend: function() {

    },
    complete: function(){
 
    },
    success:  function (response) {

    if (response == 1) {
    alertify.success('Documento eliminado exitosamente.');
    $('#ContenidoModal').load('public/recursos-humanos/vistas/modal-agregar-contrato-perfil.php?idPlantilla=' + idPlantilla); 

    }else{
    alertify.error('Error al eliminar');
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
}


  function datosRazonSocial(e, id, num){
  var valor = e.value;
  
  var parametros = {
  "valor": valor,
  "id": id,
  "num": num
  };


  $.ajax({
  data: parametros,
  url:   'public/recursos-humanos/modelo/editar-organigrama-info-estacion.php',
  type: 'post',
  beforeSend: function () {
         
  },
  complete: function () {

  },
  success: function (response) {

  if (response == 1) {
  alertify.success('Información actualizada exitosamente.')

  } else {
  alertify.error('Error al editar la información.')

  }

  }
  });

  }

 

  
  function MasPlantilla(idEstacion,idOrganigrama) {
  var parametros = {
  "idEstacion" : idEstacion
  };

  $.ajax({
  data:  parametros,
    url:  'public/recursos-humanos/modelo/agregar-fila-plantilla.php',
    type: 'post',
    beforeSend: function () {
      // Puedes añadir algún indicador de carga aquí
    },
    complete: function () {
    SelEstacion(idEstacion, idOrganigrama)      
    },
    success: function (response) {

    if(response == 1){
    alertify.success('Fila agregada al final de la tabla.');

    }else{
    alertify.error('Error al agregar la fila.');

    }

    }
  });

  }


  function EliminarPP(idPlantilla){

  var parametros = {
  "idPlantilla" : idPlantilla,
  };

 alertify.confirm('',
 function(){
 
  $.ajax({
  data:  parametros,
  url:   'public/recursos-humanos/modelo/eliminar-personal-plantilla.php',
  type:  'post',
  beforeSend: function() {

  },
  complete: function(){
 
  },
  success:  function (response) {

  if (response == 1) {
  location.reload();


  }else{
  alertify.error('Error al eliminar');
  }

  }
  });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el personal seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
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



  <?php

  $FInicio = date("Y").'-'.date("m").'-01';
  $FTermino = date("Y-m-t", strtotime($FInicio));

  $sql_listaestacion = "SELECT id, numlista, localidad FROM op_rh_localidades WHERE numlista <= 8  OR numlista = 10 ORDER BY numlista ASC";
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
    <a class="pointer" onclick="SelEstacion('.$id.',0)">
    <i class="'.$icon.'" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.'
    </a>
  </li>';
  }

  ?> 
  <li>
    <a class="pointer" onclick="SelEstacion(11,0)">
    <i class="fa-solid fa-briefcase" aria-hidden="true" style="padding-right: 10px;"></i>
    Dirección de operaciones
    </a>
  </li>
    <li>
    <a class="pointer" onclick="SelEstacion(20,0)">
    <i class="fa-solid fa-briefcase" aria-hidden="true" style="padding-right: 10px;"></i>
    Departamento de almacén
    </a>
  </li>
    <li>
    <a class="pointer" onclick="SelEstacion(21,0)">
    <i class="fa-solid fa-briefcase" aria-hidden="true" style="padding-right: 10px;"></i>
    Departamento de importación
    </a>
    <li>
    <a class="pointer" onclick="SelEstacion(15,0)">
    <i class="fa-solid fa-briefcase" aria-hidden="true" style="padding-right: 10px;"></i>
    Departamento Mantenimiento
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
  <a class="text-dark" onclick="history.back()">Recursos humanos (Organigrama)</a>
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
  <div id="ContenidoOrganigrama"></div>
  </div> 

  </div>
  </div> 
  </div>

  </div>

  <!---------- MODAL ----------> 
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