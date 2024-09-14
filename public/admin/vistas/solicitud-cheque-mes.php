<?php
require('app/help.php');

function ToSolicitud($idEstacion,$depu,$year,$mes,$con){

if($idEstacion == 8){
$busqueda = 'depto = '.$depu;
}else{
$busqueda = 'id_estacion = '.$idEstacion; 
} 

$sql_lista = "SELECT id FROM op_solicitud_cheque WHERE id_year = '".$year."' AND id_mes = '".$mes."' AND status = 0 AND $busqueda ";
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
 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" ></script>
  <link rel="stylesheet" href="<?=RUTA_CSS ?>selectize.css">

  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
  <script type="text/javascript" src="<?=RUTA_JS ?>alertify.js"></script> 

  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  $('[data-toggle="tooltip"]').tooltip();
  sizeWindow();
  
  if(sessionStorage){
    if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {

      idestacion = sessionStorage.getItem('idestacion');
      depu = sessionStorage.getItem('depu');
      year = sessionStorage.getItem('year');
      mes = sessionStorage.getItem('mes');

      SelEstacion(idestacion,depu,year,mes);
    } 
      
    }  

    });   

  function Regresar(){
  window.history.back();
  sessionStorage.removeItem('idestacion');
  sessionStorage.removeItem('depu');
  sessionStorage.removeItem('year');
  sessionStorage.removeItem('mes');
  }
 
  function SelEstacion(idestacion,depu,year,mes){
    sizeWindow();
    sessionStorage.setItem('idestacion', idestacion);
    sessionStorage.setItem('depu', depu);
    sessionStorage.setItem('year', year);
    sessionStorage.setItem('mes', mes);
  
    let targets = []; // Variable para almacenar los targets dinámicos
    targets = [8, 9, 10]; // Asigna los targets para el caso de "Gestoria"

  
    $('#ListaEmbarques').load('../../../public/admin/vistas/lista-solicitud-cheques-mes.php?idEstacion=' + idestacion + '&depu=' + depu + '&year=' + year + '&mes=' + mes, function() {
    // Una vez que se carguen los datos en la tabla, inicializa DataTables
    $('#tabla_solicitud_cheque_' + idestacion).DataTable({
      "language": { // Corrección de "lenguage" a "language"
      "url": "<?=RUTA_JS2?>/es-ES.json" // Corrección de la ruta del archivo de idioma
      },
      "order": [[0, "desc"]],  // Ordenar por la tercera columna de forma descendente
      "lengthMenu": [15,30,50,100], // Número de registros que se mostrarán
      "columnDefs": [
      { "orderable": false, "targets": targets }, // Deshabilitar ordenación en las columnas 1, 2 y 3 (comenzando desde 0)
      { "searchable": false, "targets": targets } // Deshabilitar filtrado en las columnas 1, 2 y 3 (comenzando desde 0)
      ]
    });
    });
    }



  function Mas(idEstacion,depu,year,mes){
  window.location.href = "../../solicitud-cheque-nuevo/" + year + "/" + mes + "/" + idEstacion + "/" + depu; 
  }

 
 function ModalDetalle(id){
  $('#Modal').modal('show');  
  $('#DivContenido').load('../../../app/vistas/personal-general/1-corporativo/solicitud-cheque/modal-detalle-solicitud-cheque.php?idReporte=' + id);
  }  

 function Editar(year,mes,idEstacion,idReporte){
 window.location.href = "../../solicitud-cheque-editar/" + year + "/" + mes + "/" + idEstacion + "/" + idReporte;  
 }

 function Firmar(year,mes,idEstacion,idReporte){
 window.location.href = "../../solicitud-cheque-firmar/" + idReporte;  
 }

 function Eliminar(year,mes,idestacion,depu,idReporte){

      var parametros = {
    "idReporte" : idReporte
    };


alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   '../../../public/admin/modelo/eliminar-solicitud-cheque.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    SelEstacion(idestacion,depu,year,mes); 
     sizeWindow();   
     alertify.success('Solicitud eliminada exitosamente.');      
    }else{
     alertify.error('Error al eliminar la solicitud');  
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
  
 }

 function ModalComentario(year,mes,idEstacion,depu,id){
   $('#ModalComentario').modal('show');  
    $('#DivContenidoComentario').load('../../../public/admin/vistas/modal-comentarios-solicitud-cheque.php?idReporte=' + id + '&year=' + year + '&mes=' + mes + '&depu=' + depu + '&idEstacion=' + idEstacion);
 }

 function GuardarComentario(year,mes,idestacion,depu,idReporte){

    var Comentario = $('#Comentario').val();

    var parametros = {
    "idReporte" : idReporte,
    "Comentario" : Comentario
    };

    if(Comentario != ""){
    $('#Comentario').css('border',''); 

    $.ajax({
    data:  parametros,
    url:   '../../../public/admin/modelo/agregar-comentario-solicitud-cheque.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    $('#Comentario').val('');
    SelEstacion(idestacion,depu,year,mes);     
    sizeWindow();
    $('#DivContenidoComentario').load('../../../public/admin/vistas/modal-comentarios-solicitud-cheque.php?idReporte=' + idReporte + '&year=' + year + '&mes=' + mes + '&depu=' + depu + '&idEstacion=' + idestacion);
    }else{
     alertify.error('Error al eliminar la solicitud');  
    }

    }
    });

    }else{
    $('#Comentario').css('border','2px solid #A52525'); 
    }

    }

    function DescargarPDF(idReporte){

    window.location.href = "../../solicitud-cheque-pdf/" + idReporte;  

    }

    function Pago(year,mes,idEstacion,depu,id){
    $('#ModalComentario').modal('show');  
    $('#DivContenidoComentario').load('../../../public/admin/vistas/modal-pagos-solicitud-cheque.php?idReporte=' + id + '&year=' + year + '&mes=' + mes + '&idEstacion=' + idEstacion + '&depu=' + depu);
    } 
 
    function AgregarPago(year,mes,idEstacion,depu,id){

    var data = new FormData();
    var url = '../../../public/admin/modelo/agregar-pago-solicitud-cheque.php';

    Documento = document.getElementById("Documento");
    Documento_file = Documento.files[0];
    Documento_filePath = Documento.value;

    if(Documento_filePath != ""){
    $('#Documento').css('border','');

    data.append('idReporte', id);
    data.append('Documento_file', Documento_file);

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
      Pago(year,mes,idEstacion,depu,id);
      SelEstacion(idEstacion,depu,year,mes);
      sizeWindow();
      alertify.success('Pago agregado exitosamente.'); 
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al guardar pago'); 
     }
     
    });      

    }else{
    $('#Documento').css('border','2px solid #A52525'); 
    }

    }

    function EliminarDoc(year,mes,idEstacion,depu,idReporte,id){

    var parametros = {
    "id" : id
    };


alertify.confirm('',
 function(){

    $.ajax({
    data:  parametros,
    url:   '../../../public/admin/modelo/eliminar-documento-solicitud-cheque.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    Pago(year,mes,idEstacion,depu,idReporte);
    SelEstacion(idEstacion,depu,year,mes);
    sizeWindow();
    alertify.success('Documento eliminado exitosamente.');      
    }else{
     alertify.error('Error al eliminar el documento');  
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

  }


  function ModalArchivos(year,mes,idEstacion,depu,id){
  $('#ModalComentario').modal('show');  
  $('#DivContenidoComentario').load('../../../public/admin/vistas/modal-archivos-solicitud-cheque.php?idReporte=' + id + '&year=' + year + '&mes=' + mes + '&idEstacion=' + idEstacion + '&depu=' + depu);
  }   
   
    function AgregarArchivo(year,mes,idEstacion,depu,id){

    var Documento = $('#Documento').val();
    var data = new FormData();
    var url = '../../../public/admin/modelo/agregar-archivo-solicitud-cheque.php';

    Archivo = document.getElementById("Archivo");
    Archivo_file = Archivo.files[0];
    Archivo_filePath = Archivo.value;

    if(Documento != ""){
    $('#border-documento').css('border','');
    if(Archivo_filePath != ""){
    $('#Archivo').css('border','');

    data.append('idReporte', id);
    data.append('Documento', Documento);
    data.append('Archivo_file', Archivo_file);

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
      ModalArchivos(year,mes,idEstacion,depu,id);
      SelEstacion(idEstacion,depu,year,mes);
      sizeWindow();
      alertify.success('Pago agregado exitosamente.')
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al guardar pago'); 
     }
     
    });      

    }else{
    $('#Archivo').css('border','2px solid #A52525'); 
    }
    }else{
    $('#border-documento').css('border','2px solid #A52525'); 
    }

    }

  function EliminarArchivo(year,mes,idEstacion,depu,idReporte,id){
  

  var parametros = {
  "idDocumento" : id,
  "Accion" : "eliminar-documentos-solicitud-cheque"
  };

  alertify.confirm('',
  function(){

    $.ajax({
    data:  parametros,
    url : '../../../app/controlador/1-corporativo/controladorSolicitudCheque.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

      
    if (response == 1) {
    sizeWindow();
    $('#DivContenidoComentario').load('../../../public/admin/vistas/modal-archivos-solicitud-cheque.php?idReporte=' + idReporte + '&year=' + year + '&mes=' + mes + '&idEstacion=' + idEstacion + '&depu=' + depu);
    SelEstacion(idEstacion,depu,year,mes); 
    alertify.success('Archivo eliminado exitosamente.');  
   
    }else{
     alertify.error('Error al eliminar el archivo');  
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

    }

//------------------------------------------------------------------------
  function FacTelcel(idEstacion,depu,year,mes){
  $('#ModalComentario').modal('show');  
  $('#DivContenidoComentario').load('../../../public/admin/vistas/modal-telcel-solicitud-cheque.php?idEstacion=' + idEstacion + '&depu=' + depu + '&year=' + year + '&mes=' + mes);   
  }

  function AgregarFactura(idEstacion,depu,year,mes){
    var Factura = $('#Factura').val();

    var data = new FormData();
    var url = '../../../public/admin/modelo/agregar-factura-telcel-solicitud-cheque.php';

    Factura = document.getElementById("Factura");
    Factura_file = Factura.files[0];
    Factura_filePath = Factura.value;

    if(Factura_filePath != ""){
    $('#Factura').css('border','');

    data.append('idEstacion', idEstacion);  
    data.append('year', year);
    data.append('mes', mes);
    data.append('Factura_file', Factura_file);

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
      alertify.success('Factura agregada exitosamente.');
      $('#DivContenidoComentario').load('../../../public/admin/vistas/modal-telcel-solicitud-cheque.php?idEstacion=' + idEstacion + '&depu=' + depu + '&year=' + year + '&mes=' + mes);   
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al guardar'); 
     }
     
    });      

    }else{
    $('#Factura').css('border','2px solid #A52525'); 
    }

  }

  function EliminarTelcel(idEstacion,depu,year,mes,id){

    var parametros = {
    "id" : id
    };


alertify.confirm('',
 function(){

    $.ajax({
    data:  parametros,
    url:   '../../../public/admin/modelo/eliminar-telcel-solicitud-cheque.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
       alertify.success('Archivo eliminado exitosamente.')
    $('#DivContenidoComentario').load('../../../public/admin/vistas/modal-telcel-solicitud-cheque.php?idEstacion=' + idEstacion + '&depu=' + depu + '&year=' + year + '&mes=' + mes);  
    }else{
     alertify.error('Error al eliminar el archivo');  
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

  }

  function EditarTelcel(idEstacion,depu,year,mes,id){
   $('#DivContenidoComentario').load('../../../public/admin/vistas/modal-editar-telcel-solicitud-cheque.php?idEstacion=' + idEstacion + '&depu=' + depu + '&year=' + year + '&mes=' + mes + '&id=' + id);   
  }

  function CancelarTelcel(idEstacion,depu,year,mes){
   $('#DivContenidoComentario').load('../../../public/admin/vistas/modal-telcel-solicitud-cheque.php?idEstacion=' + idEstacion + '&depu=' + depu + '&year=' + year + '&mes=' + mes); 
  }

  function EditarTelcelInfo(idEstacion,depu,year,mes,id){

    var data = new FormData();
    var url = '../../../public/admin/modelo/editar-factura-telcel-solicitud-cheque.php';

    Factura = document.getElementById("Factura");
    Factura_file = Factura.files[0];
    Factura_filePath = Factura.value;

    Pago = document.getElementById("Pago");
    Pago_file = Pago.files[0];
    Pago_filePath = Pago.value;

    data.append('id', id);
    data.append('Factura_file', Factura_file);
    data.append('Pago_file', Pago_file);

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
      alertify.success('Documentación actualizada correctamente');
      $('#DivContenidoComentario').load('../../../public/admin/vistas/modal-telcel-solicitud-cheque.php?idEstacion=' + idEstacion + '&depu=' + depu + '&year=' + year + '&mes=' + mes);  
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al editar'); 
     }
     
    });      

  }

  function Telcel(estacion,year,mes){
  window.location.href =  "../../factura-telcel/" + estacion + "/" + year + "/" + mes;
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
   
      <?php
      if($session_nompuesto == "Contabilidad"){
        $referencia = "href=".PORTAL." ";
        $nombreBar2 = "Portal";

      }else if($Session_IDUsuarioBD == 357){
        $referencia = "href='../../solicitud-cheque' ";
        $nombreBar2 = "Menu";

      }else{
        $referencia = "href=".SERVIDOR_ADMIN." ";
        $nombreBar2 = "Menu";
      }

      ?>


<li id="menu-item">

    <a class="pointer" <?=$referencia?>>
    <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i><?=$nombreBar2?>
    </a>
    </li>

  <!---------- SESIONES CLEAN ---------->
  <script>
  document.addEventListener('DOMContentLoaded', function () {
  var menuItem = document.getElementById('menu-item');
    
  menuItem.addEventListener('click', function () {
  sessionStorage.removeItem('idestacion');
  sessionStorage.removeItem('depu');
  sessionStorage.removeItem('year');
  sessionStorage.removeItem('mes');
    });
  });
  </script>


  <li>
    <a class="pointer" onclick="Regresar()">
    <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
    </a>
  </li>


<?php
  $sql_listaestacion = "SELECT id, nombre, numlista FROM tb_estaciones WHERE numlista <= 8 ORDER BY numlista ASC";
  $result_listaestacion = mysqli_query($con, $sql_listaestacion);
  while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
  $id = $row_listaestacion['id'];
  $estacion = $row_listaestacion['nombre'];


  $ToSolicitud = ToSolicitud($id,0,$GET_year,$GET_mes,$con);

  if($ToSolicitud > 0){
    $Nuevo = '<div class="float-end"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToSolicitud.'</small></span></div>';
  }else{
   $Nuevo = ''; 
  }

  if ($session_nompuesto == "Contabilidad") {

  if($Session_IDUsuarioBD == 419){

  }else{

  if ($id == 1 || $id == 2 || $id == 3 || $id == 4 || $id == 5 || $id == 14 ) {
 
  echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.',0,'.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$Nuevo.' '.$estacion.'
    </a>
  </li>';
  }

  }
  }else if ($session_nompuesto == "Comercializadora") {
      
  if ($id == 6 || $id == 7) {
   echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.',0,'.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$Nuevo.' '.$estacion.'
    </a>
  </li>';
  }
  }else{
    echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.',0,'.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$Nuevo.' '.$estacion.'
    </a>
  </li>';
  }

  } 


  $ToGestoria = ToSolicitud(8,5,$GET_year,$GET_mes,$con);
  $ToComer = ToSolicitud(8,4,$GET_year,$GET_mes,$con);
  $ToQuitarga = ToSolicitud(8,18,$GET_year,$GET_mes,$con);
  $ToOperacion = ToSolicitud(8,19,$GET_year,$GET_mes,$con);
  $ToBanca = ToSolicitud(8,23,$GET_year,$GET_mes,$con);

  if($ToGestoria > 0){
    $MenGestoria = '<div class="float-end"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToGestoria.'</small></span></div>';
  }else{
   $MenGestoria = ''; 
  }

  if($ToComer > 0){
    $MenComer = '<div class="float-end"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToComer.'</small></span></div>';
  }else{
   $MenComer = ''; 
  }

  if($ToQuitarga > 0){
    $MenQuitarga = '<div class="float-end"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToQuitarga.'</small></span></div>';
  }else{
   $MenQuitarga = ''; 
  }

  if($ToOperacion > 0){
    $MenOperacion = '<div class="float-end"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToOperacion.'</small></span></div>';
  }else{
   $MenOperacion = ''; 
  }

    if($ToBanca > 0){
    $MenBanca = '<div class="float-end"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToBanca.'</small></span></div>';
  }else{
   $MenBanca = ''; 
  }

  if ($session_nompuesto != "Dirección de operaciones"  && $session_nompuesto != "Dirección de operaciones servicio social") {
 
  echo '  
  <li>
    <a class="pointer" onclick="SelEstacion(8,5,'.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-briefcase" aria-hidden="true" style="padding-right: 10px;"></i>
      '.$MenGestoria.' Gestoria
    </a>
  </li>';

  }

  if($Session_IDUsuarioBD == 344){

  echo '  
  <li>
    <a class="pointer" onclick="SelEstacion(8,5,'.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-briefcase" aria-hidden="true" style="padding-right: 10px;"></i>
      '.$MenGestoria.' Gestoria
    </a>
  </li>';

  }

if ($session_nompuesto != "Contabilidad"  && $session_nompuesto != "Dirección de operaciones servicio social") {
  
  echo '  
  <li>
    <a class="pointer" onclick="SelEstacion(8,4,'.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
        '.$MenComer.' Comercializadora
    </a>
  </li>';

  echo '  
  <li>
    <a class="pointer" onclick="SelEstacion(8,18,'.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
        '.$MenQuitarga.' Quitarga
    </a>
  </li>';
}

if($session_nompuesto != "Comercializadora"){
  

  echo '  
  <li>
    <a class="pointer" onclick="SelEstacion(8,19,'.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-screwdriver-wrench" aria-hidden="true" style="padding-right: 10px;"></i>
         '.$MenOperacion.' Operación, servicio y mantenimiento de personal
    </a>
  </li>';

  echo '  
  <li>
    <a class="pointer" onclick="SelEstacion(8,23,'.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-building-columns" aria-hidden="true" style="padding-right: 10px;"></i>
         '.$MenBanca.' BANCAMIFEL, SOCIEDAD ANÓNIMA, FIDEICOMISO 2176/2016
    </a>
  </li>';
}

  if($Session_IDUsuarioBD == 419){

  echo '  
  <li>
    <a class="pointer" onclick="SelEstacion(14,0,'.$GET_year.','.$GET_mes.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
         '.$MenComer.' Bosque Real
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
  <a class="text-dark" onclick="history.back()">Solicitud de cheques, <?=nombremes($GET_mes);?> <?=$GET_year;?></a>
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
  <div class="col-12" id="ListaEmbarques" ></div>
  </div> 
  </div>

  </div> 
  </div>

  </div>

  <!---------- MODAL (RIGHT)---------->  
  <div class="modal right fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
  <div class="modal-content" id="DivContenido"></div>
  </div>
  </div>
  
  <!---------- MODAL (CENTER)---------->  
  <div class="modal fade" id="ModalComentario" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
  <div class="modal-content" id="DivContenidoComentario">
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