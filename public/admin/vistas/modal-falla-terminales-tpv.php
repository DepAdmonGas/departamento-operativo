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
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">


<div class="table-responsive">
<table id="tabla_bitacora" class="custom-table" style="font-size: .9em;" width="100%">

<thead class="tables-bg">
<th class="align-middle text-center">#</th>
<th class="align-middle">Fecha de falla</th>
<th class="align-middle">Falla</th>
<th class="align-middle">Estado</th>
<th class="align-middle text-center" width="16"><img width="16px" src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
<th class="align-middle text-center" width="16"><img width="16px" src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
</thead>
 
<tbody class="bg-light">
<?php
$sql = "SELECT * FROM op_terminales_tpv_reporte WHERE id_tpv = '".$idTPV."' ORDER BY id DESC ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero > 0) {
$num = 1;
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$idFalla = $row['id'];
$explode = explode(" ", $row['fechacreacion']);
 
if($row['status'] == 0){
$fondo = 'style="background-color: #ffb6af"'; 
$estado = "<small class='text-danger'>Pendiente</small>";
$nohover = "no-hoverRed";
}else{
$fondo = "";  
$estado = "<small class='text-secondary'>Finalizada</small>";
$nohover = "no-hover2";
}
 
echo '<tr '.$fondo.'>';
echo '<th class="align-middle text-center '.$nohover.'">'.$num.'</th>';
echo '<td class="align-middle '.$nohover.'">'.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).'</td>';
echo '<td class="align-middle '.$nohover.'">'.$row['falla'].'</td>';
echo '<td class="align-middle '.$nohover.'">'.$estado.'</td>';
echo '<td class="align-middle text-center '.$nohover.'"><img class="pointer" width="16px" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="ModalDetalleFalla('.$idFalla.','.$idTPV.','.$idEstacion.')"></td>';
echo '<td class="align-middle text-center '.$nohover.'"><img class="pointer" width="16px" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="ModalEditarFalla('.$idFalla.','.$idTPV.','.$idEstacion.')"></td>';
echo '</tr>';
$num++;
}
}else{
echo "<tr><td colspan='6' class='text-center text-secondary no-hover2'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

</div>



<?php if($status == 1){ ?>
<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-primary" onclick="ModalNuevaFalla(<?=$idEstacion;?>, <?=$idTPV;?>)">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar falla</button>
</div>
<?php } ?>
 