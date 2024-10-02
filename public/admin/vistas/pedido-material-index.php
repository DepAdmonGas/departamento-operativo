<?php
require('app/help.php');

function ToSolicitud($idEstacion,$con){
$sql_lista = "SELECT id FROM op_pedido_materiales WHERE id_estacion = '".$idEstacion."' AND estatus < 2";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

return $numero_lista;
 
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
  $('[data-toggle="tooltip"]').tooltip();
  sizeWindow();  
 
    if(sessionStorage){
    if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {

    idestacion = sessionStorage.getItem('idestacion');           
    PedidoMaterial(idestacion)

    }   
     
    }  
  
  });

  function Regresar(){
  window.history.back();
  }

  function PedidoMaterial(idEstacion){
  let targets;
  targets = [5, 6, 7];

  sizeWindow();  
  sessionStorage.setItem('idestacion', idEstacion);
  
  $('#ContenidoPrin').load('../public/admin/vistas/lista-pedido-materiales.php?idEstacion=' + idEstacion, function() {
  $('#tabla_orden_' + idEstacion).DataTable({
    "stateSave": true,

  "language": {
  "url": "<?=RUTA_JS2?>/es-ES.json"
  },
  "order": [[0, "desc"]],
  "lengthMenu": [15, 30, 50, 100],
  "columnDefs": [
  { "orderable": false, "targets": targets },
  { "searchable": false, "targets": targets }
  ]
  });
  });
  
  }




  function Nuevo(idEstacion){

    var parametros = {
    "idEstacion" : idEstacion
    };

    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/agregar-pedido-materiales.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

      window.location.href = "pedido-material/" + response;

    }
    }); 
  }

  function Editar(id){
window.location.href = "pedido-material/" + id;
  }
 
  function Eliminar(idEstacion,id){

    var parametros = {
    "idEstacion" : idEstacion,
    "id" : id,
    "categoria" : 1
    };
 

alertify.confirm('',
 function(){
 
        $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/eliminar-pedido-materiales.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {
    alertify.success('Pedido eliminado exitosamente.');
    PedidoMaterial(idEstacion);
    sizeWindow();

    }
    });

},
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

}

 function ModalComentario(idEstacion,id){
   $('#ModalComentario').modal('show');  
    $('#DivContenidoComentario').load('../public/admin/vistas/modal-comentarios-pedido-material.php?idReporte=' + id + '&idEstacion=' + idEstacion);
 } 

  function GuardarComentario(idestacion,idReporte){

    var Comentario = $('#Comentario').val();

    var parametros = {
    "idReporte" : idReporte,
    "Comentario" : Comentario
    };

    if(Comentario != ""){
    $('#Comentario').css('border',''); 

    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/agregar-comentario-pedido-material.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    $('#Comentario').val('');
    PedidoMaterial(idestacion);  
    $('#DivContenidoComentario').load('../public/admin/vistas/modal-comentarios-pedido-material.php?idReporte=' + idReporte + '&idEstacion=' + idestacion);
    sizeWindow();
    alertify.success('Registro eliminado exitosamente.');

    }else{
     alertify.error('Error al eliminar la solicitud');  
    }

    }
    });
 
    }else{
    $('#Comentario').css('border','2px solid #A52525'); 
    }

    }

  
  function ModalDetalle(id){
  $('#ModalR').modal('show');  
  $('#DivModalRight').load('../public/admin/vistas/modal-detalle-pedido-material.php?idPedido=' + id);
     
 }  
 
 function Firmar(idPedido){
 window.location.href = "pedido-material-firma/" + idPedido;  
 }

 function DescargarPDF(id){
window.location.href = "../pedido-material-pdf/" + id;  
 }

 function ModalEvidencia(idEstacion,id){
  $('#ModalR').modal('show');  
  $('#DivModalRight').load('../public/admin/vistas/modal-evidencia-pedido-material.php?idReporte=' + id + '&idEstacion=' + idEstacion);
 }
 
 function AgregarEvidencia(idEstacion,idReporte){
    
    var data = new FormData();
    var url = '../public/admin/modelo/agregar-instalacion-pedido-material.php';

    Imagen = document.getElementById("Imagen");
    Imagen_file = Imagen.files[0];
    Imagen_filePath = Imagen.value;

    if (Imagen_filePath != "") {
    $('#Imagen').css('border','');

    data.append('idReporte', idReporte);
    data.append('Imagen_file', Imagen_file);

    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){

    PedidoMaterial(idEstacion)
    ModalEvidencia(idEstacion,idReporte)
     
    }); 

    }else{
    $('#Imagen').css('border','2px solid #A52525');
    }
 }

 function EliminarEvidencia(id,idEstacion,idReporte){
 
  var parametros = {
  "id" : id,
  "categoria" : 5
  };

  $.ajax({
  data:  parametros,
  url:   '../public/admin/modelo/eliminar-pedido-materiales.php',
  type:  'post',
  beforeSend: function() {
  },
  complete: function(){

  },
  success:  function (response) {

  PedidoMaterial(idEstacion)
  ModalEvidencia(idEstacion,idReporte)
  alertify.success('Evidencia eliminada exitosamente.');


  }
  });

 }
 
 function ModalCausa(idEstacion,idReporte){
  $('#ModalR').modal('show');  
  $('#DivModalRight').load('../public/admin/vistas/modal-causa-pedido-material.php?idReporte=' + idReporte + '&idEstacion=' + idEstacion);

 }

 function AgregarCausa(idEstacion,idReporte){

  var Causa = $('#Causa').val();
  var Precio = $('#Precio').val();
  var Refaccion = $('#Refaccion').val();

  var data = new FormData();
  var url = '../public/admin/modelo/agregar-causa-pedido-material.php';
 
  ArchivoPDF = document.getElementById("ArchivoPDF");
  ArchivoPDF_file = ArchivoPDF.files[0];
  ArchivoPDF_filePath = ArchivoPDF.value;

  ArchivoXML = document.getElementById("ArchivoXML");
  ArchivoXML_file = ArchivoXML.files[0];
  ArchivoXML_filePath = ArchivoXML.value;
 
  if (Causa != "") {
  $('#Causa').css('border','');

  if (Refaccion != "") {
  $('#Refaccion').css('border','');

    data.append('idReporte', idReporte);
    data.append('Causa', Causa);
    data.append('Refaccion', Refaccion);
    data.append('ArchivoPDF_file', ArchivoPDF_file);
    data.append('ArchivoXML_file', ArchivoXML_file);
    data.append('Precio', Precio);


    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){

    PedidoMaterial(idEstacion)
    $('#DivModalRight').load('../public/admin/vistas/modal-causa-pedido-material.php?idReporte=' + idReporte + '&idEstacion=' + idEstacion);
    alertify.success('Registro agregado exitosamente.');

    }); 

  }else{
  $('#Refaccion').css('border','2px solid #A52525');
  }

  }else{
  $('#Causa').css('border','2px solid #A52525');
  }
    
 } 

function eliminarCausa(idEstacion,idReporte,id){
 
  var parametros = {
  "idReporte" : id
  };
 

  alertify.confirm('',
 function(){

  $.ajax({
  data:  parametros,
  url:   '../public/admin/modelo/eliminar-causa-pedido-materiales.php',
  type:  'post',
  beforeSend: function() {
  },
  complete: function(){

  },
  success:  function (response) {

    PedidoMaterial(idEstacion)  
  $('#DivModalRight').load('../public/admin/vistas/modal-causa-pedido-material.php?idReporte=' + idReporte + '&idEstacion=' + idEstacion);
    alertify.success('Registro eliminado exitosamente.');

  }
  });

  },
 function(){
 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el registro seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

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
 
  
<?php
$sql_listaestacion = "SELECT id, localidad, numlista FROM op_rh_localidades WHERE numlista <= 8 OR numlista = 10 ORDER BY numlista ASC";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$id = $row_listaestacion['id'];
$estacion = $row_listaestacion['localidad'];

$ToSolicitud = ToSolicitud($id,$con);

if($ToSolicitud > 0){
$Nuevo = '<div class="float-end"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToSolicitud.'</small></span></div>';
}else{
$Nuevo = ''; 
}

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

  }else if($estacion == "Dirección de operaciones" || $estacion == "Departamento Gestión" || $estacion == "Departamento Jurídico" ||
  $estacion == "Departamento Mantenimiento" || $estacion == "Departamento Sistemas"){
  $icon = "fa-solid fa-briefcase"; 

  }else{
  $icon = "fa-solid fa-gas-pump";    
  }
 


  if ($session_nompuesto == "Comercializadora") {

    if($Session_IDUsuarioBD == 28){
    
    if($id == 6 || $id == 7){
  
      echo '  
      <li>
      <a class="pointer" onclick="PedidoMaterial('.$id.')"> <i class="'.$icon.'" aria-hidden="true" style="padding-right: 10px;"></i>'.$Nuevo.' '.$estacion.'</a>
      </li>';
    }

  }else{

    echo '  
    <li>
    <a class="pointer" onclick="PedidoMaterial('.$id.')"> <i class="'.$icon.'" aria-hidden="true" style="padding-right: 10px;"></i>'.$Nuevo.' '.$estacion.'</a>
    </li>';
  }
  
  }else{
  
    echo '  
    <li>
    <a class="pointer" onclick="PedidoMaterial('.$id.')"> <i class="'.$icon.'" aria-hidden="true" style="padding-right: 10px;"></i>'.$Nuevo.' '.$estacion.'</a>
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
  <a class="text-dark" onclick="history.back()">Almacén</a>
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
  <div class="col-12" id="ContenidoPrin" ></div>
  </div>
  </div> 

  </div>

  </div>

  <!---------- MODAL ----------> 
  <div class="modal fade" id="ModalComentario" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
  <div class="modal-content" id="DivContenidoComentario">
  </div>
  </div>
  </div>

  <!---------- MODAL COVID (RIGHT)---------->  
  <div class="modal right fade" id="ModalR" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-xl">
  <div class="modal-content" id="DivModalRight"></div>
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
