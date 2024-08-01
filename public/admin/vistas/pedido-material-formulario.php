<?php
require('app/help.php');

$sql_pedido = "SELECT * FROM op_pedido_materiales WHERE id = '".$GET_idPedido."' ";
$result_pedido = mysqli_query($con, $sql_pedido);
$numero_pedido = mysqli_num_rows($result_pedido);
while($row_pedido = mysqli_fetch_array($result_pedido, MYSQLI_ASSOC)){
$folio = $row_pedido['folio'];
$id_estacion = $row_pedido['id_estacion'];
$fecha = $row_pedido['fecha'];
$estatus = $row_pedido['estatus'];
$tiposervicio = $row_pedido['tipo_servicio'];
$ordentrabajo = $row_pedido['orden_trabajo'];
$ordenriesgo = $row_pedido['orden_riesgo'];
} 

$sql_listaestacion = "SELECT razonsocial FROM tb_estaciones WHERE id = '".$id_estacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$razonsocial = $row_listaestacion['razonsocial'];
}

if($id_estacion == 9){
$razonsocialDesc = "Autolavado";
$DescripcionES = "¿EN QUE AFECTA AL AUTOLAVADO?";
$ocultarDivs = "d-none";

}else{
$razonsocialDesc = $razonsocial;
$DescripcionES = "¿EN QUE AFECTA A LA ESTACIÓN?";
$ocultarDivs = "";

}

function EvidenciaImagen($idEvidencia,$con){
$Contenido = "";

$sql = "SELECT id, imagen FROM op_pedido_materiales_evidencia_foto WHERE id_evidencia = '".$idEvidencia."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$id = $row['id'];
$imagen = $row['imagen'];

$Contenido .= '<iframe class="border-0 mt-1" src="'.RUTA_ARCHIVOS.$imagen.'" width="250px" height="250px"></iframe>
<img style="position: absolute;margin-left: -35;margin-top: 10px;" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarEvidenciaImagen('.$id.')">';
} 
 
return $Contenido;
}

function DetalleArea($id,$con){
$Result = "";

$sql = "SELECT * FROM op_pedido_materiales_area_otros WHERE id_area = '".$id."' AND estatus = 1 ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$Result .= '<small class="text-secondary">('.$row['sub_area'].')</small> '; 
}

return $Result;
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


  <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" ></script>
  <script type="text/javascript" src="<?php echo RUTA_JS ?>signature_pad.js"></script>
  <link rel="stylesheet" href="<?php echo RUTA_CSS ?>selectize.css">


  <script type="text/javascript">

  $(document).ready(function($){
  $(".LoaderPage").fadeOut("slow");

  
  });

 
function EditRC(idPedido,categoria,valor){

    if(categoria == 3){
    if (document.getElementById('Area' + idPedido).checked)
    {
    valor = 1;
    }else{
    valor = 0;
    }
    }else{
    valor = valor;
    }
 
    if(categoria == 5){
    if (document.getElementById('Dispensario' + idPedido).checked)
    {
    valor = 1;
    }else{
    valor = 0;
    }
    }else{
    valor = valor;
    }

    if(categoria == 6){
    if (document.getElementById('Tanques' + idPedido).checked)
    {
    valor = 1;
    }else{
    valor = 0;
    }
    }else{
    valor = valor;
    }

    if(categoria == 7){
    if (document.getElementById('BanosCliente' + idPedido).checked)
    {
    valor = 1;
    }else{
    valor = 0;
    }
    }else{
    valor = valor;
    }

    var parametros = {
    "idPedido" : idPedido,
    "categoria" : categoria,
    "valor" : valor
    };
   
    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/editar-pedido-materiales.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    if(categoria == 3 && response == 5){
    if(valor == 1){

    $('#Modal').modal('show');  
    $('#ContenidoModal').load('../../public/admin/vistas/modal-area-secciones.php?id=' + idPedido); 

    }else{
    location.reload();
    }
    }

    }
    });

}

function ModalAreaSeccion(id){
$('#Modal').modal('show');  
$('#ContenidoModal').load('../../public/admin/vistas/modal-area-secciones.php?id=' + id); 
}

function FinSubArea(){
location.reload(); 
}

function ModalArea(idPedido){
$('#Modal').modal('show');  
  $('#ContenidoModal').load('../../public/admin/vistas/modal-agregar-area-pedido-material.php?idPedido=' + idPedido);  
}  

function AgregarArea(idPedido){

  var Area = $('#Area').val();

    if(Area != ""){

    var parametros = {
    "idPedido" : idPedido,
    "Area" : Area,
    "categoria" : 4
    };

    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/editar-pedido-materiales.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    location.reload();

    }
    });

    }else{
    $('#Area').css('border','2px solid #A52525');  
    }
}


function ModalMateriales(idPedido){
$('#Modal').modal('show');  
$('#ContenidoModal').load('../../public/admin/vistas/modal-agregar-material-pedido-material.php?idPedido=' + idPedido);  

} 
 
function AgregarMaterial(idPedido){

var Concepto = $('#Concepto').val();
var Otro = $('#Otro').val();
var Cantidad = $('#Cantidad').val();

if(Cantidad != ""){
$('#Cantidad').css('border','');

    var parametros = {
    "idPedido" : idPedido,
    "Concepto" : Concepto,
    "Otro" : Otro,
    "Cantidad" : Cantidad
    };

    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/agregar-materiales-pedido-materiales.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    location.reload();

    }
    });

}else{
$('#Cantidad').css('border','2px solid #A52525');  
}

}

function EliminarMaterial(id){

    var parametros = {
    "id" : id,
    "categoria" : 2
    };

    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/eliminar-pedido-materiales.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    location.reload();

    }
    });

}

function ModalEvidencia(idPedido){
$('#Modal').modal('show');  
$('#ContenidoModal').load('../../public/admin/vistas/modal-agregar-evidencia-pedido-material.php?idPedido=' + idPedido);  
}  
 
function AgregarEvidencia(idPedido){

var ArchivoE = $('#archivoEvidencia').val();
var Area         =  $('#Area').val();
var Motivo       =  $('#Motivo').val();
 
  var data = new FormData();
  var url = '../../public/admin/modelo/agregar-evidencia-pedido-materiales.php';


if(ArchivoE != ""){
$('#archivoEvidencia').css('border','');
if(Area != ""){
$('#Area').css('border','');
if(Motivo != ""){
$('#Motivo').css('border','');


  Archivo = document.getElementById("archivoEvidencia");
  Archivo_file = Archivo.files[0];
  Archivo_filePath = Archivo.value;

 
   data.append('idPedido', idPedido);
   data.append('archivoEvidencia', Archivo_file);
   data.append('Area', Area);
   data.append('Motivo', Motivo);

 
    $.ajax({
    url: url,
    type: 'POST', 
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){
 
     if(data == 1){
      location.reload();

     }else{

      $(".LoaderPage").hide();
      alertify.error('Error al agregar evidencia'); 
     }
     
    });  



}else{
$('#Motivo').css('border','2px solid #A52525');  
}
}else{
$('#Area').css('border','2px solid #A52525');  
}
}else{
$('#archivoEvidencia').css('border','2px solid #A52525');  
}
    
}

function ModalEvidenciaImagen(idEvidencia){
$('#Modal').modal('show');  
$('#ContenidoModal').load('../../public/admin/vistas/modal-agregar-evidencia-imagen-pedido-material.php?idEvidencia=' + idEvidencia);  
}
 
function AgregarEvidenciaImagen(idEvidencia){

    var data = new FormData();
    var url = '../../public/admin/modelo/agregar-imagen-pedido-material.php';

    Imagen = document.getElementById("Imagen");
    Imagen_file = Imagen.files[0];
    Imagen_filePath = Imagen.value;

    if (Imagen_filePath != "") {
    $('#Imagen').css('border','');

    data.append('idEvidencia', idEvidencia);
    data.append('Imagen_file', Imagen_file);

    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){

       location.reload();
     
    }); 

    }else{
    $('#Imagen').css('border','2px solid #A52525');
    }
}

function EliminarEvidenciaImagen(idEvidencia){

    var parametros = {
    "id" : idEvidencia,
    "categoria" : 3
    };

    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/eliminar-pedido-materiales.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    location.reload();

    }
    });

}

function EliminarEvidencia(idEvidencia){
 
 var parametros = {
    "id" : idEvidencia,
    "categoria" : 4
    };

    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/eliminar-pedido-materiales.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    location.reload();

    }
    });
}
  
function Finalizar(idPedido){
 
var afectacionOM = $('#afectacionOM').val();

var ctx = document.getElementById("canvas");
var image = ctx.toDataURL();
document.getElementById('base64').value = image;

var Comentarios = $('#Comentarios').val();
var base64 = $('#base64').val();

var data = new FormData();
var url = '../../public/admin/modelo/finalizar-pedido-material.php';
    
  if (afectacionOM != "") {
   $('#afectacionOM').css('border','');
 
  if(signaturePad.isEmpty()){
  $('#canvas').css('border','2px solid #A52525'); 
  alertify.error('Falta llenar el campo de firma');
  }else{
  $('#canvas').css('border','1px solid #000000'); 

  data.append('idPedido', idPedido);
  data.append('afectacionOM', afectacionOM);
  data.append('Comentarios', Comentarios);
  data.append('base64', base64);
 
    $.ajax({
    url: url,
    type: 'POST',
    contentType: false,
    data: data,
    processData: false,
    cache: false
    }).done(function(data){

      history.back();
      
    }); 

  }

  }else{
  alertify.error('Falta llenar el campo de afectación');
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
  <div class="contendAG container">
  <div class="row">

  <div class="col-12">
  <div class="cardAG p-3"> 

  <div class="row">

  <div class="col-12 ">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Orden de Mantenimiento</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Formulario Orden de Mantenimiento</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-12"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Formulario Orden de Mantenimiento</h3></div>
  </div>
  <hr>
  </div>

  <!---------- INFORMACION FORMULARIO ---------->
  <div class="col-12 mb-3">
  <div class="table-responsive">

  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
    <th class="align-middle text-center">Razón social</th>
    <th class="align-middle text-center">Folio</th>
    <th class="align-middle text-center">Fecha</th>
  </tr>
  </thead>

  <tbody>
  <tr class="no-hover">
  <th class="align-middle text-center bg-light fw-normal"><?=$razonsocialDesc?></th>
  <th class="align-middle text-center bg-light fw-normal"><?=$folio?></th>
  <th class="align-middle text-center bg-light fw-normal"><?=$ClassHerramientasDptoOperativo->FormatoFecha($fecha)?></th>
  </tr>
  </tbody>
  </table>
  </div>
  </div>



  <!---------- APARTADO ¿EN QUE AFECTA A LA ESTACION? ---------->
  <div class="col-12 mb-3">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
    <th class="align-middle text-center"><?=$DescripcionES?></th>
  </tr>
  </thead>

  <tbody>
  <tr class="no-hover">
  <th class="align-middle text-center fw-normal p-0"><textarea class="form-control rounded-0 border-0 bg-light" id="afectacionOM" style="height: 150px;"></textarea></th>
  </tr>
  </tbody>
  </table>

  </table>
  </div>
  </div>

  <!---------- APARTADO TIPO DE SERVICIO ---------->
  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
  <th class="align-middle text-center" colspan="3">TIPO DE SERVICIO</th>
  </tr>
  </thead>

  <tbody class="bg-light">

  <tr>
  <td class="align-middle text-center no-hover2 p-2">
  <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="TipoServicio" id="Preventivo" value="1" onChange="EditRC(<?=$GET_idPedido;?>, 1, 1)" <?php if($tiposervicio == 1){echo 'checked';} ?> >
  <label class="form-check-label" for="Preventivo">PREVENTIVO</label>
  </div>
  </td>

  <td class="align-middle text-center no-hover2 p-2">
  <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="TipoServicio" id="Correctivo" value="2" onChange="EditRC(<?=$GET_idPedido;?>, 1, 2)" <?php if($tiposervicio == 2){echo 'checked';} ?>>
  <label class="form-check-label" for="Correctivo">CORRECTIVO</label>
  </div>
  </td>

  <td class="align-middle text-center no-hover2 p-2">
  <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="TipoServicio" id="Emergente" value="3" onChange="EditRC(<?=$GET_idPedido;?>, 1, 3)" <?php if($tiposervicio == 3){echo 'checked';} ?>>
  <label class="form-check-label" for="Emergente">EMERGENTE</label>
  </div>
  </td>

  </tr>

  </tbody>
  </table>
  </div>

  <!---------- LA ORDEN DE TRABAJO SE PUEDE ATENDER INTERNAMENTE ---------->
  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
  <th class="align-middle text-center" colspan="3">LA ORDEN DE TRABAJO SE PUEDE ATENDER INTERNAMENTE</th>
  </tr>
  </thead>

  <tbody class="bg-light">

  <tr>
  <td class="align-middle text-center no-hover2 p-2">
  <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="Trabajo" id="Si" value="1" onChange="EditRC(<?=$GET_idPedido;?>, 2, 1)" <?php if($ordentrabajo == 1){echo 'checked';} ?> >
  <label class="form-check-label" for="Si">SI</label>
  </div>
  </td>

  <td class="align-middle text-center no-hover2 p-2">
  <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="Trabajo" id="No" value="2" onChange="EditRC(<?=$GET_idPedido;?>, 2, 2)" <?php if($ordentrabajo == 2){echo 'checked';} ?> >
  <label class="form-check-label" for="No">NO</label>
  </div>
  </td>

  <td class="align-middle text-center no-hover2 p-2">
  <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="Trabajo" id="Ambas" value="3" onChange="EditRC(<?=$GET_idPedido;?>, 2, 3)" <?php if($ordentrabajo == 3){echo 'checked';} ?> >
  <label class="form-check-label" for="Ambas">AMBAS</label>
  </div>
  </td>

  </tr>

  </tbody>
  </table>
  </div>

  <!---------- LA ORDEN DE TRABAJO ES DE ALTO RIESGO ---------->
  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
  <th class="align-middle text-center" colspan="2">LA ORDEN DE TRABAJO ES DE ALTO RIESGO</th>
  </tr>
  </thead>

  <tbody class="bg-light">

  <tr>
  <td class="align-middle text-center no-hover2 p-2">
  <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="Riesgo" id="Si" value="1" onChange="EditRC(<?=$GET_idPedido;?>, 8, 1)" <?php if($ordenriesgo == 1){echo 'checked';} ?> >
  <label class="form-check-label" for="Si">SI</label>
  </div>
  </td>

  <td class="align-middle text-center no-hover2 p-2">
  <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="Riesgo" id="No" value="2" onChange="EditRC(<?=$GET_idPedido;?>, 8, 2)" <?php if($ordenriesgo == 2){echo 'checked';} ?> >
  <label class="form-check-label" for="No">NO</label>
  </div>
  </td>

  </tr>

  </tbody>
  </table>
  </div>

  <!---------- AREA ---------->
  <div class="col-12 mb-3 <?=$ocultarDivs?>">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
  <th class="align-middle text-center p-2">ÁREA</th>
  <th class="align-middle text-center p-2" width="20px"><button type="button" class="btn btn-success" onclick="ModalArea(<?=$GET_idPedido;?>)"><i class="fa-solid fa-plus"></i></span></th>

  </tr>
  </thead>

  <tbody class="bg-light">


  <?php  
  $sql_lista = "SELECT * FROM op_pedido_materiales_area WHERE id_pedido = '".$GET_idPedido."' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);

  if ($numero_lista > 0) {
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
  $id  = $row_lista['id'];

  if($row_lista['estatus'] == 1){
  $checked = 'checked';
  if($row_lista['area'] == 'Zona de despacho' || $row_lista['area'] == 'Zona de tanques' || $row_lista['area'] == 'Baños clientes'){

  $EditArea = '<img class="float-end pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="ModalAreaSeccion('.$id.')">';
  $SADetalle = DetalleArea($id,$con);
  
  }else{
  $EditArea = '';
  $SADetalle = '';
  } 

  }else{
  $checked = '';
  $EditArea = '';
  $SADetalle = '';
  }

  echo '<tr>
  <th class="align-middle text-start no-hover2 fw-normal">'.$row_lista['area'].' '.$SADetalle.' '.$EditArea.'</th>
  <td class="align-middle text-center no-hover2"><input style="width: 12px; height: 12px; transform: scale(1.5);" type="checkbox" '.$checked.' id="Area'.$id.'" onChange="EditRC('.$id.', 3, 0)"></td>  
  </tr>';
  }
  }else{
  echo "<tr><th colspan='6' class='text-center text-secondary no-hover2 fw-normal'>No se encontró información para mostrar</th></tr>";  
  }
  ?>

  </tbody>
  </table>
  </div>
  </div>

  <!---------- REFACCIONES ---------->
  <div class="col-12 mb-3">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
  <th class="align-middle text-center p-2" colspan="3">REFACCIONES</th>
  <th class="align-middle text-center p-2" width="20px"><button type="button" class="btn btn-success" onclick="ModalMateriales(<?=$GET_idPedido;?>)"><i class="fa-solid fa-plus"></i></span></th>
  </tr>

  <tr class="title-table-bg">
  <td class="fw-bold align-middle">REFACCIÓN</td>
  <th class="text-center align-middle">CANTIDAD</th>
  <th class="text-center align-middle">ESTATUS</th>
  <td class="text-center align-middle"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></td>
  </tr>

  </thead>

  <tbody class="bg-light">
  <?php  
  $sql_detalle = "SELECT * FROM op_pedido_materiales_detalle WHERE id_pedido = '".$GET_idPedido."' ";
  $result_detalle = mysqli_query($con, $sql_detalle);
  $numero_detalle = mysqli_num_rows($result_detalle);
  if ($numero_detalle > 0) {
  while($row_detalle = mysqli_fetch_array($result_detalle, MYSQLI_ASSOC)){

  $id  = $row_detalle['id'];

  echo '<tr>
  <th class="fw-normal no-hover2">'.$row_detalle['concepto'].'</th>
  <td class="text-center no-hover2">'.$row_detalle['cantidad'].'</td>
  <td class="text-center no-hover2">'.$row_detalle['nota'].'</td>
  <td class="align-middle text-center no-hover2" width="30"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarMaterial('.$id.')"></td>
  </tr>';
  }
  }else{
  echo "<tr><th colspan='6' class='text-center text-secondary no-hover2 fw-normal'>No se encontró información para mostrar</th></tr>";  
  }
  ?>

  </tbody>
  </table>
  </div>
  </div>

  <!---------- EVIDENCIA ---------->
  <div class="col-12 mb-3">
  <div class="table-responsive">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> 
  <th class="align-middle text-center p-2" colspan="3">EVIDENCIA</th>
  <th class="align-middle text-center p-2" width="20px"><button type="button" class="btn btn-success" onclick="ModalEvidencia(<?=$GET_idPedido;?>)"><i class="fa-solid fa-plus"></i></span></th>
  </tr>

  <tr class="title-table-bg">
  <td class="fw-bold align-middle" width="20px">ARCHIVO</td>
  <th class="text-center align-middle">ÁREA</th>
  <th class="text-center align-middle">MOTIVO</th>
  <td class="text-center align-middle"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></td>
  </tr>

  </thead>

  <tbody class="bg-light">
  <?php  

  $sql_evidencia = "SELECT * FROM op_pedido_materiales_evidencia_archivo WHERE id_pedido = '".$GET_idPedido."' ";

  $result_evidencia = mysqli_query($con, $sql_evidencia);
  $numero_evidencia = mysqli_num_rows($result_evidencia);

  if ($numero_evidencia > 0) {
  while($row_evidencia = mysqli_fetch_array($result_evidencia, MYSQLI_ASSOC)){
  $idEvidencia = $row_evidencia['id'];

  echo'
  
  <tr>
  <td class="align-middle text-center no-hover2"> 
  <a class="pointer" href="../../archivos/material-evidencia/'.$row_evidencia['archivo'].'" download><img src="'.RUTA_IMG_ICONOS.'pdf.png"></a>
  </td> 
  <td class="align-middle text-center no-hover2">'.$row_evidencia['area'].'</td>
  <td class="align-middle text-center no-hover2">'.$row_evidencia['motivo'].'</td>
  <td class="align-middle text-center no-hover2"><img src="'.RUTA_IMG_ICONOS.'eliminar.png" class="pointer" onclick="EliminarEvidencia('.$idEvidencia.')"></td>
  </tr>';


  /*
  echo '<div class="border p-3 mt-3 mb-3">';

  echo '<div class="row">
  <div class="col-12"><button type="button" class="btn btn-sm btn-secondary rounded-0 float-end" onclick="ModalEvidenciaImagen('.$idEvidencia.')">Imagen</button>
  </div>
  </div>

  <hr>';

  echo '<div>'.EvidenciaImagen($idEvidencia,$con).'</div>';

  echo '</div>';
  */

  }
  }else{
  echo "<tr><th colspan='6' class='text-center text-secondary no-hover2 fw-normal'>No se encontró información para mostrar</th></tr>";  
  }
  ?>

  </tbody>
  </table>
  </div>
  </div>


  <!---------- COMENTARIO ---------->
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">COMENTARIOS</th> </tr>
  </thead>
  <tbody>
  <tr class="no-hover">
  <th class="align-middle text-center p-0 "><textarea class="form-control rounded-0 border-0 bg-light" id="Comentarios" style="height: 185px;"></textarea>
  </th>
  </tr>
  </tbody>
  </table>
  </div>


  <!---------- FIRMA ---------->
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
  <table class="custom-table" style="font-size: 14px;" width="100%">
  <thead class="tables-bg">
  <tr> <th class="align-middle text-center">FIRMA DEL ENCARGADO</th> </tr>
  </thead>
  <tbody>
  <tr>
  <th class="align-middle text-center p-0 no-hover2">          
  <div id="signature-pad" class="signature-pad ">
  <div class="signature-pad--body ">
  <canvas style="width: 100%; height: 150px; border-right: .1px solid #215d98; border-left: .1px solid #215d98; cursor: crosshair;" id="canvas"></canvas>
  </div>
  <input type="hidden" name="base64" value="" id="base64">
  </div> 
  </th>
  </tr>

  <tr>
  <th class="align-middle text-center p-2 bg-danger text-white" onclick="resizeCanvas()">  
  <i class="fa-solid fa-arrow-rotate-left"></i> Limpiar firma        
  </th>
  </tr>

  </tbody>
  </table>
  </div>


  <div class="col-12 pt-0 mt-0">
  <hr>
  <button type="button" class="btn btn-labeled2 btn-success float-end" onclick="Finalizar(<?=$GET_idPedido;?>)">
  <span class="btn-label2"><i class="fa fa-check"></i></span>Finalizar</button>
  </div>



  </div>

  </div>
  </div>
  </div>
  </div>

  <!---------- MODAL ----------> 
  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <div class="modal-content" id="ContenidoModal">
  </div>
  </div>
  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>
  <script src="<?=RUTA_JS2 ?>signature-pad-functions.js"></script>

</body>
</html>
