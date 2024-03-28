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



<div class="border-0 p-3">


    <div class="row">
    <div class="col-12">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="SelBitacoraReturn(<?=$idEstacion;?>)">
    
    <div class="row">
    <div class="col-12">
    <h5>Reporte aditivo, <?=$estacion;?></h5>
    </div>
    </div>

    </div>
    </div>

<hr> 

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0">
<thead class="tables-bg">
	<tr>
	<th class="align-middle text-center">#</th>
	<th class="align-middle">Fecha</th>
	<th class="align-middle">Hora</th>
	<th class="align-middle text-center" width="32px"></th>
	<th class="align-middle text-center" width="32px"></th>
    </tr>
</thead>
<tbody>
<?php
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

echo '<tr>
<td class="align-middle text-center">'.$row_lista['id'].'</td>
<td class="align-middle ">'.FormatoFecha($row_lista['fecha']).'</td>
<td class="align-middle ">'.date("g:i a",strtotime($row_lista['hora'])).'</td>
<td class="align-middle text-center" width="32px"><a href="https://www.portal.admongas.com.mx/bitacora-aditivo/archivos/'.$row_lista['documento'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'descargar.png"></a></td>
<td class="align-middle text-center" width="32px"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarReporte('.$idEstacion.','.$id.')"></td>
</tr>';
}
}else{
echo "<tr><td colspan='9' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

</div>
