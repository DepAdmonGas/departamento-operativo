<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
} 

function ToSolicitud($idEstacion,$con){
$sql_lista = "SELECT id FROM op_mantenimiento_preventivo WHERE id_estacion = '".$idEstacion."' AND status < 2 ";
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
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" ></script>
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>selectize.css">
  
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

    if(sessionStorage){
    if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {

    idestacion = sessionStorage.getItem('idestacion');
    $('#ContenidoPrin').load('../public/admin/vistas/lista-mantenimiento-preventivo.php?idEstacion=' + idestacion);
         
    } 
    
    }   
   
  }); 

  function Regresar(){
  window.history.back();
  }

  function MantenimientoP(idEstacion){
  sizeWindow();  
  sessionStorage.setItem('idestacion', idEstacion);
  $('#ContenidoPrin').load('../public/admin/vistas/lista-mantenimiento-preventivo.php?idEstacion=' + idEstacion);
  }

  function Nuevo(idEstacion){

    var parametros = {
    "idEstacion" : idEstacion
    };
  
    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/agregar-mantenimiento-preventivo.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    ModalEditar(idEstacion,response)
    MantenimientoP(idEstacion)
    }
    });
  }


 function ModalEditar(idEstacion,response){
   $('#Modal').modal('show');  
    $('#ContenidoModal').load('../public/admin/vistas/modal-mantenimiento-preventivo-editar.php?idReporte=' + response + '&idEstacion=' + idEstacion);
 }


 function Guardar(idEstacion,idReporte){



    var data = new FormData();
    var url = '../public/admin/modelo/editar-mantenimiento-preventivo.php';

    let Nombre = $('#Nombre').val();
    let Fecha = $('#Fecha').val();
    let Fecha2 = $('#Fecha2').val();
    let Observacion = $('#Observacion').val();


    Archivo = document.getElementById("Archivo");
    Archivo_file = Archivo.files[0];
    Archivo_filePath = Archivo.value;


    data.append('idReporte', idReporte);
    data.append('Archivo_file', Archivo_file);
    data.append('Nombre', Nombre);
    data.append('Fecha2', Fecha2);
    data.append('Fecha', Fecha);
    data.append('Observacion', Observacion);
   
    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){

      sizeWindow()
      alertify.success('Registro agregado exitosamente')
      MantenimientoP(idEstacion)
      $('#Modal').modal('hide');
     
    }); 
 }

 function Eliminar(idEstacion,idReporte){

      var parametros = {
    "idEstacion" : idEstacion,
    "id" : idReporte
    };

alertify.confirm('',
 function(){
 
    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/eliminar-mantenimiento-preventivo.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    MantenimientoP(idEstacion)
    sizeWindow();
    alertify.success('Mantenimiento eliminado exitosamente.');

    }
    });

},
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

 }



  function ActualizarStatus(idEstacion,idReporte,status){

    if(status == 0){
    var msg = "cambiar el estatus del mantenimiento seleccionado a: En Proceso";

    }else if(status == 1){
    var msg = "cambiar el estatus del mantenimiento seleccionado a: Finalizado";

    }

 
     alertify.confirm('',
     function(){

    var parametros = {
    "idEstacion" : idEstacion,
    "idReporte" : idReporte,
    "Status" : status
    };

    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/actualizar-status-mantenimiento-preventivo.php',
    type:  'post',
    beforeSend: function() {
    }, 
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    MantenimientoP(idEstacion)
    sizeWindow();
    alertify.success('Estatus de mantenimiento actualizado exitosamente.');

    }else{
     alertify.error('Error al actualizar el estatus del mantenimiento');  
    }

    } 
    });



     },
     function(){

     }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea ' + msg + '?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

    }


  function DocumentosMtto(idEstacion){

   $('#Modal').modal('show');  
    $('#ContenidoModal').load('../public/admin/vistas/modal-mantenimiento-preventivo-archivos.php?idEstacion=' + idEstacion);

  }  

  function GuardarArchivo(idEstacion){
   
    let Documentacion  = $('#Archivo').val();
    let Fecha = $('#Fecha').val();


    Archivo = document.getElementById("Archivo");
    Archivo_file = Archivo.files[0];
    Archivo_filePath = Archivo.value;
 

    var data = new FormData();
    var url = '../public/admin/modelo/agregar-archivo-mantenimiento-preventivo.php';

    if(Fecha != ""){
    $('#Fecha').css('border','');
    if(Archivo_filePath != ""){
    $('#Archivo').css('border','');

    data.append('idEstacion', idEstacion);
    data.append('Fecha', Fecha);
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
   
    $(".LoaderPage").hide();
    alertify.success('Prueba de eficiencia agregada exitosamente')
    $('#ContenidoModal').load('../public/admin/vistas/modal-mantenimiento-preventivo-archivos.php?idEstacion=' + idEstacion);
 
    }); 

    }else{
    $('#Archivo').css('border','2px solid #A52525'); 
    }
    }else{
    $('#Fecha').css('border','2px solid #A52525'); 
    }

  }
  

  function EliminarPrueba(idArchivo,idEstacion){
     
      var parametros = {
    "idArchivo" : idArchivo
    };

  alertify.confirm('',
   function(){
  
     $(".LoaderPage").show();
    $.ajax({
    data:  parametros,
    url:   '../public/admin/modelo/eliminar-archivo-mantenimiento-preventivo.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {
    $(".LoaderPage").hide(); 

    $('#ContenidoModal').load('../public/admin/vistas/modal-mantenimiento-preventivo-archivos.php?idEstacion=' + idEstacion);
    alertify.success('Prueba de eficiencia eliminada exitosamente.');

    }
    });

},
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();


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
$sql_listaestacion = "SELECT id, nombre, numlista FROM tb_estaciones WHERE numlista <= 8 ORDER BY numlista ASC";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$id = $row_listaestacion['id'];
$estacion = $row_listaestacion['nombre'];

$ToSolicitud = ToSolicitud($id,$con);

if($ToSolicitud > 0){
$Nuevo = '<div class="float-end"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToSolicitud.'</small></span></div>';
}else{
$Nuevo = ''; 
}

  echo '  
  <li>
    <a class="pointer" onclick="MantenimientoP('.$id.')">
    <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
    '.$Nuevo.' '.$estacion.'
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
  <a class="text-dark" onclick="history.back()">Mantenimiento preventivo</a>
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
  <div id="ContenidoPrin" class="cardAG"></div>
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
