<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_solicitud_aditivo WHERE id = '".$idReporte."' ";
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
?>

 
<div class="modal-header">
<h5 class="modal-title">Detalle de Solicitud de aditivo</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div> 

<div class="modal-body"> 

<div class="row">

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1 mt-1">
  <span class="badge rounded-pill tables-bg float-start" style="font-size:14px">Fecha: <?=FormatoFecha($fecha);?></span>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-1 mt-1">
  <span class="badge rounded-pill tables-bg float-end" style="font-size:14px">No. Orden de Compra: <?=$ordencompra;?></span>
</div>

</div>

<hr>



<div class="row">

<div class="col-12 mb-3">
<div class="border">
<div class="p-3">
<h6>Para:</h6>
<hr>
<?=$para;?>
</div>
</div>
</div>

<div class="col-12 mb-3">
<div class="border">
<div class="p-3">
<h6>Comentarios o instrucciones especiales:</h6>
<hr>
<?=$comentarios;?>
</div>
</div>
</div>


</div>


<div class="table-responsive">
<table class="table table-sm table-bordered mb-3" style="font-size: .8em;">
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
  <table class="table table-sm table-bordered mb-3" style="font-size: .8em;">
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
  $sql_aditivo = "SELECT * FROM op_solicitud_aditivo_tambo WHERE id_reporte = '".$idReporte."' ";
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


<div class="row">

<div class="col-12">
<div class="border p-3">

  <h6>Firmas:</h6>
  <hr>

  <?php
  if($status == 2){ ?>

<div class="row">
<?php
$sql_firma = "SELECT * FROM op_solicitud_aditivo_firma WHERE id_reporte = '".$idReporte."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){
$TipoFirma = "NOMBRE Y FIRMA DEL ENCARGADO";
$Detalle = '<div class="border p-1 text-center"><img src="../imgs/firma/'.$row_firma['firma'].'" width="70%"></div>';
}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "NOMBRE Y FIRMA DE VoBo";
$Detalle = '<div class="border-bottom text-center p-3"><small>La solicitud de aditivo se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}else if($row_firma['tipo_firma'] == "C"){
$TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
$Detalle = '<div class="border-bottom text-center p-3"><small>La solicitud de aditivo se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}

echo '<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2>';
echo '<div class="border p-3">';
echo '<div class="mb-2 text-center">'.Personal($row_firma['id_usuario'],$con).'<hr></div>';
echo $Detalle;
echo '<h6 class="mt-2 text-secondary text-center">'.$TipoFirma.'</h6>';
echo '</div>';
echo '</div>';
}

?> 
</div>

<?php }else{?>
<div class="row">

<div class="col-12 text-center mb-0">
<div class="alert alert-warning" role="alert">
  ¡Falta la firma de autorización!
</div>
</div>
</div>

<?php 
} ?>


</div>
</div> 
</div>

</div>






