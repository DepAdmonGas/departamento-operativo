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
$ocultarDiv = "d-none";
$botonComodines = "";

}else{
$ocultarDiv = "";
$botonComodines = '<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="ModalRoles('.$idEstacion.')">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>';
}

?>
 

<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Recursos Humanos</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Rol de Comodines</li>
</ol>
</div>

<div class="row">
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Rol de Comodines</h3></div>
<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12"><?=$botonComodines?></div>
</div>

<hr>
          
</div>




<div class="row">

<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 mb-0">
<?=$archivo;?>
</div>

<div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-0">

<div class="table-responsive">
<table id="tabla_bitacora" class="custom-table" style="font-size: .9em;" width="100%">

<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">Versión</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Fecha y hora</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Comentario</th>
  <th class="align-middle text-center <?=$ocultarDiv?>" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead> 
<tbody class="bg-white">
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
echo "<tr><th colspan='8' class='text-center text-secondary fw-normal no-hover'><small>No se encontró información para mostrar</small></th></tr>";
}
?>
</tbody>
</table>
</div>
</div>

</div>

