<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_refacciones_transaccion WHERE id_estacion = '".$idEstacion."' OR id_estacion_receptora = '".$idEstacion."' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

function Refaccion($idRefaccion,$con){
$sql = "SELECT nombre FROM op_refacciones WHERE id = '".$idRefaccion."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
}
 
function Estacion($idEstacion,$con){
$sql = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$estacion = $row['localidad'];
}

return $estacion;
}


function ToComentarios($idRefaccionT,$con){

$sql_lista = "SELECT id_op_refacciones_transaccion FROM op_refacciones_transaccion_comentarios WHERE id_op_refacciones_transaccion = '".$idRefaccionT."' ";
$result_lista = mysqli_query($con, $sql_lista);

return $numero_lista = mysqli_num_rows($result_lista);
}
 

?> 

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="SelEstacionReturn(<?=$idEstacion;?>)" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Inventario</a></li>
  <li aria-current="page" class="breadcrumb-item active">TRANSACCIÓN DE REFACCIONES (<?= strtoupper($estacion)?>)</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Transacción de Refacciones (<?=$estacion;?>)</h3>
  </div>

  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
  <button type="button" class="btn btn-labeled2 btn-primary float-end mt-2" onclick="ModalTransaccion(<?=$idEstacion;?>)">
  <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
  </div>
  </div>

  <hr> 
  </div>


<div class="table-responsive">
<table id="tabla_transaccion_<?=$idEstacion?>" class="custom-table" style="font-size: 12.5px;" width="100%"> 
<thead class="tables-bg">
  <tr> 
  <th class="text-center align-middle tableStyle font-weight-bold"><b>#</b></th>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Fecha y hora</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Refacción</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Piezas</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Estación proveedora</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Estación receptora</b></td>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-firmar-w.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>comentario-tb.png"></th>
  <th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>
  </tr>
</thead> 

<tbody class="bg-white"> 
<?php
if ($numero_lista > 0) {
 
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$status = $row_lista['estado'];
 
if($status == 0){
$tableColor = 'style="background-color: #fcfcda"';
$PDFD = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
$detalletb = '<a class="dropdown-item" onclick="ModalDetalleT('.$id.')"><i class="fa-regular fa-eye"></i> Detalle</a>';
$firmatb = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="FirmarTransaccion('.$idEstacion.','.$id.')">';
$devoluciontb = '<a class="dropdown-item" onclick="EliminarTransaccion('.$idEstacion.','.$id.',1)"><i class="fa-solid fa-rotate-left"></i> Devolución de refacción</a>';
$eliminartb = '<a class="dropdown-item" onclick="EliminarTransaccion('.$idEstacion.','.$id.',2)"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';

}else if($status == 1 || $status == 2){
$tableColor = 'style="background-color: #cfe2ff"';
$PDFD = '<a class="dropdown-item"><i class="fa-solid fa-file-pdf" onclick="DescargarTransaccion('.$id.')"></i> Descargar PDF</a>';
$detalletb = '<a class="dropdown-item" onclick="ModalDetalleT('.$id.')"><i class="fa-regular fa-eye"></i> Detalle</a>';
$firmatb = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png">';
$devoluciontb = '<a class="dropdown-item grayscale"><i class="fa-solid fa-rotate-left"></i> Devolución de refacción</a>';
$eliminartb = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';

}else if($status == 404){
$tableColor = 'style="background-color: #ffb6af"'; 
$PDFD = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
$detalletb = '<a class="dropdown-item grayscale"><i class="fa-regular fa-eye"></i> Detalle</a>';
$firmatb = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png">';
$devoluciontb = '<a class="dropdown-item grayscale"><i class="fa-solid fa-rotate-left"></i> Devolución de refacción</a>';
$eliminartb = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
} 

   
$explode = explode(" ", $row_lista['fecha']);
 
$NomRefaccion = Refaccion($row_lista['id_refaccion'],$con);
$EstacionProveedora = Estacion($row_lista['id_estacion'],$con);
$Estacion = Estacion($row_lista['id_estacion_receptora'],$con);

$ToComentarios = ToComentarios($id,$con);

if($ToComentarios > 0){ 
$Nuevo = '<div class="position-absolute" style="margin-bottom: -15px; right: 2px;"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">'.$ToComentarios.' </span></span></div>';

}else{
$Nuevo = ''; 
}


echo '<tr '.$tableColor.'>';
echo '<th class="align-middle text-center">'.$id.'</th>';
echo '<td class="align-middle text-center">'.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.date('g:i a', strtotime($explode[1])).'</td>';
echo '<td class="align-middle text-center">'.$NomRefaccion.'</td>';
echo '<td class="align-middle text-center">1</td>';
echo '<td class="align-middle text-center"><b>'.$EstacionProveedora.'</b></td>';
echo '<td class="align-middle text-center"><b>'.$Estacion.'</b></td>';
echo '<td class="align-middle text-center">'.$firmatb.'</td>';
echo '<td class="align-middle text-center position-relative" onclick="ComentarioTransaccion('.$idEstacion.','.$id.')">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';

echo '<td class="align-middle text-center">
<div class="dropdown">

<a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
<i class="fas fa-ellipsis-v"></i>
</a>

<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
'.$PDFD.'
'.$detalletb.'
'.$devoluciontb.'
'.$eliminartb.'
</div>
</div>

</td>';


echo '</tr>';
 
}  
}
?>

</tbody>
</table>
</div>

