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
  if (sessionStorage.getItem('idEstacion') !== undefined && sessionStorage.getItem('idEstacion')) {

  idEstacion = sessionStorage.getItem('idEstacion');
  year = sessionStorage.getItem('year');
  mes = sessionStorage.getItem('mes');

  SelEstacionLts(idEstacion,year,mes)
           
  }     
  }   
   
  }); 

  function Regresar(){
  window.history.back();
  }


  function SelEstacionLts(idEstacion,year,mes){

  sizeWindow();
  sessionStorage.setItem('idEstacion', idEstacion);
  sessionStorage.setItem('year', year);
  sessionStorage.setItem('mes', mes);  
    
    let targets;
      targets = [2];
      $('#ListaCuentaLts').load('../../../public/admin/vistas/lista-cuenta-litros.php?idEstacion=' + idEstacion + '&year=' + year + '&mes=' + mes, function () {
        $('#tabla_cuenta_litros_' + idEstacion).DataTable({
          "stateSave": true,
          "language": {
            "url": '<?= RUTA_JS2 ?>' + "/es-ES.json"
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

  //---------- FORMULARIO EDITAR CUENTA LITROS ----------
  function EditarCL(idCuentaLitros){
  window.location.href = "../../cuenta-litros-formato/" + idCuentaLitros; 
  }

  //---------- MODAL NUEVO CUENTA LITROS ----------
  function DetalleCL(idCuentaLitros){
  window.location.href = "../../cuenta-litros-detalle/" + idCuentaLitros; 
  }

  //---------- FORMULARIO AGREGAR CUENTA LITROS ----------
  function NuevoCuentaLitros(idEstacion,year,mes){

  var parametros = {
  "idEstacion" : idEstacion,
  "year" : year,
  "mes" : mes
  };

  $.ajax({   
  data:  parametros,
  url:   '../../../public/admin/modelo/agregar-formato-cuenta-litros.php',
  type:  'POST',
  beforeSend: function() { 
     
  },  
  complete: function(){
    
  },
  success:  function (response) {
 
  if(response != 0){
  window.location.href = "../../cuenta-litros-formato/" + response; 
  }
 
  } 
  });
 
 
  }


  //---------- ELIMINAR CUENTA LITROS REGISTRO (SERVER) ----------
  function EliminarCL(idCuentaLitros,idEstacion,year,mes){

  var parametros = {
  "idCuentaLitros" : idCuentaLitros
  };


  alertify.confirm('',
  function(){

  $.ajax({
  data:  parametros,    
  url:   '../../../public/admin/modelo/eliminar-cuenta-litros-registro.php',
  type:  'post',
  beforeSend: function() {
  }, 
  complete: function(){
 
  },
  success:  function (response) {

  if (response == 1) {
  alertify.success('Registro eliminado exitosamente.')
  SelEstacionLts(idEstacion,year,mes)

  }else{
  alertify.error('Error al eliminar el registro');  
  }

  }
  });

  },
  function(){

  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar el registro seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

  }


  function HabilitarCL(idCuentaLitros){

      var parametros = {
  "idCuentaLitros" : idCuentaLitros
   };


  alertify.confirm('',
  function(){

    $.ajax({
    data:  parametros,    
    url:   '../../../public/admin/modelo/habilitar-cuenta-litros.php',
    type:  'post',
    beforeSend: function() {
    }, 
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    alertify.success('Cuenta litros habilitado exitosamente');  
    SelEstacionLts(idEstacion,year,mes)


    }else{
     alertify.error('Error al habilitar cuenta litros');  
    }

    }
    });

  },
  function(){

  }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea habilitar el cuenta litros seleccionado?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();



  }

  </script>
  </head> 
 
  <body> 
  <div class="LoaderPage"></div>

  <!---------- CONTENIDO Y BARRA DE NAVEGACION ---------->
  <div class="wrapper"> 
  <!---------- BARRA DE NAVEGACION ---------->
  <nav id="sidebar">
  <div class="sidebar-header text-center"><img class="" src="<?=RUTA_IMG_LOGOS."Logo.png";?>" style="width: 100%;"></div>

  <ul class="list-unstyled components">

  <?php
  if($Session_IDUsuarioBD == 509){
  $referencia = "href= ../../importacion ";
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

    $sql_listaestacion = "SELECT id, nombre FROM tb_estaciones WHERE numlista <= 8 ORDER BY numlista ASC";
    $result_listaestacion = mysqli_query($con, $sql_listaestacion);

    while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
    $id = $row_listaestacion['id'];
    $estacion = $row_listaestacion['nombre'];

      echo '
      <li>
      <a class="pointer" onclick="SelEstacionLts('.$id.', '.$GET_idYear.','.$GET_idMes.')">
      <i class="fa-solid fa-gas-pump" aria-hidden="true" style="padding-right: 10px;"></i>
      '.$estacion.'
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
  <a class="text-dark" onclick="history.back()">Importación</a>
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
  <div class="col-12" id="ListaCuentaLts" ></div>
  </div>
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
           