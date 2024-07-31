<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_refacciones_reporte WHERE id_estacion = '".$idEstacion."' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

function Personal($idusuario,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
}

?>


  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="SelEstacionReturn(<?=$idEstacion;?>)" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Inventario</a></li>
  <li aria-current="page" class="breadcrumb-item active">REPORTE DE REDACCIONES (<?= strtoupper($estacion)?>)</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Reporte de Refacciones (<?=$estacion;?>)</h3>
  </div>

  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
  <button type="button" class="btn btn-labeled2 btn-primary float-end mt-2" onclick="AgregarReporte(<?=$idEstacion;?>)">
  <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
  </div>
  </div>

  <hr> 
  </div>

  <table id="tabla_reporte_<?=$idEstacion?>" class="custom-table" style="font-size: 12.5px;" width="100%"> 
  <thead class="tables-bg">
  <tr>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>#</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Personal</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Fecha y hora</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Motivo</b></td>
  <td class="text-center align-middle tableStyle font-weight-bold"><b>Dispensario</b></td>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
  <th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>


  </tr>
</thead> 

<tbody class="bg-white">
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$status = $row_lista['status'];

if($status == 0){
$tableColor = 'style="background-color: #fcfcda"';
}else{
$tableColor = "";
}
 
if($row_lista['archivo'] == ""){
$PDF = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png">';
}else{
$PDF = '<a href="'.RUTA_ARCHIVOS.''.$row_lista['archivo'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" ></a>';  
}

echo '<tr '.$tableColor.'>';
echo '<th class="align-middle text-center">'.$num.'</td>';
echo '<td class="align-middle text-center">'.Personal($row_lista['id_usuario'],$con).'</th>';
echo '<td class="align-middle text-center">'.$ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha']).', '.date('g:i a', strtotime($row_lista['hora'])).'</td>';
echo '<td class="align-middle text-center">'.$row_lista['motivo'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['dispensario'].'</td>';

echo '<td class="align-middle text-center">'.$PDF.'</td>';

echo '<td class="align-middle text-center">
<div class="dropdown">

<a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
<i class="fas fa-ellipsis-v"></i>
</a>

<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
<a class="dropdown-item" onclick="ModalDetalleReporte('.$idEstacion.','.$id.')"><i class="fa-regular fa-eye"></i> Detalle</a>
<a class="dropdown-item" onclick="EditarReporte('.$idEstacion.','.$id.')"><i class="fa-solid fa-pencil"></i> Editar</a>
<a class="dropdown-item" onclick="EliminarReporte('.$idEstacion.','.$id.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>

</div>
</div>

</td>';

echo '</tr>';

$num++;
}
}else{
echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

