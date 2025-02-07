<?php
require('../../../app/help.php');
$idPlantilla = $_GET['idPlantilla'];

$sql_plantilla = "SELECT id_usuario, nombre, descripcion, documento_perfil, documento_contrato FROM tb_organigrama_plantilla WHERE id = '" . $idPlantilla . "'";
$result_plantilla  = mysqli_query($con, $sql_plantilla);
$numero_plantilla  = mysqli_num_rows($result_plantilla);


while ($row_lista_plantilla = mysqli_fetch_array($result_plantilla, MYSQLI_ASSOC)) {
$id_usuario = $row_lista_plantilla['id_usuario'];
$nombre_usuario = $row_lista_plantilla['nombre'];
$descripcion = $row_lista_plantilla['descripcion'];
$documento_perfil = $row_lista_plantilla['documento_perfil'];
$documento_contrato = $row_lista_plantilla['documento_contrato'];
}


if($id_usuario == 0){
$detalleNombre = $nombre_usuario;

}else{

$datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosPersonal($id_usuario);
$nombre_completo = $datosPersonal['nombre_personal'];
$detalleNombre = $nombre_completo;
}


if($documento_perfil == ""){
$docPerfil = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png"> ';
$docPerfilDelete = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png"> ';

}else{
$docPerfil = '<a href="'.RUTA_ARCHIVOS.'documentos/'.$documento_perfil.'" download> <img src="'.RUTA_IMG_ICONOS.'pdf.png"> </a>';
$docPerfilDelete = '<img onclick="EliminarCP('.$idPlantilla.',2)" src="'.RUTA_IMG_ICONOS.'eliminar.png"> ';
}

if($documento_contrato == ""){
$docContrato = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png"> ';
$docContratoDelete = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png"> ';

}else{
$docContrato = '<a href="'.RUTA_ARCHIVOS.'documentos/'.$documento_contrato.'" download> <img src="'.RUTA_IMG_ICONOS.'pdf.png"> </a>';
$docContratoDelete = '<img onclick="EliminarCP('.$idPlantilla.',1)" src="'.RUTA_IMG_ICONOS.'eliminar.png"> ';

}

 
?>

<div class="modal-header">
<h5 class="modal-title">Contrato y Perfil</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<div class="row">
	
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
<div class="mb-1"><small>Nombre completo:</small></div>
<?=$detalleNombre?>
</div>

<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2">
<div class="mb-1"><small>Descripción de Puesto:</small></div>
<?=$descripcion?>
</div>



<div class="col-12 mb-2">
<hr>
<div class="mb-1"><small>Nombre del archivo:</small></div>
<select class="form-select" id="NomDocumento">
<option></option>
<option>Contrato</option>
<option>Perfil</option>
</select>
</div>

<div class="col-12 mb-2">
<div class="mb-1"><small>Archivo:</small></div>
<input class="form-control" type="file" id="Archivo">
</div>

<div class="col-12">
<hr>
<button type="button" class="btn btn-labeled2 btn-success float-end mb-3" onclick="GuardarCP(<?=$idPlantilla;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>

</div>

<div class="table-responsive">
<table class="custom-table" style="font-size: .8em;" width="100%">

<thead class="tables-bg">
<tr>
<th class="text-center align-middle tableStyle font-weight-bold">Nombre del archivo</th>
<th class="text-center align-middle tableStyle font-weight-bold" width="42px"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
<th class="text-center align-middle tableStyle font-weight-bold" width="42px"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</tr>
</thead>


<tbody class="bg-light">
<tr>
<th class="text-center align-middle tableStyle font-weight-bold">Contrato</th>
<th class="text-center align-middle tableStyle font-weight-bold" width="42px"><?=$docContrato?></th>
<th class="text-center align-middle tableStyle font-weight-bold" width="42px"><?=$docContratoDelete?></th>
</tr>

<tr>
<th class="text-center align-middle tableStyle font-weight-bold">Perfil</th>
<th class="text-center align-middle tableStyle font-weight-bold" width="42px"><?=$docPerfil?></th>
<th class="text-center align-middle tableStyle font-weight-bold" width="42px"><?=$docPerfilDelete?></th>
</tr>
</tbody>

</table>
</div>


<div class="mt-3" id="Respuesta"></div>

</div>



