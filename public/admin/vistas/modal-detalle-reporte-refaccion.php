<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

function Personal($idusuario,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
}

function Refaccion($idrefaccion,$con){

$sql_lista = "SELECT * FROM op_refacciones WHERE id = '".$idrefaccion."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$nombre = $row_lista['nombre'];
$imagen = $row_lista['imagen'];
}

$array = array(
'nombre' => $nombre,
'imagen' => $imagen,
);

return $array;
}


$sql_lista = "SELECT * FROM op_refacciones_reporte WHERE id = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$idRefaccion = $row_lista['id'];
$personal = Personal($row_lista['id_usuario'],$con);
$fecha = FormatoFecha($row_lista['fecha']);
$hora = date('g:i a', strtotime($row_lista['hora']));

$Refaccion = Refaccion($idRefaccion,$con);

$nomRefaccion = $Refaccion['nombre'];
$imagen = $Refaccion['imagen'];

$dispensario = $row_lista['dispensario'];
$motivo = $row_lista['motivo'];
}

?>

<div class="modal-header">
<h5 class="modal-title">Detalle del reporte</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<div class="row">
 
<div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-2"> 
    <h6 class="mb-1 text-secondary ">Personal:</h6>
    <div class=""><?=$personal;?></div>
  </div>

<div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-2"> 
    <h6 class="mb-1 text-secondary ">Fecha:</h6>
    <div class=""><?=$fecha;?></div>
  </div>

<div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-2"> 
    <h6 class="mb-1 text-secondary ">Hora:</h6>
    <div class=""><?=$hora;?></div>
  </div>

</div>

<div class="row ">
  
  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
      <h6 class="mb-1 text-secondary">Dispensario:</h6>
    <div class=""><?=$dispensario;?></div>
  </div>

  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
    <h6 class="mb-1 text-secondary">Motivo:</h6>
    <div class=""><?=$motivo;?></div>
  </div>
</div>

<h6 class="text-secondary">Refacciones:</h6>

<div class="table-responsive">
<table class="custom-table" style="font-size: .8em;" width="100%">
<thead class="tables-bg">
  <tr>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Imagen</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Refacción</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Unidad</b></td>
  </tr>
</thead> 
<tbody class="bg-light">
<?php
$sql_detalle = "SELECT * FROM op_refacciones_reporte_detalle WHERE id_reporte = '".$idReporte."' ";
$result_detalle = mysqli_query($con, $sql_detalle);
$numero_detalle = mysqli_num_rows($result_detalle);
if ($numero_detalle > 0) {

while($row_detalle = mysqli_fetch_array($result_detalle, MYSQLI_ASSOC)){
$idRefaccion = $row_detalle['id_refaccion'];
$NomRefaccion = Refaccion($idRefaccion, $con);
$unidad = $row_detalle['unidad'];
echo '<tr>';
echo '<th class="align-middle text-center"><img width="50px" src="'.RUTA_ARCHIVOS.''.$NomRefaccion['imagen'].'"></th>';
echo '<td class="align-middle text-center">'.$NomRefaccion['nombre'].'</td>';
echo '<td class="align-middle text-center">'.$unidad.'</td>';
echo '</tr>';
}
}else{
echo "<tr><td colspan='8' class='text-center text-secondary fw-normal no-hover2'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

</div>
