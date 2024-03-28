<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

$sql_pedido = "SELECT * FROM op_pedido_materiales WHERE id = '".$GET_idPedido."' ";
$result_pedido = mysqli_query($con, $sql_pedido);
$numero_pedido = mysqli_num_rows($result_pedido);
while($row_pedido = mysqli_fetch_array($result_pedido, MYSQLI_ASSOC)){
$folio = $row_pedido['folio'];
$id_estacion = $row_pedido['id_estacion'];
$fecha = $row_pedido['fecha'];
$afectacion = $row_pedido['afectacion'];
$estatus = $row_pedido['estatus'];
$tiposervicio = $row_pedido['tipo_servicio'];
$ordentrabajo = $row_pedido['orden_trabajo'];
$ordenriesgo = $row_pedido['orden_riesgo'];
$comentarios = $row_pedido['comentarios'];
}
 
$sql_listaestacion = "SELECT razonsocial FROM tb_estaciones WHERE id = '".$id_estacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$razonsocial = $row_listaestacion['razonsocial'];
}

function EvidenciaImagen($idEvidencia,$con){
 

$sql = "SELECT id, imagen FROM op_pedido_materiales_evidencia_foto WHERE id_evidencia = '".$idEvidencia."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$id = $row['id'];
$imagen = $row['imagen'];

$Contenido .= '
 <iframe class="border-0 mt-1" src="'.RUTA_ARCHIVOS.$imagen.'" width="250px" height="250px">
  </iframe>';
}

return $Contenido;
}

function Personal($idusuario,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
}

function FirmaSC($idReporte,$tipoFirma,$con){
$sql_lista = "SELECT * FROM op_pedido_materiales_firma WHERE id_pedido = '".$idReporte."' AND tipo_firma = '".$tipoFirma."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
}

$firmaB = FirmaSC($GET_idPedido,'B',$con);
$firmaC = FirmaSC($GET_idPedido,'C',$con);

function DetalleArea($id,$con){

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

  function Regresar(){
  window.history.back();
  }

    function CrearToken(idReporte){
    $(".LoaderPage").show();

    var parametros = {
    "idReporte" : idReporte
    };

    $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/token-pedido-material.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

    $(".LoaderPage").hide();

   if(response == 1){
     alertify.message('El token fue enviado por mensaje');   
   }else{
     alertify.error('Error al crear el token');   
   }

    }
    });

    }

    function FirmarSolicitud(idReporte,tipoFirma){

    var TokenValidacion = $('#TokenValidacion').val();

    var parametros = {
    "idReporte" : idReporte,
    "tipoFirma" : tipoFirma,
    "TokenValidacion" : TokenValidacion
    };

  if(TokenValidacion != ""){
  $('#TokenValidacion').css('border',''); 
 
    $(".LoaderPage").show();

      $.ajax({
    data:  parametros,
    url:   '../../public/admin/modelo/firmar-pedido-materiales.php',
    type:  'post',
    beforeSend: function() {
    },
    complete: function(){

    },
    success:  function (response) {

      $(".LoaderPage").hide();

    if(response == 1){

    $('#ModalFinalizado').modal('show'); 

    }else{
     $('#ModalError').modal('show');
     alertify.error('Error al firmar el pedido');
    }

    }
    });

  }else{
  $('#TokenValidacion').css('border','2px solid #A52525'); 
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

     <h5>Firmar Orden de Mantenimiento</h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>


<div class="container">

<div class="table-responsive">
 <table class="table table-bordered">
    <tr>
      <td class="align-middle"><b>Razón social:</b> <br><?=$razonsocial;?></td>
      <td class="align-middle"><b>Folio:</b><br> 00<?=$folio;?></td>
      <td class="align-middle"><b>Fecha:</b> <br><?=FormatoFecha($fecha);?></td>
    </tr>
  </table>
</div>


<div class="border p-3 mb-3">
  
  <h6>¿EN QUE AFECTA A LA ESTACIÓN?</h6>
  <hr>

  <label><?=$afectacion;?></label>

  </div>


  <div class="border p-3 mb-3 d-none ">
  
  <h6>TIPO DE SERVICIO</h6>
  <hr>

  <div class="row">
<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2 text-center"> 
  PREVENTIVO <?php if($tiposervicio == 1){echo '<br>
  <img class="pr-2" src="'.RUTA_IMG_ICONOS.'icon-check.png" >';} ?> </div>

<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2 text-center">CORRECTIVO <?php if($tiposervicio == 2){echo '<br>
<img class="pr-2" src="'.RUTA_IMG_ICONOS.'icon-check.png" >';} ?></div>

<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2 text-center">EMERGENTE <?php if($tiposervicio == 3){echo '<br>
<img class="pr-2" src="'.RUTA_IMG_ICONOS.'icon-check.png" >';} ?></div>
  </div>
  </div>


  <div class="border p-3 mb-3 ">
    <h6>LA ORDEN DE TRABAJO SE PUEDE ATENDER INTERNAMENTE</h6>
    <hr>

    <div class="row">

<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2 text-center"> SI <?php if($ordentrabajo == 1){echo '<img class="pr-2" src="'.RUTA_IMG_ICONOS.'icon-check.png" >';} ?></div>

<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2 text-center"> NO <?php if($ordentrabajo == 2){echo '<img class="pr-2" src="'.RUTA_IMG_ICONOS.'icon-check.png" >';} ?></div>

<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2 text-center"> AMBAS <?php if($ordentrabajo == 3){echo '<img class="pr-2" src="'.RUTA_IMG_ICONOS.'icon-check.png" >';} ?></div>
  </div>
</div>


  <div class="border p-3 ">
<h6>LA ORDEN DE TRABAJO ES DE ALTO RIESGO</h6>    <hr>

    <div class="row justify-content-center">

<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2 text-center"> SI <?php if($ordenriesgo == 1){echo '<img class="pr-2" src="'.RUTA_IMG_ICONOS.'icon-check.png" >';} ?></div>

<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-2 text-center"> NO <?php if($ordenriesgo == 2){echo '<img class="pr-2" src="'.RUTA_IMG_ICONOS.'icon-check.png" >';} ?></div>

  </div>
</div>


<div class="table-responsive">
  <table class="table table-bordered table-sm mt-3">
  <thead class="tables-bg">
  <tr>
    <th class="text-center">ÁREA</th>
        <th class="text-center p-0 m-0" width="30"></th>
  </tr>
  </thead>
  <tbody>
  <?php  
  $sql_lista = "SELECT * FROM op_pedido_materiales_area WHERE id_pedido = '".$GET_idPedido."' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

    $id  = $row_lista['id'];

    if($row_lista['estatus'] == 1){
    $checked = '<img class="pr-2" src="'.RUTA_IMG_ICONOS.'icon-check.png" >';
    $SADetalle = DetalleArea($id,$con);
    }else{
    $checked = '';
    $SADetalle = '';
    }

  echo '<tr>
       <td>'.$row_lista['area'].' '.$SADetalle.'</td>
       <td class="align-middle text-center">'.$checked.'</td>
       </tr>';

  }
  ?>
  </tbody>
</table>
</div>


<div class="border p-3 mb-3">
<h6>REFACCIONES</h6>

<hr>

<div class="table-responsive">
<table class="table table-bordered table-sm mb-0" style="margin-top: 5px;">
  <thead class="tables-bg">
  <tr>
    <th class="">REFACCIÓN</th>    
    <th class="text-center">CANTIDAD</th>
    <th class="">ESTATUS</th>
  </tr>
  </thead>
  <tbody>
  <?php  
  $sql_detalle = "SELECT * FROM op_pedido_materiales_detalle WHERE id_pedido = '".$GET_idPedido."' ";
  $result_detalle = mysqli_query($con, $sql_detalle);
  $numero_detalle = mysqli_num_rows($result_detalle);
  if ($numero_detalle > 0) {
  while($row_detalle = mysqli_fetch_array($result_detalle, MYSQLI_ASSOC)){

    $id  = $row_detalle['id'];

       echo '<tr>
       <td>'.$row_detalle['concepto'].'</td>
       <td class="text-center">'.$row_detalle['cantidad'].'</td>
       <td>'.$row_detalle['nota'].'</td>
       </tr>';
  }
  }else{
  echo "<tr><td colspan='6' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";  
  }
  ?>
  </tbody>
</table>
</div>

</div>

<div class="p-3 border mb-3">

      <div class="row">

      <div class="col-12 mt-2">
        <h6>EVIDENCIA</h6>
      </div>

    </div>

<hr>


<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 ">
        <thead>
        <tr class="tables-bg">
        <th class="align-middle text-center" width="20" >ARCHIVO</th>
        <th class="align-middle text-center">AREA</th>
        <th class="align-middle text-center">MOTIVO</th>
                </tr>
        </thead>
  
<?php  

  $sql_evidencia = "SELECT * FROM op_pedido_materiales_evidencia_archivo WHERE id_pedido = '".$GET_idPedido."' ";

  
  $result_evidencia = mysqli_query($con, $sql_evidencia);
  $numero_evidencia = mysqli_num_rows($result_evidencia);
  while($row_evidencia = mysqli_fetch_array($result_evidencia, MYSQLI_ASSOC)){
  
  $idEvidencia = $row_evidencia['id'];

echo'
       
        <tr>
        <td class="align-middle text-center"> 
        <a class="pointer" href="'.RUTA_ARCHIVOS.'material-evidencia/'.$row_evidencia['archivo'].'" download><img src="'.RUTA_IMG_ICONOS.'descargar.png"></a>
        </td> 
        <td class="align-middle text-center">'.$row_evidencia['area'].'</td>
        <td class="align-middle text-center">'.$row_evidencia['motivo'].'</td>
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
  ?>

</table>
</div>
</div>






<div class="border p-3 mb-3">
<h6>COMENTARIOS</h6>
<hr>
<div class="border p-2"><?=$comentarios;?></div>
</div>



<div class="border p-3 mb-3">
  <h6>FIRMAS</h6>
  <hr>


<div class="row">
<?php  


if($Session_IDUsuarioBD == 21){
if($firmaB == 0){
?>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
<div class="border p-3 mt-3">
<div class="mb-2 text-secondary text-center">FIRMA DE VOBO</div>
<h4 class="text-primary">Token Móvil</h4>
<small class="text-secondary">Agregue el token enviado a su número de teléfono o de clic en el siguiente botón para crear uno</small>
<button class="btn btn-sm btn-light" onclick="CrearToken(<?=$GET_idPedido;?>)"><small>Crear token</small></button>
<div class="input-group mt-3">
  <input type="text" class="form-control" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="button" onclick="FirmarSolicitud(<?=$GET_idPedido;?>,'B')">Firmar solicitud</button>
  </div>
</div>
</div>
</div>

<?php
}
}




if($Session_IDUsuarioBD == 19 ){
if($firmaB == 1 && $firmaC == 0){
?>
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
<div class="border p-3 mt-3">
<div class="mb-2 text-secondary text-center">FIRMA DE AUTORIZACIÓN</div>
<h4 class="text-primary">Token Móvil</h4>
<small class="text-secondary">Agregue el token enviado a su número de teléfono o de clic en el siguiente botón para crear uno</small>
<button class="btn btn-sm" onclick="CrearToken(<?=$GET_idPedido;?>)"><small>Crear nuevo token</small></button>

<div class="input-group mt-3">
  <input type="text" class="form-control" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="button" onclick="FirmarSolicitud(<?=$GET_idPedido;?>,'C')">Firmar solicitud</button>
  </div>
</div>
</div>
</div>
<?php 
}else{
echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2"><div class="text-center alert alert-warning" role="alert">
  ¡Falta firma de VoBo.!
</div>
</div>';
}
}

?>


<?php

$sql_firma = "SELECT * FROM op_pedido_materiales_firma WHERE id_pedido = '".$GET_idPedido."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){
$TipoFirma = "NOMBRE Y FIRMA DEL ENCARGADO";
$Detalle = '<div class="border p-1 text-center"><img src="../../imgs/firma/'.$row_firma['firma'].'" width="70%"></div>';
}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "NOMBRE Y FIRMA DE VOBO";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}else if($row_firma['tipo_firma'] == "C"){
$TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}

echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">';
echo '<div class="border p-3">';
echo '<div class="mb-2 text-center">'.Personal($row_firma['id_usuario'],$con).'<hr></div>';
echo $Detalle;
echo '<h6 class="mt-2 text-secondary text-center">'.$TipoFirma.'</h6>';
echo '</div>';
echo '</div>';
}

?> 
</div>
</div>

</div>

  </div>
  </div>
  </div>

  </div>
  </div>

  </div>



  <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalFinalizado">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 83px;">
      <div class="modal-body">

       <h5 class="text-info">El token fue validado correctamente.</h5>
       <div class="text-secondary">La solicitud de chueque fue firmada.</div>


      <div class="text-end">
        <button type="button" class="btn btn-primary" onclick="Regresar()">Aceptar</button>
      </div>

      </div>
    </div>
  </div>
</div>

  <div class="modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" id="ModalError">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="margin-top: 83px;">
      <div class="modal-body">

       <h5 class="text-danger">El token no fue aceptado, vuelva a generar uno nuevo o inténtelo mas tarde </h5>
       <div class="text-secondary">La solicitud de chueque no fue firmada.</div>
 

      <div class="text-end">
         <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
      </div>

      </div>
    </div>
  </div>
</div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

</body>
</html>
