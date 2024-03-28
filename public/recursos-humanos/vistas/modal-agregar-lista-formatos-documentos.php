<?php
require('../../../app/help.php');

$idDocumento = $_GET['idDocumento'];

$sql = "SELECT nombre FROM op_formatos_lista WHERE id = '".$idDocumento."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}


$sql_lista = "SELECT * FROM op_formatos_lista_documento WHERE id_formato = '".$idDocumento."' ORDER BY id DESC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


?>
<div class="modal-header">

<h5 class="modal-title">Formatos</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<h6><?=$nombre;?></h6>

<?php if($session_idpuesto == 13){ ?>
<div class="mb-1 mt-2">* Archivo</div>
<div class="row">
	<div class="col-10">
    <input class="form-control" type="file" id="seleccionArchivos">
	</div>
	<div class="col-2 text-end">
		<button type="button" class="btn btn-primary" onclick="GuardarDocumento(<?=$idDocumento;?>)">Guardar</button>
	</div>
</div>
<hr>
<?php } ?>

<div><small class="text-secondary">Versiones de documentos</small></div>
<table class="table table-sm table-bordered table-hover mb-0 mt-2" style="font-size: .9em;">
<thead class="tables-bg">
  <tr> 
  <th class="text-center align-middle tableStyle font-weight-bold">#</th>
  <th class="align-middle tableStyle font-weight-bold">Fecha hora</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>descargar.png"></th>
  </tr>
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$id = $row_lista['id'];

$fechaExplode = explode(" ", $row_lista['fecha']);
$FechaFormato = FormatoFecha($fechaExplode[0]);
$HoraFormato = date("g:i a",strtotime($fechaExplode[1]));

echo '<tr>';
echo '<td class="text-center align-middle"><b>'.$num.'</b></td>';
echo '<td class="align-middle">'.$FechaFormato.', '.$HoraFormato.'</td>';
echo '<td class="text-center align-middle"><a href="archivos/formatos/'.$row_lista['documento'].'" ><img class="pointer" src="'.RUTA_IMG_ICONOS.'descargar.png"></a></td>';
echo '</tr>';

$num++;
}
}else{
echo "<tr><td colspan='7'><div class='text-secondary text-center p-2 fs-6 fw-light'>No se encontró información para mostrar </div></td></tr>";	
}
?>
</tbody>
</table>


</div>

