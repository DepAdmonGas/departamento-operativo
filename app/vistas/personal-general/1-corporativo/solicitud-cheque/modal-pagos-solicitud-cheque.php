<?php
require('../../../../../app/help.php');

$idReporte = $_GET['idReporte'];
$year = $_GET['year'];
$mes = $_GET['mes'];

$sql_lista = "SELECT * FROM op_solicitud_cheque_documento WHERE id_solicitud = '".$idReporte."' AND nombre = 'PAGO' ORDER BY id DESC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>
<div class="modal-header">
<h5 class="modal-title">Pagos</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<?php
if($session_nompuesto == "Gestoria"){
echo '<div class="mb-1 text-secondary fw-bold">* DOCUMENTO:</div>
<div class="input-group">
<input type="file" class="form-control rounded-0" id="Documento">
</div>

<hr>';
}  
?>
 
<div class="table-responsive">
<table class="custom-table" style="font-size: 14px;" width="100%">
<thead>
<tr class="tables-bg align-middle text-center">
<th class="align-middle text-center">Fecha</th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
</tr>
</thead>

<tbody class="bg-light">
<?php
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$id = $row_lista['id'];
$explode = explode(' ', $row_lista['fecha']);
echo '<tr>';  
echo '<th class="align-middle font-weight-light">'.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).'</th>';
echo '<td class="align-middle font-weight-light"><a href="'.RUTA_ARCHIVOS.''.$row_lista['documento'].'" download><img src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>';
echo '</tr>';

}
}else{
echo "<tr><th colspan='2' class='text-center text-secondary no-hover2'><small>No se encontró información para mostrar </small></th></tr>";
}
?>
</tbody>
</table>
</div>
</div>

<?php if($session_nompuesto == "Gestoria"){ ?>

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="AgregarPago(<?=$year?>,<?=$mes?>,<?=$idReporte?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Agregar</button>
</div>

<?php } ?>
