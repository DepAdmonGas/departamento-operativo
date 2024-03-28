<?php 
require('../../../app/help.php');
$idEstacion = $_GET['idEstacion'];
$idRol = $_GET['idRol'];
 

if($idRol == 0){
$sql_organigrama = "SELECT * FROM op_rol_comodines WHERE id_estacion = '".$idEstacion."' ORDER BY version DESC LIMIT 1"; 
}else{
$sql_organigrama = "SELECT * FROM op_rol_comodines WHERE id = '".$idRol."' ";
}

$result_organigrama = mysqli_query($con, $sql_organigrama);
$numero_organigrama = mysqli_num_rows($result_organigrama);
if ($numero_organigrama > 0) {
while($row_organigrama = mysqli_fetch_array($result_organigrama, MYSQLI_ASSOC)){
$archivo = '<img class="mb-3" style="width: 100%" src="archivos/rol-comodines/'.$row_organigrama['archivo'].'">';
}

}else{
$archivo = '';

}


$sql_lista = "SELECT * FROM op_rol_comodines WHERE id_estacion = '".$idEstacion."' ORDER BY version DESC LIMIT 10";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if($Session_IDUsuarioBD == 354){
$inicioDiv = "";
$finDiv = "";
$ocultarDiv = "d-none";

}else{
$inicioDiv = '<div class="border-0 p-3">';
$finDiv = '</div>';
$ocultarDiv = "";

}

?>
 

<?=$inicioDiv?>

<div class="row <?=$ocultarDiv?>">

<div class="col-11">
<h5>Rol de Comodines</h5>
</div>
 
<div class="col-1">
<img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="ModalRoles(<?=$idEstacion?>)">
</div>
</div>

<hr class="<?=$ocultarDiv?>">

<div class="row">

<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 mb-0">
<?=$archivo;?>
</div>

<div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-0">

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover" style="font-size: .9em;">
<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">Versión</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Fecha y hora</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Observaciones</th>
  <th class="align-middle text-center <?=$ocultarDiv?>" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$explode = explode(' ',$row_lista['fecha_creacion']);

echo '<tr class="pointer" onclick="SelComodines('.$idEstacion.','.$id.')">
<td class="align-middle text-center"><b>'.$row_lista['version'].'</b></td>
<td class="align-middle">'.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</td>
<td class="text-center align-middle"><small>'.$row_lista['observaciones'].'</small></td>
<td class="align-middle text-center '.$ocultarDiv.'" width="20" onclick="Eliminar('.$idEstacion.','.$id.')"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png"></td>
</tr>';

}
}else{
echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar</small></td></tr>";
}
?>
</tbody>
</table>
</div>
</div>

</div>

<?=$finDiv?>