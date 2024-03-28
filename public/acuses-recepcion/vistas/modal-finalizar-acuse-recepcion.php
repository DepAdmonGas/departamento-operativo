<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql = "SELECT * FROM op_acuse_recepcion WHERE id = '".$idReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

$id = $row['id'];
$explode = explode(" ", $row['fecha_creacion']);
$Fecha = $explode[0];
$Hora = date("g:i a",strtotime($explode[1]));
$Empresa = $row['empresa'];

}

$sql_lista = "SELECT * FROM op_acuse_recepcion_documentos WHERE id_acuse = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);	

?> 


<div class="modal-header">
<h5 class="modal-title">Finalizar Acuses de Recepción</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body"> 

<div class="text-end"><small><?=FormatoFecha($Fecha);?>, <?=$Hora;?></small></div>
<div class="mt-1"><h6><?=$Empresa;?></h6></div>


<div class="text-secondary">Documentos:</div>
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">
 <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">#</th>
  <th class="align-middle text-center tableStyle font-weight-bold">Nombre del documento</th>
  <th class="align-middle text-center tableStyle font-weight-bold">Número paginas</th>
  <th class="align-middle text-center tableStyle font-weight-bold">Original</th>
  <th class="align-middle text-center tableStyle font-weight-bold">Copia</th>
  </tr>
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

	if($row_lista['original'] == 0){
    $Original = 'NO';
	}else{
	$Original = '<b>SI</b>';	
	}

	if($row_lista['copia'] == 0){
    $Copia = 'NO';
	}else{
	$Copia = '<b>SI</b>';	
	}

echo '<tr>';
echo '<td class="align-middle text-center">'.$num.'</td>';
echo '<td class="align-middle text-center">'.$row_lista['documento'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['paginas'].'</td>';
echo '<td class="align-middle text-center">'.$Original.'</td>';
echo '<td class="align-middle text-center">'.$Copia.'</td>';
echo '</tr>';

$num++;
}
}else{
echo "<tr><td colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>

<div class="mb-2 text-secondary mt-2">Quién recibe:</div>
<textarea class="form-control rounded-0" rows="1" id="QuienRecibe"></textarea>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="BTNFinalizar(<?=$idReporte;?>)">Finalizar</button>
</div>