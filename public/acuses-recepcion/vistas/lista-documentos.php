<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql_lista = "SELECT * FROM op_acuse_recepcion_documentos WHERE id_acuse = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);	

?>

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .8em;">
<thead class="tables-bg">
 <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">#</th>
  <th class="align-middle text-center tableStyle font-weight-bold">Nombre del documento</th>
  <th class="align-middle text-center tableStyle font-weight-bold">Número paginas</th>
  <th class="align-middle text-center tableStyle font-weight-bold">Original</th>
  <th class="align-middle text-center tableStyle font-weight-bold">Copia</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
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

echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$idReporte.','.$row_lista['id'].')"></td>';
echo '</tr>';

$num++;
}
}else{
echo "<tr><td colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>