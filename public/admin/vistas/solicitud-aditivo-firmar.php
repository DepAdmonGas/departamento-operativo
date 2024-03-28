<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}

$sql_lista = "SELECT * FROM op_solicitud_aditivo WHERE id = '".$GET_idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$ordencompra = $row_lista['orden_compra'];
$para = $row_lista['para'];
$fecha = $row_lista['fecha'];
$idpersonal = $row_lista['id_personal'];
$fechaentrega = $row_lista['fecha_entrega'];
$fechapedido = $row_lista['fecha_pedido'];
$comentarios = $row_lista['comentarios'];
$status = $row_lista['status'];

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
$sql_lista = "SELECT * FROM op_solicitud_aditivo_firma WHERE id_reporte = '".$idReporte."' AND tipo_firma = '".$tipoFirma."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
}

$firmaB = FirmaSC($GET_idReporte,'B',$con);
$firmaC = FirmaSC($GET_idReporte,'C',$con);
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


  <script type="text/javascript" src="<?php echo RUTA_JS ?>signature_pad.js"></script>

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
    url:   '../../public/admin/modelo/token-solicitud-aditivo.php',
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
    url:   '../../public/admin/modelo/firmar-solicitud-aditivo.php',
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
     alertify.error('Error al firmar la solicitud');
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

     <h5>Firmar Pedido de aditivo</h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>

 
<div class="container ">


<div class="row">

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1 mt-1">
  <span class="badge rounded-pill tables-bg float-start" style="font-size:14px">Fecha: <?=FormatoFecha($fecha);?></span>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1 mt-1">
  <span class="badge rounded-pill tables-bg float-end" style="font-size:14px">No. Orden de Compra: <?=$ordencompra;?></span>
</div>

</div>

<hr>


<div class="border p-3 mb-3">
    <h6>Para:</h6>
    <hr>
    <div><?=$para;?></div>
</div>


<div class="border p-3 mb-3">
    <h6>Comentarios o instrucciones especiales:</h6>
        <hr>
    <div><?=$comentarios;?></div>
</div>


<div class="table-responsive">
<table class="table table-sm table-bordered mb-3">
<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">FECHA DE ENTREGA REQUERIDA</th>
  <th class="text-center align-middle tableStyle font-weight-bold">SOLICITADO POR</th>
  </tr>
</thead> 
<tbody>
  <tr>
    <td class="text-center">
    <?=FormatoFecha($fechaentrega);?>
    </td>
    <td class="text-center align-middle">
     <?=Personal($idpersonal,$con);?>
    </td>
  </tr>
  </tbody>
  </table>
</div>
 
<div class="table-responsive">
  <table class="table table-sm table-bordered mb-3">
<thead class="tables-bg">
    <tr>
    <th class="text-center align-middle tableStyle font-weight-bold">CANTIDAD DE TAMBORES</th>
    <th class="text-center align-middle tableStyle font-weight-bold">NOMBRE DEL PRODUCTO</th>
    <th class="text-center align-middle tableStyle font-weight-bold">NOMBRE DEL ADITIVO</th>
    <th class="text-center align-middle tableStyle font-weight-bold">KILOGRAMOS POR TAMBOR</th>
    <th class="text-center align-middle tableStyle font-weight-bold">TOTAL KILOS</th>
    </tr>
  </thead> 
  <tbody>
  <?php 
  $sql_aditivo = "SELECT * FROM op_solicitud_aditivo_tambo WHERE id_reporte = '".$GET_idReporte."' ";
  $result_aditivo = mysqli_query($con, $sql_aditivo);
  $numero_aditivo = mysqli_num_rows($result_aditivo);
  if ($numero_aditivo > 0) {
  while($row_aditivo = mysqli_fetch_array($result_aditivo, MYSQLI_ASSOC)){
  $id = $row_aditivo['id'];

  $totalkilogramos = $row_aditivo['cantidad'] * $row_aditivo['kilogramo'];
  $totaldolares = $totalkilogramos * $row_aditivo['precio_kilogramo'];

  echo '<tr>
  <td class="text-center align-middle">'.$row_aditivo['cantidad'].'</td>
  <td class="text-center align-middle">'.$row_aditivo['producto'].'</td>
  <td class="text-center align-middle">'.$row_aditivo['aditivo'].'</td>
  <td class="text-center align-middle">'.$row_aditivo['kilogramo'].'</td>
  <td class="text-center align-middle" id="TK'.$id.'">'.$totalkilogramos.'</td>
  </tr>';

  $SubtotalDolares = $SubtotalDolares + $totaldolares;
  }
  }else{
  echo "<tr><td colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";  
  }

   ?>
  </tbody> 
  </table>
</div>


<div class="border p-3">
<h6>Firmas:</h6>
<hr>


<div class="row">
<?php  
if($firmaB == 0){

if($Session_IDUsuarioBD == 19){
?>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
<div class="border p-3">
<div class="mb-2 text-secondary text-center">FIRMA DE VOBO</div>
<hr>
<h4 class="text-primary">Token Móvil</h4>
<small class="text-secondary">Agregue el token enviado a su número de teléfono o de clic en el siguiente botón para crear uno</small>
<button class="btn btn-sm btn-light" onclick="CrearToken(<?=$GET_idReporte;?>)"><small>Crear token</small></button>

<hr>
<div class="input-group mt-3">
  <input type="text" class="form-control" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="button" onclick="FirmarSolicitud(<?=$GET_idReporte;?>,'B')">Firmar solicitud</button>
  </div>
</div>
</div>
</div>


<?php
}else{

}
}

if($firmaC == 0){

if($Session_IDUsuarioBD == 2 OR $Session_IDUsuarioBD == 22 ){ ?>
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
<div class="border p-3">
<div class="mb-2 text-secondary text-center">FIRMA DE AUTORIZACIÓN</div>
<hr>
<h4 class="text-primary">Token Móvil</h4>
<small class="text-secondary">Agregue el token enviado a su número de teléfono o de clic en el siguiente botón para crear uno</small>
<button class="btn btn-sm btn-light" onclick="CrearToken(<?=$GET_idReporte;?>)"><small>Crear nuevo token</small></button>
<hr>
<div class="input-group mt-3">
  <input type="text" class="form-control" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="button" onclick="FirmarSolicitud(<?=$GET_idReporte;?>,'C')">Firmar solicitud</button>
  </div>
</div>
</div>
</div>
<?php }else{

}

}
?>


<?php

$sql_firma = "SELECT * FROM op_solicitud_aditivo_firma WHERE id_reporte = '".$GET_idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){
$TipoFirma = "NOMBRE Y FIRMA DEL ENCARGADO";
$Detalle = '<div class="border p-1 text-center"><img src="../../imgs/firma/'.$row_firma['firma'].'" width="70%"></div>';

}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "NOMBRE Y FIRMA DE VoBo";
$Detalle = '<div class="border-bottom text-center p-3"><small>La solicitud de aditivo se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';


}else if($row_firma['tipo_firma'] == "C"){
$TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
$Detalle = '<div class="border-bottom text-center p-3"><small>La solicitud de aditivo se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';

}

echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">';
echo '<div class="border p-3">';

echo '<div class="mb-2 text-center">'.Personal($row_firma['id_usuario'],$con).' <hr> </div>';
echo $Detalle;
echo '<h6 class="mt-2 text-secondary text-center">'.$TipoFirma.'</h6>';

echo '</div';
echo '</div';

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
