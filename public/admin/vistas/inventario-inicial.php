<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$GET_idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
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
  <link href="<?=RUTA_CSS2;?>navbar-general.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");
    
    InventarioLista(<?=$GET_idMes;?>);
    });


  function Regresar(){
   window.history.back();

  }

  function InventarioLista(idMes){
  $('#ListaInventario').load('../../../public/admin/vistas/lista-inventario-inicial.php?idMes=' + idMes);
  }

function ModalNuevo(){
$('#Modal').modal('show');
}
 
function GuardarInventario(idEstacion, idMes){

var Aceite = $('#Aceite').val();
var Exhibidores = $('#Exhibidores').val();
var Inventario = $('#Inventario').val();

if (Aceite != "") {
$('#Aceite').css('border','');
if (Exhibidores != "") {
$('#Exhibidores').css('border','');
if (Inventario != "") {
$('#Inventario').css('border','');

  var parametros = {
    "idEstacion" : idEstacion,
    "idMes" : idMes,
    "Aceite" : Aceite,
    "Exhibidores" : Exhibidores,
    "Inventario" : Inventario
    };

       $.ajax({
     data:  parametros,
     url:   '../../../public/admin/modelo/agregar-inventario-inicial.php',
     type:  'post',
     beforeSend: function() {
     },
     complete: function(){

     },
     success:  function (response) {

     if (response == 1) {
      InventarioLista(idMes);

$('#Exhibidores').val('');
$('#Inventario').val('');
     }

     }
     });

}else{
$('#Inventario').css('border','2px solid #A52525');  
}
}else{
$('#Exhibidores').css('border','2px solid #A52525');  
}
}else{
$('#Aceite').css('border','2px solid #A52525');  
}


}
 
  </script>
  </head>

<body> 
<div class="LoaderPage"></div>




  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
  <?php include_once "public/navbar/navbar-perfil.php";?>
  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG">
  <div class="row">

  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3">


    <div class="row">

    <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    <div class="row">

     <div class="col-12">

      <h5>
      Inventario inicial <?=$estacion;?> 
      </h5>

    </div>

    </div>

    </div>


    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12">
    <img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="ModalNuevo()">
    </div>

    </div>

  <hr>

   <div id="ListaInventario"></div>

  </div>
  </div>
  </div>

  </div>
  </div>

  </div>



<div class="modal" id="Modal">
  <div class="modal-dialog" style="margin-top: 83px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar inventario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
      </div>
      <div class="modal-body">
        
      <select class="form-select" id="Aceite">
      <?php 
$sql_listaaceites = "SELECT id, id_aceite, concepto FROM op_aceites ORDER BY id_aceite ASC";
$result_listaaceites = mysqli_query($con, $sql_listaaceites);
while($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)){

echo "<option value='".$row_listaaceites['id']."'>".$row_listaaceites['id_aceite']." ".$row_listaaceites['concepto']."</option>";
}
      ?>
      </select>

      <input type="number" id="Exhibidores" class="form-control mt-2" placeholder="Exhibidores">
      <input type="number" id="Inventario" class="form-control mt-2" placeholder="Inventario bodega">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="GuardarInventario(<?=$GET_idEstacion;?>,<?=$GET_idMes;?>)">Guardar</button>
      </div>
    </div>
  </div>
</div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>


