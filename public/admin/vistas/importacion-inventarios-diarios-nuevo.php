<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

$sql_lista = "SELECT * FROM op_inventarios_diarios WHERE id = '".$GET_idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$fecha = $row_lista['fecha'];
}

  function Detalle($idReporte,$detalle,$con){
 
  $contenido = "";

  $contenido .= '<div class="table-responsive">';
  $contenido .= '<table class="custom-table" style="font-size: 12.5px;" width="100%">

  <thead class="tables-bg">
  <tr>
  <th class="font-weight-bold align-middle text-center" colspan="6">INVENTARIOS REALES</th>
  </tr>

  <tr class="title-table-bg">
  <td class="fw-bold align-middle text-center">Sucursal</td>
  <th class="font-weight-bold align-middle text-center" width="150">Destino</th>
  <th class="font-weight-bold align-middle text-center" width="150">87 Oct</th>
  <th class="font-weight-bold align-middle text-center" width="150">91 Oct</th>
  <th class="font-weight-bold align-middle text-center" width="150">Diesel</th>
  <td class="align-middle text-center" width="24"><img class="pr-2" src="'.RUTA_IMG_ICONOS.'eliminar.png"></td>
  </tr>
  </thead>';
  $contenido .= '<tbody class="bg-light">';
  $sql_lista = "SELECT * FROM op_inventarios_diarios_detalle WHERE id_reporte = '".$idReporte."' AND detalle = '".$detalle."' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);
  if ($numero_lista > 0) {
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

  $id = $row_lista['id'];

  if($row_lista['destino'] == 0){
  $destino = "";
  }else{
  $destino = $row_lista['destino'];  
  }

  if($row_lista['oct87'] == 0){
  $oct87 = "";
  }else{
  $oct87 = $row_lista['oct87'];  
  }

  if($row_lista['oct91'] == 0){
  $oct91 = "";
  }else{
  $oct91 = $row_lista['oct91'];  
  }

  if($row_lista['diesel'] == 0){
  $diesel = "";
  }else{
  $diesel = $row_lista['diesel'];  
  }

  $contenido .= '<tr>';
  $contenido .= '<th class="align-middle text-center no-hover2"><b>'.$row_lista['sucursal'].'</b></th>';
  $contenido .= '<td class="align-middle text-center no-hover2">'.$destino.'</td>';
  $contenido .= '<td class="p-0 align-middle text-center"><input type="number" value="'.$oct87.'" class="form-control border-0 rounded-0 align-middle text-center p-3 bg-light" oninput="EditarDestino(this,2,'.$id.')"></td>';
  $contenido .= '<td class="p-0 align-middle text-center"><input type="number" value="'.$oct91.'" class="form-control border-0 rounded-0 align-middle text-center p-3 bg-light" oninput="EditarDestino(this,3,'.$id.')"></td>';
  $contenido .= '<td class="p-0 align-middle text-center"><input type="number" value="'.$diesel.'" class="form-control border-0 rounded-0 align-middle text-center p-3 bg-light" oninput="EditarDestino(this,4,'.$id.')"></td>';
  $contenido .= '<td class="align-middle text-center no-hover2" width="24"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$id.')"></td>';
  $contenido .= '</tr>';
  }
  }else{
  $contenido .= '<tr>';
  $contenido .= '<tr>
  <td colspan="5" class="text-center text-secondary"><small>No se encontró información para mostrar</small></td>
  </tr>';
  $contenido .= '</tr>'; 
  }
  $contenido .= '</tbody></table>';
  $contenido .= '</div>';
  return $contenido;
  }

  $Detalle1 = Detalle($GET_idReporte,'INVENTARIOS REALES',$con);
  $Detalle2 = Detalle($GET_idReporte,'CAPACIDAD ALMACENAJE',$con);
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
  
  });

  function Regresar(){
   window.history.back();
  }

  function EditarDestino(e,tipo,id){
  var valor = e.value;

  var parametros = {
  "id": id,
  "valor": valor,
  "tipo" : tipo
  };

    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/editar-importacion-inventario-diario.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
  
    }else{
    alertify.error('Error al editar');  
    }

    }
    });
  }

   function Nuevo(idReporte){
   $('#Modal').modal('show');  
   $('#DivContenido').load('../../public/admin/vistas/modal-nuevo-inventarios-diarios.php?idReporte=' + idReporte);
   }
 
   function Guardar(idReporte){

  
  var Destino1 = $('#Destino1').val();
  var Oct871 = $('#Oct871').val();
  var Oct911 = $('#Oct911').val();
  var Diesel1 = $('#Diesel1').val();
  var Sucursal = $('#Sucursal').val();
  var Destino2 = $('#Destino2').val();
  var Oct872 = $('#Oct872').val();
  var Oct912 = $('#Oct912').val();
  var Diesel2 = $('#Diesel2').val();

  var parametros = {
  "idReporte" : idReporte,
  "Sucursal": Sucursal,
  "Destino1": Destino1,
  "Oct871": Oct871,
  "Oct911": Oct911,
  "Diesel1": Diesel1,
  "Destino2": Destino2,
  "Oct872": Oct872,
  "Oct912": Oct912,
  "Diesel2": Diesel2
  };

  if(Sucursal != ""){
  $('#Sucursal').css('border',''); 

 alertify.confirm('',
 function(){

    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/agregar-sucursal-inventario-diario.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    location.reload();
    }else{
    alertify.error('Error al agregar');  
    }

    }
    });

   },
   function(){

   }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea agregar la siguiente información?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

  }else{
  $('#Sucursal').css('border','2px solid #A52525'); 
  }

  }

  function Finalizar(idReporte){
  var Fecha = $('#Fecha').val();

  var parametros = {
  "idReporte" : idReporte,
  "Fecha": Fecha
  };

  if(Fecha != ""){
  $('#Fecha').css('border',''); 

 alertify.confirm('',
 function(){

    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/finalizar-importacion-inventario-diario.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if (response == 1) {
    Regresar()
    }else if (response == 0){
    alertify.error('Error al finalizar');  
    }else if (response == 2){
    alertify.error('Error en la fecha del inventario');  
    $('#Fecha').css('border','2px solid #A52525');
    }

    }
    });

   },
   function(){

   }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea finalizar el inventario?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

  }else{
  $('#Fecha').css('border','2px solid #A52525'); 
  }

  }
  
  function Eliminar(id){

  var parametros = {
  "idReporte" : id
  };

  alertify.confirm('',
  function(){

    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/eliminar-destino-inventario-diario.php',
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

   }).setHeader('Mensaje').set({transition:'zoom',message: '¿Desea eliminar la siguiente información?',labels:{ok:'Aceptar', cancel: 'Cancelar'}}).show();

  }

  </script>
  </head>

<body class="bodyAG"> 
<div class="LoaderPage"></div>


  <!---------- DIV - CONTENIDO ----------> 
  <div id="content">
  <!---------- NAV BAR - PRINCIPAL (TOP) ---------->  
  <?php include_once "public/navbar/navbar-perfil.php";?>
  <!---------- CONTENIDO PAGINA WEB----------> 
  <div class="contendAG container">
  <div class="row">

  <div class="col-12 mb-3">
  <div class="cardAG">
  <div class="border-0 p-3 ">
  <div class="row">

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Inventarios diarios  </a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Formulario Inventatios Diarios</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Formulario Inventatios Diarios</h3>
  </div>

  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
  <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="Nuevo(<?=$GET_idReporte;?>)">
  <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
  </div>

  </div>

  <hr>
  </div>


  <div class="col-12">
  <div class="row">

  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
  <label class="mb-1 text-secondary fw-bold">* FECHA:</label>
  <input type="date" class="form-control" id="Fecha" value="<?=$fecha;?>">
  </div>

  <div class="col-12">
  <?=$Detalle1;?>
  </div>

  </div>
  </div>

  <div class="col-12">
  <hr>
  <button type="button" class="btn btn-labeled2 btn-success float-end" onclick="Finalizar(<?=$GET_idReporte;?>)">
  <span class="btn-label2"><i class="fa fa-check"></i></span>Finalizar inventario</button>
  </div>
  </div>

  </div>
  </div>
  </div>

  </div>
  </div>

  </div>



  <!---------- MODAL ----------> 
  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="DivContenido">
  </div>
  </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>navbar-functions.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
