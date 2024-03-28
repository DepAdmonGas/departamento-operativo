 <?php
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];

$sql_estaciones = "SELECT localidad FROM op_rh_localidades WHERE id = ".$idEstacion." "; 
$result_estaciones = mysqli_query($con, $sql_estaciones);
$numero_estaciones = mysqli_num_rows($result_estaciones);

while($row_estaciones = mysqli_fetch_array($result_estaciones, MYSQLI_ASSOC)){
$nombreES = $row_estaciones['localidad'];

}

?>
 

<div class="modal-header">
<h5 class="modal-title">Constancia Situacion Fiscal <?=$nombreES?></h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
 
<div class="col-12 mb-2" style="font-size:1em"> 
 <div class="mb-1 text-secondary">Fecha de actualización:</div>
<input class="form-control" type="date" id="fechaCSF">
</div>

<div class="col-12" style="font-size:1em"> 
 <div class="mb-1 text-secondary">Constancia de Situacion Fiscal:</div>
<input class="form-control" type="file" id="archivoCSF">
</div>

<div class="text-end mt-3">
<button type="button" class="btn btn-primary " onclick="AgregarCSF(<?=$idEstacion;?>)">Agregar</button>
</div>

<hr>
 
<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">

<thead class="tables-bg">
  <th class="text-center align-middle text-center" width="40"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
  <th class="text-center align-middle font-weight-bold">Fecha de actualización</th>
  <th class="text-center align-middle text-center" width="40"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</thead> 

<?php 
$sql_lista = "SELECT * FROM tb_constancia_fiscal_es WHERE id_estacion = ".$idEstacion." ORDER BY fecha DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$GET_idCSF = $row_lista['id'];
$fecha = FormatoFecha($row_lista['fecha']);

 
echo '<tr>';
echo '<td class="align-middle text-center">
<a class="pointer" href="'.RUTA_ARCHIVOS.'constancia-situacion-es/'.$row_lista['archivo'].'" download><img src="'.RUTA_IMG_ICONOS.'pdf.png'.'"></a>
</td>';
echo '<td class="align-middle text-center">'.$fecha.'</td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarCSF('.$GET_idCSF.','.$idEstacion.')"></td>';
echo '</tr>';
$num++;
}
}else{
echo "<tr><td colspan='5' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>

</table>
</div>

</div>

