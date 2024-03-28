<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idTPV = $_GET['idTPV'];

$sql_lista = "SELECT * FROM op_terminales_tpv WHERE id = '".$idTPV."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$tpv = $row_lista['tpv'];
$noserie = $row_lista['no_serie'];
$modelo = $row_lista['modelo'];
$lote = $row_lista['no_lote'];
$tipoconexion = $row_lista['tipo_conexion'];
$noafiliacion = $row_lista['no_afiliacion'];
$telefono = $row_lista['telefono'];
$estado = $row_lista['estado'];
$rollos = $row_lista['rollos'];
$cargadores = $row_lista['cargadores'];
$pedestales = $row_lista['pedestales'];
$status = $row_lista['status'];
}


?>

<div class="modal-header">
<h5 class="modal-title">Falla TPV: <?=$tpv;?>, No DE SERIE: <?=$noserie;?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	
</button>
</div>
<div class="modal-body">

<?php if($status == 1){ ?>
<div class="text-end">
<button type="button" class="btn btn-primary btn-sm" style="font-size: .8em;" onclick="ModalNuevaFalla(<?=$idEstacion;?>, <?=$idTPV;?>)">Nueva</button>
</div>
<hr>
<?php } ?>
 
<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .9em;">
<thead class="tables-bg">
<th class="align-middle text-center">#</th>
<th class="align-middle">FECHA FALLA</th>
<th class="align-middle">FALLA</th>
<th class="align-middle">ESTADO</th>
<th class="align-middle text-center" width="16"><img width="16px" src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
<th class="align-middle text-center" width="16"><img width="16px" src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
</thead>
<tbody>
<?php
$sql = "SELECT * FROM op_terminales_tpv_reporte WHERE id_tpv = '".$idTPV."' ORDER BY id DESC ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero > 0) {
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$idFalla = $row['id'];
$explode = explode(" ", $row['fechacreacion']);

if($row['status'] == 0){
$fondo = "table-warning";
$estado = "<small class='text-danger'>Pendiente</small>";
}else{
$fondo = "";  
$estado = "<small class='text-secondary'>Finalizada</small>";
}

echo '<tr class="'.$fondo.'">';
echo '<td class="align-middle text-center">'.$row['id'].'</td>';
echo '<td class="align-middle">'.FormatoFecha($explode[0]).'</td>';
echo '<td class="align-middle">'.$row['falla'].'</td>';
echo '<td class="align-middle">'.$estado.'</td>';
echo '<td class="align-middle text-center"><img class="pointer" width="16px" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="ModalDetalleFalla('.$idFalla.','.$idTPV.','.$idEstacion.')"></td>';
echo '<td class="align-middle text-center"><img class="pointer" width="16px" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="ModalEditarFalla('.$idFalla.','.$idTPV.','.$idEstacion.')"></td>';
echo '</tr>';
}
}else{
echo "<tr><td colspan='6' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

</div>
