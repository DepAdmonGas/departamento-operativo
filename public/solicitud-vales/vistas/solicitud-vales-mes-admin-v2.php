<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}
 
function ToSolicitud($idEstacion,$depu,$year,$mes,$con){

if($idEstacion == 8){
$busqueda = 'depto = '.$depu;
}else{
$busqueda = 'id_estacion = '.$idEstacion; 
} 

$sql_lista = "SELECT id FROM op_solicitud_vale WHERE id_year = '".$year."' AND id_mes = '".$mes."' AND status = 0 AND $busqueda ";
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
      depu = sessionStorage.getItem('depu');
      year = sessionStorage.getItem('year');
      mes = sessionStorage.getItem('mes');

      $('#ListaVales').load('../../public/solicitud-vales/vistas/lista-solicitud-vales-mes.php?idEstacion=' + idestacion + '&depu=' + depu + '&year=' + year + '&mes=' + mes);
           
    }
      
    }  

    });   

  function Regresar(){
   window.history.back();
  }

  function SelEstacion(idestacion,depu,year,mes){
    sizeWindow();
    sessionStorage.setItem('idestacion', idestacion);
    sessionStorage.setItem('depu', depu);
    sessionStorage.setItem('year', year);
    sessionStorage.setItem('mes', mes);

    $('#ListaVales').load('../../public/solicitud-vales/vistas/lista-solicitud-vales-mes.php?idEstacion=' + idestacion + '&depu=' + depu + '&year=' + year + '&mes=' + mes);
  }

  function Mas(idEstacion,depu,year,mes){
  window.location.href = "../../solicitud-vales-nuevo/" + year + "/" + mes + "/" + idEstacion + "/" + depu; 
  }

   function ModalDetalle(id){
    $('#Modal').modal('show');  
    $('#DivContenido').load('../../public/solicitud-vales/vistas/modal-detalle-solicitud-vale.php?idReporte=' + id);
    }

    function DescargarPDF(idReporte){
    window.location.href = "../../solicitud-vales-pdf/" + idReporte;
    }

    //--------------------------------------------------------------

    function ModalArchivos(year,mes,idEstacion,depu,id){
      $('#ModalComentario').modal('show');  
    $('#DivContenidoComentario').load('../../public/solicitud-vales/vistas/modal-archivos-solicitud-vale.php?idReporte=' + id + '&year=' + year + '&mes=' + mes + '&idEstacion=' + idEstacion + '&depu=' + depu);
    } 

        function AgregarArchivo(year,mes,idEstacion,depu,id){

    var Documento = $('#Documento').val();
    var data = new FormData();
    var url = '../../public/solicitud-vales/modelo/agregar-archivo-solicitud-vale.php';

    Archivo = document.getElementById("Archivo");
    Archivo_file = Archivo.files[0];
    Archivo_filePath = Archivo.value;

    if(Documento != ""){
    $('#Documento').css('border','');
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
      alertify.success('Archivo agregado exitosamente.')
     }else{
      $(".LoaderPage").hide();
      alertify.error('Error al guardar archivo'); 
     }
     
    });      

    }else{
    $('#Archivo').css('border','2px solid #A52525'); 
    }
    }else{
    $('#Documento').css('border','2px solid #A52525'); 
    }

    }

    function EliminarArchivo(year,mes,idEstacion,depu,idReporte,id){

    var parametros = {
    "id" : id
    };


alertify.confirm('',
 function(){

    $.ajax({
    data:  parametros,
    url:   '../../public/solicitud-vales/modelo/eliminar-documento-solicitud-vale.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    ModalArchivos(year,mes,idEstacion,depu,idReporte);
    SelEstacion(idEstacion,depu,year,mes); 
    sizeWindow();
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

    //-----------------------------------

  function Editar(year,mes,idEstacion,idReporte){
 window.location.href = "../../solicitud-vales-editar/" + year + "/" + mes + "/" + idEstacion + "/" + idReporte;  
 }

 function Firmar(year,mes,idEstacion,idReporte){
 window.location.href = "../../solicitud-vales-firmar/" + idReporte;  
 }

  //------------------------------------------------------
  //------------------------------------------------------
   function ModalComentario(year,mes,idEstacion,depu,id){
   $('#ModalComentario').modal('show');  
    $('#DivContenidoComentario').load('../../public/solicitud-vales/vistas/modal-comentarios-solicitud-vale.php?idReporte=' + id + '&year=' + year + '&mes=' + mes + '&depu=' + depu + '&idEstacion=' + idEstacion);
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
    url:   '../../public/solicitud-vales/modelo/agregar-comentario-solicitud-vale.php',
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
    $('#DivContenidoComentario').load('../../public/solicitud-vales/vistas/modal-comentarios-solicitud-vale.php?idReporte=' + idReporte + '&year=' + year + '&mes=' + mes + '&idEstacion=' + idestacion);
    }else{
     alertify.error('Error al eliminar la solicitud');  
    }

    }
    });

    }else{
    $('#Comentario').css('border','2px solid #A52525'); 
    }

    }
  //------------------------------------------------------
  //------------------------------------------------------
   function Eliminar(year,mes,idestacion,depu,idReporte){

    var parametros = {
    "idReporte" : idReporte
    };


  alertify.confirm('',
   function(){

      $.ajax({
    data:  parametros,
    url:   '../../public/solicitud-vales/modelo/eliminar-solicitud-vale.php',
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

 //------------------------------------------------------------------------------

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
        $referencia = "href='../../solicitud-vales' ";
        $nombreBar2 = "Menu";

      }else{
        $referencia = "href=".SERVIDOR_ADMIN." ";
        $nombreBar2 = "Menu";
      }

      ?>


    <li>
    <a class="pointer" <?=$referencia?>>
    <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i><?=$nombreBar2?>
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


  $ToSolicitud = ToSolicitud($id,0,$GET_year,$GET_mes,$con);

  if($ToSolicitud > 0){
    $Nuevo = '<div class="float-end"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToSolicitud.'</small></span></div>';
  }else{
   $Nuevo = ''; 
  }

   echo '  
  <li>
    <a class="pointer" onclick="SelEstacion('.$id.',0,'.$GET_year.','.$GET_mes.')">
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
  <a class="text-dark" onclick="history.back()">Solicitud de vales, <?=nombremes($GET_mes);?> <?=$GET_year;?></a>
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
  <div id="ListaVales" class="cardAG"></div>
  </div> 
 
  </div>
  </div> 
  </div>

  </div>

  <div class="modal" id="Modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="margin-top: 83px;">
      <div id="DivContenido"></div>
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