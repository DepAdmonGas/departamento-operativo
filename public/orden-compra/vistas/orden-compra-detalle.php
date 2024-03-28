<?php
require('app/help.php');

if ($Session_IDUsuarioBD == "") {
header("Location:".PORTAL."");
}
 
$sql = "SELECT * 
FROM op_orden_compra WHERE id = '".$GET_idReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$no_control = $row['no_control'];
$porcentaje_total = $row['porcentaje_total'];
$cargo = $row['cargo'];

$explode = explode(" ", $row['fecha']);
$Fecha = $explode[0];
$estatus = $row['estatus'];
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
  ContenidoEstaciones(<?=$GET_idReporte;?>)
  ContenidoProveedor(<?=$GET_idReporte;?>)
  ContenidoArticulos(<?=$GET_idReporte;?>)
  ContenidoRefacturacion(<?=$GET_idReporte;?>)

  }); 

    function Regresar(){
    window.history.back(); 
    } 
 
 
    function ContenidoEstaciones(idReporte){
    $('#ContenidoEstaciones').load('../../public/orden-compra/vistas/lista-estaciones.php?idReporte=' + idReporte + '&idStatus=' + 1);
    }   

    function ContenidoProveedor(idReporte){
    $('#ContenidoProveedor').load('../../public/orden-compra/vistas/lista-proveedor.php?idReporte=' + idReporte + '&idStatus=' + 1);
    } 

    function ContenidoArticulos(idReporte){
    $('#ContenidoArticulos').load('../../public/orden-compra/vistas/lista-producto.php?idReporte=' + idReporte + '&idStatus=' + 1);
    } 

    function ContenidoRefacturacion(idReporte){
    $('#ContenidoRefacturacion').load('../../public/orden-compra/vistas/lista-refacturacion.php?idReporte=' + idReporte + '&idStatus=' + 1);
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

     <h5>Orden de Compra</h5>
    
    </div>
    </div>

    </div>
    </div>

  <hr>


  <div class="row">

 
  <!---------- TABLA ORDEN DE COMPRA Y AGREGAR ESTACION ---------->
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">

   <div class="table-responsive">
     <table class="table table-sm table-bordered" style="font-size: .9em;">
    <tr>
      <td colspan="2" class="align-middle">Dep. Almacén</td>

      <td rowspan="3" class="text-center align-middle"><h5>ORDEN DE COMPRA</h5></td>
      <td class="align-middle">Cargo:</td>
      <td ><b><?=$cargo;?> </b></td>
    </tr>
    <tr>
      <td colspan="2" class="align-middle">Ref. Operativa</td>
      <td class="align-middle">Fecha:</td>
      <td ><b><?=FormatoFecha($Fecha);?></b></td>
    </tr>
    <tr>
      <td class="align-middle"><b>Refacturación</b></td>
      <td class="text-end"><b><?=$porcentaje_total;?> %</b></td>

      <td class="align-middle">No. De control:</td>
      <td class="align-middle"><b>00<?=$no_control?></b></td>
    </tr>     
   </table>
  </div>


  <div id="ContenidoEstaciones"></div>

  </div>

  <!---------- TABLA AGREGAR PROVEEDOR ---------->
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
  <div id="ContenidoProveedor"></div>
  </div>


<?php
  $sql_proveedor = "SELECT * FROM op_orden_compra_proveedor WHERE id_ordencompra = '".$GET_idReporte."' ";
  $result_proveedor = mysqli_query($con, $sql_proveedor);
  $numero_proveedor = mysqli_num_rows($result_proveedor);

  if($numero_proveedor > 2){
    $ocultarM = "";
  }else{
    $ocultarM = "d-none";    
  }

  ?>

 <div class="col-12 mb-3 <?=$ocultarM?>">
  <div id="ContenidoArticulos"></div>
</div>


 <div class="col-12 mb-3 <?=$ocultarM?>">
  <div id="ContenidoRefacturacion"></div>
</div>

</div>



<div class="col-12">
<div class="row">
<?php

$sql_firma = "SELECT * FROM op_orden_compra_firma WHERE id_ordencompra = '".$GET_idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){
$TipoFirma = "Elaboró";
$Detalle = '<div class="border p-1 text-center"><img src="../../imgs/firma/'.$row_firma['firma'].'" width="70%"></div>';
$puesto = '<div class="text-center"><b>Encargada de almacen</b></div>';


}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "Vo.Bo";
$Detalle = '<div class="border-bottom text-center p-2"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
$puesto = '';

}

echo '<div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">';
echo '<div class="border p-3">';
echo '<h6 class="mt-2 text-secondary text-center">'.$TipoFirma.'</h6><hr>';
echo $Detalle;
echo '<div class="text-center mt-2">'.Personal($row_firma['id_usuario'],$con).'</div>';
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

  </div>

  </div>


  <!---------- FUNCIONES - NAVBAR ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?=RUTA_JS2 ?>bootstrap.min.js"></script>

  </body>
  </html>
