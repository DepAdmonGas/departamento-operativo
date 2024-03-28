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
 
<div class="border-0 p-3">

    <div class="row">

    <div class="col-xl-11 col-lg-11 col-md-11 col-sm-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="SelEstacionReturn(<?=$idEstacion;?>)">
    <div class="row">
    <div class="col-12">
    <h5>Transacción de refacciones <?=$estacion;?></h5>
    </div>
    </div>
    </div>

    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12">
    <img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="ml-2" onclick="ModalTransaccion(<?=$idEstacion;?>)">
    </div>

    </div>

    <hr> 

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">
  <tr> 
  <td class="text-center align-middle tableStyle font-weight-bold"><b>#</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Fecha y hora</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Refacción</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Piezas</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Estación proveedora</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Estación receptora</b></td>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
    <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>devolver.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-firmar-w.png"></th>
      <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>comentario-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead> 
<tbody> 
<?php
if ($numero_lista > 0) {
 
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$status = $row_lista['estado'];
 
if($status == 0){
$tableColor = "table-warning";
$PDFD = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png">';
$detalletb = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="ModalDetalleT('.$id.')">';
$firmatb = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" onclick="FirmarTransaccion('.$idEstacion.','.$id.')">';
$devoluciontb = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'devolver.png"  onclick="EliminarTransaccion('.$idEstacion.','.$id.',1)">';
$eliminartb = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarTransaccion('.$idEstacion.','.$id.',2)">';
 

}else if($status == 1 || $status == 2){
$tableColor = "table-primary";
$PDFD = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="DescargarTransaccion('.$id.')">';
$detalletb = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="ModalDetalleT('.$id.')">';
$firmatb = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png">';
$devoluciontb = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'devolver.png">';
$eliminartb = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png">';


}else if($status == 404){
$tableColor = "table-danger";
$PDFD = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png">';
$detalletb = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'ver-tb.png">';
$firmatb = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png">';
$devoluciontb = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'devolver.png">';
$eliminartb = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png">';
} 

   
$explode = explode(" ", $row_lista['fecha']);
 
$NomRefaccion = Refaccion($row_lista['id_refaccion'],$con);
$EstacionProveedora = Estacion($row_lista['id_estacion'],$con);
$Estacion = Estacion($row_lista['id_estacion_receptora'],$con);


  $ToComentarios = ToComentarios($id,$con);

  if($ToComentarios > 0){
    $Nuevo = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToComentarios.'</small></span></div>';
 
  }else{
   $Nuevo = ''; 
  }


echo '<tr class="'.$tableColor.'">';
echo '<td class="align-middle text-center"><b>'.$id.'</b></td>';
echo '<td class="align-middle text-center">'.FormatoFecha($explode[0]).', '.date('g:i a', strtotime($explode[1])).'</td>';
echo '<td class="align-middle text-center">'.$NomRefaccion.'</td>';
echo '<td class="align-middle text-center">1</td>';
echo '<td class="align-middle text-center"><b>'.$EstacionProveedora.'</b></td>';
echo '<td class="align-middle text-center"><b>'.$Estacion.'</b></td>';
echo '<td class="align-middle text-center">'.$PDFD.'</td>';
echo '<td class="align-middle text-center">'.$detalletb.'</td>';
echo '<td class="align-middle text-center">'.$devoluciontb.'</td>';
echo '<td class="align-middle text-center">'.$firmatb.'</td>';
echo '<td class="align-middle text-center">'.$Nuevo.'<img class="pointer" width="20" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" onclick="ComentarioTransaccion('.$idEstacion.','.$id.')" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';  
echo '<td class="align-middle text-center">'.$eliminartb.'</td>';
echo '</tr>';
 
}  
}else{
echo "<tr><td colspan='16' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>
</div>
