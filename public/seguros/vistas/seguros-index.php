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

  idestacion = sessionStorage.getItem('idestacion');
  SelSeguro(idestacion) 
  } 
      
  }
 
  });  

  function Regresar(){
  sessionStorage.removeItem('idestacion');
  window.history.back();
  }

  function SelSeguro(idEstacion){
  let targets;
  targets = [6];
  
  sizeWindow();  
  sessionStorage.setItem('idestacion', idEstacion);

  $('#ListaSeguros').load('public/seguros/vistas/lista-seguro.php?idEstacion=' + idEstacion, function() {
  $('#tabla_seguros_' + idEstacion).DataTable({
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


  //---------- MODAL - DETALLE POLIZA ----------
  function DetallePolizaInc(idPoliza){
  $('#Modal2').modal('show'); 
  $('#DivModal2').load('public/seguros/vistas/modal-detalle-incidencia-poliza.php?idPoliza=' + idPoliza);   
  }
 

  //---------- MODAL - AGREGAR INCIDENCIA POLIZA ----------
  function ModalAgregarIncidente(idEstacion){
  $('#ModalIncidenciasPoliza').modal('show'); 
  $('#ContenidoModal').load('public/seguros/vistas/modal-incidencia-seguro.php?idEstacion=' + idEstacion); 
  }
 
  //---------- AGREGAR INCIDENCIA (SERVER) ----------
  function GuardarIncidenciaP(idEstacion){

  var FechaP = $('#FechaP').val();
  var HoraP = $('#HoraP').val();
  var AsuntoP = $('#AsuntoP').val();
  var ObservacionesP = $('#ObservacionesP').val();
  var SolucionP = $('#SolucionP').val();

  var ArchivoInc = $('#EvidenciaP').val();

  var data = new FormData();
  var url = 'public/seguros/modelo/agregar-incidencia-poliza.php';

  Archivo = document.getElementById("EvidenciaP");
  Archivo_file = Archivo.files[0];
  Archivo_filePath = Archivo.value;

  if(FechaP != ""){
  $('#FechaP').css('border','');

  if(HoraP != ""){
  $('#HoraP').css('border','');

  if(AsuntoP != ""){
  $('#AsuntoP').css('border','');

  if(ObservacionesP != ""){
  $('#ObservacionesP').css('border','');

  if(SolucionP != ""){
  $('#SolucionP').css('border','');

  if(ArchivoInc != ""){
  $('#EvidenciaP').css('border','');

   data.append('idEstacion', idEstacion);

   data.append('FechaP', FechaP);
   data.append('HoraP', HoraP);
   data.append('AsuntoP', AsuntoP);
   data.append('ObservacionesP', ObservacionesP);
   data.append('SolucionP', SolucionP);
   data.append('Evidencia_file', Archivo_file);
 
   $(".LoaderPage").show();
 
    $.ajax({
    url: url,
    type: 'POST', 
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){
 
     if(data == 1){
      $(".LoaderPage").hide();
  	  $('#ModalIncidenciasPoliza').modal('hide'); 
  	  SelSeguro(idEstacion)
      alertify.success('Incidencia agregada exitosamente.');
     }else{

      $(".LoaderPage").hide();
      alertify.error('Error al agregar incidencia'); 
     }
     
    });  

  }else{
  $('#EvidenciaP').css('border','2px solid #A52525'); 
  }

  }else{
  $('#SolucionP').css('border','2px solid #A52525'); 
  }

  }else{
  $('#ObservacionesP').css('border','2px solid #A52525'); 
  }

  }else{
  $('#AsuntoP').css('border','2px solid #A52525'); 
  }

  }else{
  $('#HoraP').css('border','2px solid #A52525'); 
  }


  }else{
  $('#FechaP').css('border','2px solid #A52525'); 
  }


  }


  //---------- MODAL - EDITAR INCIDENCIA POLIZA ----------
  function ModalEditarIncP(idPolizaInc){
  $('#ModalIncidenciasPoliza').modal('show'); 
  $('#ContenidoModal').load('public/seguros/vistas/modal-editar-incidencia-poliza.php?idPolizaInc=' + idPolizaInc);   
  }


  //---------- MODAL - AGREGAR POLIZA ----------
  function ModalPoliza(idEstacion){
  $('#ModalIncidenciasPoliza').modal('show'); 
  $('#ContenidoModal').load('public/seguros/vistas/modal-poliza-seguro.php?idEstacion=' + idEstacion); 
  }

  //---------- MODAL EDITAR POLIZA ----------
  function ModalEditarPoliza(idPoliza){
  $('#ContenidoModal').load('public/seguros/vistas/modal-editar-poliza-seguro.php?idPoliza=' + idPoliza); 
  }

  //---------- MODAL POLIZA (REGRESO) ----------
  function RegresarPoliza(idEstacion){
  $('#ContenidoModal').load('public/seguros/vistas/modal-poliza-seguro.php?idEstacion=' + idEstacion); 
  }


  //---------- EDITAR POLIZA INCIDENCIA (SERVER) ----------
  function EditarIncidenciaP(idPolizaInc,idEstacion){

  var FechaP = $('#FechaP').val();
  var HoraP = $('#HoraP').val();
  var AsuntoP = $('#AsuntoP').val();
  var ObservacionesP = $('#ObservacionesP').val();
  var SolucionP = $('#SolucionP').val();

  var data = new FormData();
  var url = 'public/seguros/modelo/editar-incidencia-poliza.php';

  Archivo = document.getElementById("EvidenciaP");
  Archivo_file = Archivo.files[0];
  Archivo_filePath = Archivo.value;

  if(FechaP != ""){
  $('#FechaP').css('border','');

  if(HoraP != ""){
  $('#HoraP').css('border','');

  if(AsuntoP != ""){
  $('#AsuntoP').css('border','');

  if(ObservacionesP != ""){
  $('#ObservacionesP').css('border','');

  if(SolucionP != ""){
  $('#SolucionP').css('border','');


   data.append('idPolizaInc', idPolizaInc);

   data.append('FechaP', FechaP);
   data.append('HoraP', HoraP);
   data.append('AsuntoP', AsuntoP);
   data.append('ObservacionesP', ObservacionesP);
   data.append('SolucionP', SolucionP);
   data.append('Evidencia_file', Archivo_file);
 
   $(".LoaderPage").show();
 
    $.ajax({
    url: url,
    type: 'POST', 
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){
 
     if(data == 1){
      $(".LoaderPage").hide();
  	  $('#ModalIncidenciasPoliza').modal('hide'); 
      alertify.success('Incidencia editada exitosamente.');
      SelSeguro(idEstacion)
      sizeWindow()
     }else{

      $(".LoaderPage").hide();
      alertify.error('Error al editada incidencia'); 
     }
     
    });  


  }else{
  $('#SolucionP').css('border','2px solid #A52525'); 
  }

  }else{
  $('#ObservacionesP').css('border','2px solid #A52525'); 
  }

  }else{
  $('#AsuntoP').css('border','2px solid #A52525'); 
  }

  }else{
  $('#HoraP').css('border','2px solid #A52525'); 
  }


  }else{
  $('#FechaP').css('border','2px solid #A52525'); 
  }


  }

  

  //---------- EDITAR POLIZA (SERVER) ----------
  function EditarPolizaS(idPoliza,idEstacion){
	
  var EmisionP = $('#EmisionP').val();
  var VencimientoP = $('#VencimientoP').val();
  var PolizaSeg = $('#PolizaDoc').val();

  var data = new FormData();
  var url = 'public/seguros/modelo/editar-poliza-seguro.php';

  Archivo = document.getElementById("PolizaDoc");
  Archivo_file = Archivo.files[0];
  Archivo_filePath = Archivo.value;

  if(EmisionP != ""){
  $('#EmisionP').css('border','');

  if(VencimientoP != ""){
  $('#VencimientoP').css('border','');

   data.append('idPoliza', idPoliza);
   data.append('EmisionP', EmisionP);
   data.append('VencimientoP', VencimientoP);
   data.append('Poliza_file', Archivo_file);
 
   $(".LoaderPage").show();

    $.ajax({
    url: url,
    type: 'POST', 
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){

     if(data == 1){
      $(".LoaderPage").hide();
      alertify.success('Poliza editada exitosamente.');
      $('#ContenidoModal').load('public/seguros/vistas/modal-poliza-seguro.php?idEstacion=' + idEstacion); 
     }else{

      $(".LoaderPage").hide();
      alertify.error('Error al editar la poliza'); 
     }
     
    });  


  }else{
  $('#VencimientoP').css('border','2px solid #A52525'); 
  }


  }else{
  $('#EmisionP').css('border','2px solid #A52525'); 
  }

	}

  //---------- ELIMINAR POLIZA (SERVER) ----------
  function EliminarPoliza(idPoliza,idEstacion){

  var parametros = {
  "idPoliza" : idPoliza
   };


	alertify.confirm('',
	function(){

    $.ajax({
    data:  parametros,
    url:   'public/seguros/modelo/eliminar-poliza-seguro.php',
    type:  'post',
    beforeSend: function() {
    }, 
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    alertify.success('Poliza eliminada exitosamente.')
    $('#ContenidoModal').load('public/seguros/vistas/modal-poliza-seguro.php?idEstacion=' + idEstacion); 
    }else{
     alertify.error('Error al eliminar la poliza');  
    }

    }
    });

	},
	function(){

	}).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la poliza de seguro seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

  }



  //---------- AGREGAR POLIZA (SERVER) ----------
  function GuardarPolizaS(idEstacion){  	
 
  var EmisionP = $('#EmisionP').val();
  var VencimientoP = $('#VencimientoP').val();
  var PolizaSeg = $('#PolizaDoc').val();

  var data = new FormData();
  var url = 'public/seguros/modelo/agregar-poliza-seguro.php';

  Archivo = document.getElementById("PolizaDoc");
  Archivo_file = Archivo.files[0];
  Archivo_filePath = Archivo.value;

  if(EmisionP != ""){
  $('#EmisionP').css('border','');

  if(VencimientoP != ""){
  $('#VencimientoP').css('border','');

  if(PolizaSeg != ""){
  $('#PolizaDoc').css('border','');
 


   data.append('idEstacion', idEstacion);
   data.append('EmisionP', EmisionP);
   data.append('VencimientoP', VencimientoP);
   data.append('Poliza_file', Archivo_file);
 
   $(".LoaderPage").show();

    $.ajax({
    url: url,
    type: 'POST', 
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){

     if(data == 1){
      $(".LoaderPage").hide();
      alertify.success('Poliza agregada exitosamente.');
      $('#ContenidoModal').load('public/seguros/vistas/modal-poliza-seguro.php?idEstacion=' + idEstacion); 
     }else{

      $(".LoaderPage").hide();
      alertify.error('Error al agregar la poliza'); 
     }
     
    });  


  }else{
  $('#PolizaDoc').css('border','2px solid #A52525'); 
  }


  }else{
  $('#VencimientoP').css('border','2px solid #A52525'); 
  }


  }else{
  $('#EmisionP').css('border','2px solid #A52525'); 
  }


  }


  //---------- VENCIMIENTO ANUAL ----------
  function VencimientoPoliza(){
	var EmisionP = $('#EmisionP').val();

	var parametros = {
	'EmisionP' : EmisionP
	};

  $.ajax({
   data:  parametros,
   url:   'public/seguros/modelo/fecha-vencimiento.php',
   type:  'post',
   beforeSend: function() {
   },
   complete: function(){
   },
   success:  function (response) {

   $('#fechavencimiento').html(response)   

   }
   });
}



  //---------- ELIMINAR POLIZA (SERVER) ----------
  function EliminarInc(idPolizaInc,idEstacion){

  var parametros = {
  "idPolizaInc" : idPolizaInc
   };


	alertify.confirm('',
	function(){

    $.ajax({
    data:  parametros,
    url:   'public/seguros/modelo/eliminar-poliza-incidencia.php',
    type:  'post',
    beforeSend: function() {
    }, 
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    alertify.success('Registro eliminado exitosamente.')
    SelSeguro(idEstacion)
    sizeWindow()
    }else{
     alertify.error('Error al eliminar el registro');  
    }

    }
    });

	},
	function(){

	}).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el registro seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

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

  $sql_listaestacion = "SELECT id, numlista, localidad FROM op_rh_localidades WHERE (numlista BETWEEN 0 AND 9) OR numlista = 10 OR (numlista BETWEEN 22 AND 23) ORDER BY numlista ASC";
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
 $estacion == "Departamento Sistemas" ||
  $estacion == "Quitarga"){
 $icon = "fa-solid fa-briefcase"; 


}else if($estacion == "Comercializadora"){
 $icon = "fa-solid fa-truck-moving";

}else{
 $icon = "fa-solid fa-gas-pump";    
}  


if ($session_nompuesto == "Comercializadora") {

  if($Session_IDUsuarioBD == 28){


  if($id == 6 || $id == 7){
  echo '  
  <li>
    <a class="pointer" onclick="SelSeguro('.$id.')">
    <i class="'.$icon.'" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$estacion.' 
    </a>
  </li>';
  }


}else{


  if($id <> 8){
    echo '  
    <li>
      <a class="pointer" onclick="SelSeguro('.$id.')">
      <i class="'.$icon.'" aria-hidden="true" style="padding-right: 10px;"></i>
      '.$estacion.' 
      </a>
    </li>';
  }

}

}else{

  if($id <> 8){
    echo '  
    <li>
      <a class="pointer" onclick="SelSeguro('.$id.')">
      <i class="'.$icon.'" aria-hidden="true" style="padding-right: 10px;"></i>
      '.$estacion.' 
      </a>
    </li>';
  }
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
  <a class="text-dark" onclick="history.back()">Seguro</a>
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
  
  <div class="col-12" id="ListaSeguros"></div> 
 
  </div>
  </div> 

  </div>
  </div>

  <!---------- MODAL ----------> 
  <div class="modal fade" id="ModalIncidenciasPoliza" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="ContenidoModal">
  </div>
  </div>
  </div>

  <!---------- MODAL COVID (RIGHT)---------->  
  <div class="modal right fade" id="Modal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
  <div class="modal-content" id="DivModal2"></div>
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