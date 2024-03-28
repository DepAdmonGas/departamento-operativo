<?php
require('../../../app/help.php');
$fecha_del_dia = date("Y-m-d");

function ToAlerta($idProveedor,$nameDoc,$con){

$sql_fechas = "SELECT fecha FROM op_almacen_proveedores_documentos WHERE id_proveedor = '".$idProveedor."' AND nombre = '".$nameDoc."' ";
$result_fechas = mysqli_query($con, $sql_fechas);
$numero_fechas = mysqli_num_rows($result_fechas); 

while($row_fechas = mysqli_fetch_array($result_fechas, MYSQLI_ASSOC)){
$fechas = $row_fechas['fecha'];
}

$fechaLimite = date("Y-m-d",strtotime($fechas."+ 3 month")); 
return $fechaLimite;

}


$sql_lista = "SELECT id, folio, fecha, razon_social, actividad_economica FROM op_almacen_proveedores WHERE status = 0 ORDER BY folio DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?> 

 
<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">

<thead class="tables-bg">
  <tr>
  	<th class="text-center align-middle tableStyle font-weight-bold">No.</th>
	<th class="text-center align-middle tableStyle font-weight-bold">Folio</th>
	<th class="text-center align-middle tableStyle font-weight-bold">Fecha</th>
	<th class="text-center align-middle tableStyle font-weight-bold">Nombre comercial de la empresa (Proveedor)</th>
	<th class="text-center align-middle tableStyle font-weight-bold">Actividad economica</th>

	<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
	<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>archivo-tb.png"></th>
	<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
    <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead>
  
<tbody>
<?php
if ($numero_lista > 0){ 
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$id_proveedor = $row_lista['id'];
$folio = $row_lista['folio'];
$fecha = FormatoFecha($row_lista['fecha']);
$razon_social = $row_lista['razon_social'];
$actividad_economica = $row_lista['actividad_economica'];


$ToAlerta = ToAlerta($id_proveedor,'Constancia de Situacion Fiscal',$con);
$ToAlerta1 = ToAlerta($id_proveedor,'Caratula Bancaria',$con);

if($fecha_del_dia >= $ToAlerta){
	$ValConst = 1;
}else{
	$ValConst = 0;
}


if($fecha_del_dia >= $ToAlerta1){
	$ValConst2 = 1;
}else{
	$ValConst2 = 0;
}

$suma = $ValConst + $ValConst2;

if($suma > 0){
	$Aviso = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><small>'.$suma.' </small></span></div>';
}else{
	$Aviso = '';
}

  
echo '<tr>';
echo '<td class="align-middle text-center" width="40px">'.$num.'</td>';
echo '<td class="align-middle text-center">00'.$folio.'</td>';
echo '<td class="align-middle text-center">'.$fecha.'</td>';
echo '<td class="align-middle text-center">'.$razon_social.'</td>';
echo '<td class="align-middle text-center">'.$actividad_economica.'</td>';

echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="ModalDetalleProveedor('.$id_proveedor.')"></td>';
echo '<td class="align-middle text-center">'.$Aviso.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'archivo-tb.png" onclick="ModalArchivosProveedor('.$id_proveedor.')"></td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="ModalEditarProveedor('.$id_proveedor.')"></td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarProveedor('.$id_proveedor.')"></td>';
echo '</tr>';

$num++;
}
}else{
echo "<tr><td colspan='16' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>

</tbody>

</table>
</div>