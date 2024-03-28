<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

$GET_idReporte;
   
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
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?=RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow"); 
  ListaPivoteo(<?=$GET_idReporte;?>);
  });
  
  function Regresar(){
  window.history.back();
  }

  function ListaPivoteo(idReporte){
  $('#ListaPivoteo').load('../public/corte-diario/vistas/lista-pivoteo-detalle.php?idReporte=' + idReporte);  
  }

  function Nuevo(idReporte){
  $('#Modal').modal('show');  
  $('#DivContenido').load('../public/corte-diario/vistas/modal-editar-pivoteo.php?idReporte=' + idReporte);
  }

  function Guardar(idReporte){

  let Producto = $('#Producto').val();
  let Litros = $('#Litros').val();
  let Tanque = $('#Tanque').val();
  let TAD = $('#TAD').val();
  let Unidad = $('#Unidad').val();
  let Chofer = $('#Chofer').val();

  if(Producto != ""){
  $('#Producto').css('border',''); 
  if(Litros != ""){
  $('#Litros').css('border',''); 
  if(Tanque != ""){
  $('#Tanque').css('border',''); 
  if(TAD != ""){
  $('#TAD').css('border',''); 
  if(Unidad != ""){
  $('#Unidad').css('border',''); 
  if(Chofer != ""){
  $('#Chofer').css('border','');
 

  var parametros = {
    "idReporte" : idReporte,
    "Producto" : Producto,
    "Litros" : Litros,
    "Tanque" : Tanque,
    "TAD" : TAD,
    "Unidad" : Unidad,
    "Chofer" : Chofer
    };

    $.ajax({
    data:  parametros,
    url:   '../public/corte-diario/modelo/agregar-pivoteo-detalle.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    ListaPivoteo(idReporte)

    $('#Producto').val('');
    $('#Litros').val('');
    $('#Tanque').val('');
    alertify.success('Pedido agregado exitosamente');

    }else{
    alertify.error('Error al agregar');
    }

    }
    });


}else{
$('#Chofer').css('border','2px solid #A52525'); 
}
}else{
$('#Unidad').css('border','2px solid #A52525'); 
}
}else{
$('#TAD').css('border','2px solid #A52525'); 
}
}else{
$('#Tanque').css('border','2px solid #A52525'); 
}
}else{
$('#Litros').css('border','2px solid #A52525'); 
}
}else{
$('#Producto').css('border','2px solid #A52525'); 
}

}

function Finalizar(idReporte){


 var parametros = {
    "idReporte" : idReporte
    };

    $.ajax({
    data:  parametros,
    url:   '../public/corte-diario/modelo/finalizar-pivoteo-detalle.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

 
    if (response == 1) {
    Regresar();

    }else{
    alertify.error('Error al eliminar el pedido');
    }

    }
    });

}

function Eliminar(idReporte,id){
    var parametros = {
    "id" : id
    };

 alertify.confirm('',
 function(){

      $.ajax({
    data:  parametros,
    url:   '../public/corte-diario/modelo/eliminar-pivoteo-detalle.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

 
    if (response == 1) {
    ListaPivoteo(idReporte)
     alertify.success('Pedido eliminado exitosamente');
    }else{
    alertify.error('Error al eliminar el pedido');
    }

    }
    });

 },
 function(){

 }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la información seleccionada?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();
}

//--------------------------------------------------

function ValidaLitros(e){

let Litros = e.value;

if(Litros > 23000){
$('#Tanque').val('Tanque 2');
}else{
$('#Tanque').val('Tanque 1');
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
    <div class="col-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

     <h5>Pivoteo editar</h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

   
<div class="row">
 
  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-3">
    
  <div class="border p-3">

<div><b>Producto:</b></div>
<select class="form-select mb-2" id="Producto">
  <option></option>
  <option>87 OCTANOS</option>
  <option>91 OCTANOS</option>
  <option>DIESEL</option>
</select>

<div><b>Litros:</b></div>
<input type="number" class="form-control mb-2" id="Litros">

<div><b>Tanque:</b></div>
<div id="ResulTanque"></div>
<select class="form-select mb-2" id="Tanque">
  <option></option>
  <option>Pipa</option>
  <option>Tanque 1</option>
  <option>Tanque 2</option>
</select>

<div><b>TAD:</b></div>
<select class="form-select mb-2" id="TAD">
    <option></option>
    <option>Atlacomulco</option>
    <option>Tizayuca</option>
    <option>Tuxpan</option>
    <option>Puebla</option>
    <option>Vopack</option>
    </select>
  



    <div><b>Unidad:</b></div>
    <select class="form-select mb-2" id="Unidad">
    <option></option>

    <?php
    $sql_unidades = "SELECT no_unidad FROM tb_unidades_transporte WHERE estado = 0 ORDER BY no_unidad ASC";
    $result_unidades = mysqli_query($con, $sql_unidades);
    $numero_unidades = mysqli_num_rows($result_unidades); 

    while($row_unidades = mysqli_fetch_array($result_unidades, MYSQLI_ASSOC)){
    $no_unidad = $row_unidades['no_unidad'];

    echo '<option>'.$no_unidad.'</option>';
    }

    ?>
 
  
    </select>
 
    <div><b>Chofer:</b></div>
    <select class="form-select mb-2" id="Chofer">
    <option></option>

    <?php
    $sql_chofer = "SELECT nombre_chofer FROM tb_pivoteo_chofer WHERE estado = 0 ORDER BY nombre_chofer ASC";
    $result_chofer = mysqli_query($con, $sql_chofer);
    $numero_chofer = mysqli_num_rows($result_chofer); 

    while($row_chofer = mysqli_fetch_array($result_chofer, MYSQLI_ASSOC)){
    $nombre_chofer = $row_chofer['nombre_chofer'];

    echo '<option>'.$nombre_chofer.'</option>';
    }

    ?>
 

    </select>

    <hr>

    <div class="text-end">
    <button type="button" class="btn btn-primary " onclick="Guardar(<?=$GET_idReporte;?>)">Guardar</button>
    </div>

  </div>

  </div>

  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
  <div id="ListaPivoteo"></div>
  </div>

  </div>

<hr>
<div class="text-end">
<button type="button" class="btn btn-success" onclick="Finalizar(<?=$GET_idReporte;?>)">Finalizar</button>
</div>

  

  </div>
  </div>
  </div>

  </div>
  </div>

  </div>




    <div class="modal" id="Modal">
    <div class="modal-dialog">
      <div class="modal-content" style="margin-top: 83px;">
      <div id="DivContenido"></div>
      </div>
    </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
