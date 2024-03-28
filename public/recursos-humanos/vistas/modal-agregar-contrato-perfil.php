<?php
require('../../../app/help.php');

$idUsuario = $_GET['idUsuario'];

$sql_lista = "SELECT * FROM tb_usuarios_documentos WHERE id_usuario = '".$idUsuario."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>

<div class="modal-header">
<h5 class="modal-title">Agregar Contrato y Perfil</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="row">
	
	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
		<div class="mb-1"><small>Nombre archivo:</small></div>
		<select class="form-select" id="NomDocumento">
			<option></option>
			<option>Contrato</option>
			<option>Perfil</option>
		</select>
	</div>

	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
		<div class="mb-1"><small>Archivo:</small></div>
		<input class="form-control" type="file" id="Archivo">
	</div>
</div>

<div class="text-end">
<button type="button" class="btn btn-primary" onclick="GuardarCP(<?=$idUsuario;?>)">Guardar</button>
</div>

<div id="Respuesta"></div>
<hr>

<table class="table table-sm table-bordered">
<?php 
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$nombre = $row_lista['nombre'];
$archivo = $row_lista['archivo'];

?>
<tr>
<td><?=$nombre;?></td>
<td width="30px" class="text-center"><a href="archivos/documentos/<?=$archivo;?>" download><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></a></td>
<td width="30px" class="text-center"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png" onclick="EliminarCP(<?=$id;?>,<?=$idUsuario;?>)"></td>
</tr>	
<?php
}
}else{
echo "<tr><td colspan='3' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</table>

</div>
