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
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
  <script type="text/javascript" src="<?=RUTA_JS ?>alertify.js"></script> 

 
  <script type="text/javascript">
  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
  sizeWindow();

  if(sessionStorage){
  if (sessionStorage.getItem('idestacion') !== undefined && sessionStorage.getItem('idestacion')) {
  idEstacion = sessionStorage.getItem('idestacion');
  SelBitacora(idEstacion)

  }
  } 

  });


  function Regresar(){
  sessionStorage.removeItem('idestacion');
  window.history.back();
  } 


  function SelBitacora(idEstacion){  
  sizeWindow();  
  sessionStorage.setItem('idestacion', idEstacion);

  $('#Inventario').load('../public/admin/vistas/bitacora-aditivo.php?idEstacion=' + idEstacion, function() {
  $('#tabla_aditivo_' + idEstacion).DataTable({
    "stateSave": true,

  "language": {
  "url": "<?=RUTA_JS2?>/es-ES.json"
  },
  "order": [[0, "desc"]],
  "lengthMenu": [25, 50, 75, 100]
  });
  });
  
  }




  function SelBitacoraReturn(idEstacion){
  sessionStorage.setItem('idestacion', idEstacion);
  SelBitacora(idEstacion)
  }  
 
  function SelInventario(idEstacion){
  sessionStorage.setItem('idestacion', idEstacion);

  $('#Inventario').load('../public/admin/vistas/inventario-aditivo.php?idEstacion=' + idEstacion, function() {
  $('#tabla_inventario_aditivo_' + idEstacion).DataTable({
  "stateSave": true,

  "language": {
  "url": "<?=RUTA_JS2?>/es-ES.json"
  },
  "order": [[0, "desc"]],
  "lengthMenu": [15, 30, 50, 100]
  });
  });
 
  } 

  function ModalAgregar(idEstacion){
  $('#Modal').modal('show');
  $('#ModalAgregar').load('../public/admin/vistas/modal-agregar-aditivo.php?idEstacion=' + idEstacion);
  } 
 
  function Agregar(idEstacion){

  var AditivoGasolina = $('#AditivoGasolina').val();
  var AditivoDiesel = $('#AditivoDiesel').val();

  var parametros = {
 "idEstacion" : idEstacion,
 "AditivoGasolina" : AditivoGasolina,
 "AditivoDiesel" : AditivoDiesel
 };

$.ajax({
  data:  parametros,
  url:   '../public/admin/modelo/agregar-inventario-aditivo.php',
  type:  'post',
  beforeSend: function() {
  },
  complete: function(){

  },
  success:  function (response) {

if (response == 1) {
  $('#Modal').modal('hide');
  SelInventario(idEstacion)
  alertify.success('Aditivo agregado exitosamente.');
}
  }
  });

  }

function Resumen(){
  sessionStorage.removeItem('idestacion');
  location.reload();
  }

  function PDF(){
  window.location = "../public/admin/vistas/pdf-resumen-inventario-aditivo.php";
  }
  
 
  function SelReporte(idEstacion){
  let targets;
  sessionStorage.setItem('idestacion', idEstacion);
  targets = [3, 4];

  $('#Inventario').load('../public/admin/vistas/reporte-aditivo.php?idEstacion=' + idEstacion, function() {
  $('#tabla_reporte_aditivo_' + idEstacion).DataTable({
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

  function EliminarReporte(idEstacion,id){

alertify.confirm('',
 function(){

var parametros = {
  "idEstacion" : idEstacion,
  "idBitacora" : id
 };

 $.ajax({
  data:  parametros,
  url:   '../public/admin/modelo/eliminar-reporte-aditivo.php',
  type:  'post',
  beforeSend: function() {
  },
  complete: function(){

  },
  success:  function (response) {

  if (response == 1) {
  alertify.success('Se elimino la información');
  SelReporte(idEstacion);
  }

  }
  });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: 'Desea eliminar la información seleccionada',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();


}
  </script>
  </head>

  <body> 

  <div class="LoaderPage"></div>


  <!---------- CONTENIDO Y BARRA DE NAVEGACION ---------->
 <div class="wrapper"> 

  <!---------- BARRA DE NAVEGACION ---------->
  <nav id="sidebar">

  <div class="sidebar-header " >
  <img class="text-center" src="<?php echo RUTA_IMG_ICONOS."Logo.png";?>" style="width: 100%;">
  </div>

  <ul class="list-unstyled components">
    
  <?php
  if($Session_IDUsuarioBD != 509){
  ?>

  <li>
    <a class="pointer" href="<?=SERVIDOR_ADMIN?>">
    <i class="fa-solid fa-house" aria-hidden="true" style="padding-right: 10px;"></i>Menu
    </a>
  </li>

  <?php
  }
  ?>


  <li>
    <a class="pointer" onclick="Regresar()">
    <i class="fas fa-arrow-left" aria-hidden="true" style="padding-right: 10px;"></i>Regresar
    </a>
  </li>


    <?php
 
  echo '  
  <li>
    <a class="pointer" onclick="Resumen()">
    <i class="fa-solid fa-clock-rotate-left" aria-hidden="true" style="padding-right: 10px;"></i>
    <strong>Resumen</strong>
    </a>
  </li>';

$sql_listaestacion = "SELECT id, numlista, nombre FROM tb_estaciones WHERE numlista <= 8 ORDER BY numlista ASC";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);

   while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
    $id = $row_listaestacion['id'];
    $estacion = $row_listaestacion['nombre'];

  echo '  
  <li>
    <a class="pointer" onclick="SelBitacora('.$id.')">
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
  <a class="text-dark" onclick="history.back()">Bitácora aditivo</a>
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

  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG">
  <div class="row">  
  
  <div class="col-12" id="Inventario">
      
  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Importación</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Resumen inventario de aditivo</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Resumen inventario de aditivo</h3>
  </div>

  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
  <button type="button" class="btn btn-labeled2 btn-success float-end" onclick="PDF()">
  <span class="btn-label2"><i class="fa-regular fa-file-pdf"></i></span>Descargar Resumen</button>
  </div>

  </div>

  <hr>
  </div>

  <div class="table-responsive">
  <table class="custom-table" style="font-size: 12.5px;" width="100%">

  <thead class="tables-bg">
  <th class="align-middle text-center">Estación</th>
  <th class="align-middle text-center">Gasolina Hitec 6590C</th>
  <th class="align-middle text-center">Diesel Hitec 4133G</th>
  </thead>

  <tbody class="bg-white">
  <?php

  $sql_inventario = "SELECT 
  op_inventario_aditivo.id,
  op_inventario_aditivo.id_estacion,
  op_inventario_aditivo.gasolina,
  op_inventario_aditivo.diesel,
  tb_estaciones.nombre
  FROM op_inventario_aditivo 
  INNER JOIN tb_estaciones 
  ON op_inventario_aditivo.id_estacion = tb_estaciones.id WHERE op_inventario_aditivo.id <= 8";
  $result_inventario = mysqli_query($con, $sql_inventario);

    while($row_inventario = mysqli_fetch_array($result_inventario, MYSQLI_ASSOC)){

  echo '<tr>
  <th class="fw-normal">'.$row_inventario['nombre'].'</th>
  <td><b>'.$row_inventario['gasolina'].'</b> <small>Galones</small></td>
  <td><b>'.$row_inventario['diesel'].'</b> <small>Galones</small></td></tr>';

  }
  ?>
  </tbody>
  </table>
  </div>


  </div> 

  </div>
  </div> 
  </div>

  </div>


  <!---------- MODAL ----------> 
  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content" id="ModalAgregar">
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
