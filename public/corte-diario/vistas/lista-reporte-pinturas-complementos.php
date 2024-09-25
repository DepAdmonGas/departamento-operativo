<?php
require('../../../app/help.php');


$sql_lista = "SELECT * FROM op_pinturas_complementos_reporte WHERE id_estacion = '".$Session_IDEstacion."' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$Session_IDEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}

function Personal($idusuario,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
}
$idRefaccion = 0;
?>

<div class="table-responsive">
	<table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
		<thead class="navbar-bg">
  <tr>
  <th class="text-center align-middle">#</th>
  <th class="text-center align-middle">Personal</th>
  <th class="text-center align-middle">Fecha y hora</th>
  <th class="text-center align-middle">Detalle</th>
  <th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>
  </tr>
</thead> 
<tbody class="bg-white">
<?php
if ($numero_lista > 0) {

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$status = $row_lista['status'];
$Detalle = '<a class="dropdown-item" onclick="ModalDetalleReporte('.$id.','.$idRefaccion.')"><i class="fa-regular fa-eye"></i> Detalle</a>';
if($status == 0){ 
$tableColor = "background-color: #fcfcda";
$Editar = '<a class="dropdown-item" onclick="EditarReporte('.$id.')"><i class="fa-solid fa-pencil"></i> Editar</a>';
$Eliminar = '<a class="dropdown-item" onclick="EliminarReporte('.$id.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
}else if($status == 1){
$tableColor = "background-color: #b0f2c2";
$Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
$Eliminar = '<a class="dropdown-item grayscale" ><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
}

echo '<tr style="'.$tableColor.'">';
echo '<th class="align-middle text-center">'.$id.'</th>';
echo '<td class="align-middle text-center">'.Personal($row_lista['id_usuario'],$con).'</td>';
echo '<td class="align-middle text-center">'.FormatoFecha($row_lista['fecha']).', '.date('g:i a', strtotime($row_lista['hora'])).'</td>';
echo '<td class="align-middle text-center">'.$row_lista['detalle'].'</td>';
echo '<td class="align-middle text-center"> 
              <div class="dropdown">
                <a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-ellipsis-v"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                  ' . $Detalle . '
                  ' . $Editar . '
                  ' . $Eliminar . '
                </div>
              </div>
            </td>';
echo '</tr>';

}
}else{
echo "<tr><th colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
}
?>
</tbody>
</table>
</div>