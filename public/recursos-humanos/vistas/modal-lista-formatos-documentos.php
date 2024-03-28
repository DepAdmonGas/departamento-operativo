<?php
require('../../../app/help.php');

$sql_lista = "SELECT * FROM op_lista_formatos";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>

<div class="modal-header">
<h5 class="modal-title">Descarga de formatos</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .8em;">
<thead>
	<tr class="tables-bg text-center">
		<th class="align-middle text-center">#</th>
		<th class="align-middle">Clave</th>
        <th class="align-middle">Nombre</th>
		<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>word.png" data-toggle="tooltip" data-placement="top" title="Descargar"></th>
	</tr>
</thead> 

<tbody>
<?php
$num = 1; 

if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$formato = $row_lista['formato'];
$nombre = $row_lista['nombre'];
$archivo = $row_lista['archivo'];

echo '<tr>';
echo '<td class="align-middle text-center"><b>'.$num.'</b></td>';
echo '<td class="align-middle text-center">'.$formato.'</td>';
echo '<td class="align-middle text-center">'.$nombre.'</td>';
echo '<td class="align-middle text-center"><a href="'.RUTA_ARCHIVOS.'lista-formatos/'.$archivo.'" download><img src="'.RUTA_IMG_ICONOS.'word.png" data-toggle="tooltip" data-placement="top" title="Descargar"></a></td>';

echo '</tr>';
$num++;
}

}else{
echo "<tr><td colspan='15' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}

?>


</tbody>


</table>
</div>

</div>


<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
</div>