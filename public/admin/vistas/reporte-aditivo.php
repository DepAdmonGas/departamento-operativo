<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT nombre, producto_uno, producto_dos, producto_tres FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}

$sql_lista = "SELECT * FROM op_bitacora_reporte WHERE id_estacion = '".$idEstacion."' ORDER BY id desc";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>



<div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Importación</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Reporte de aditivo (<?=$estacion;?>)</li>
  </ol>
  </div>

  <div class="row">
  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Reporte de Aditivo (<?=$estacion;?>)</h3>
  </div>

  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
  <button type="button" class="btn btn-labeled2 btn-danger float-end" onclick="SelBitacoraReturn(<?=$idEstacion;?>)">
  <span class="btn-label2"><i class="fa-solid fa-arrow-left"></i></span>Regresar</button>
  </div>
  </div>

  <hr>
  </div>


  <div class="table-responsive">
  <table id="tabla_reporte_aditivo_<?=$idEstacion?>" class="custom-table" style="font-size: 12.5px;" width="100%">

<thead class="tables-bg">
	<tr>
	<th class="align-middle text-center">#</th>
	<th class="align-middle text-center">Fecha</th>
	<th class="align-middle text-center">Hora</th>
	<th class="align-middle text-center" width="32px"><img class="pointer" src="<?=RUTA_IMG_ICONOS?>descargar.png"></th>
	<th class="align-middle text-center" width="32px"><img class="pointer" src="<?=RUTA_IMG_ICONOS?>eliminar.png"></th>
    </tr>
</thead>

<tbody class="bg-white">
<?php
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

echo '<tr>
<th class="align-middle text-center">'.$row_lista['id'].'</th>
<td class="align-middle ">'.FormatoFecha($row_lista['fecha']).'</td>
<td class="align-middle ">'.date("g:i a",strtotime($row_lista['hora'])).'</td>
<td class="align-middle text-center" width="32px"><a href="https://www.portal.admongas.com.mx/bitacora-aditivo/archivos/'.$row_lista['documento'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'descargar.png"></a></td>
<td class="align-middle text-center" width="32px"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarReporte('.$idEstacion.','.$id.')"></td>
</tr>';
}
}
?>
</tbody>
</table>
</div>

