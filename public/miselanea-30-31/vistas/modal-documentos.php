<?php
require('../../../app/help.php');

$idEstacion =  $_GET['idEstacion'];
$idDocumento = $_GET['idDocumento'];
$idYear =  $_GET['idYear'];

$sql = "SELECT * FROM op_miselanea_documentos WHERE id = '".$idDocumento."' ";
  $result = mysqli_query($con, $sql);
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
  $idlista = $row['id_lista'];
  $documento = $row['documento'];
}

?> 


<div class="modal-header">
<h5 class="modal-title"><?=$idlista;?>. <?=$documento;?> <?=$idYear;?></h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<?php if($Session_IDUsuarioBD != 415){ ?>
<div><small class="text-secondary fs-6 fw-bold">Detalle:</small></div>
<textarea id="Detalle" class="form-control"></textarea>

<div class="mt-2"><small class="text-secondary fs-6 fw-bold">Documento:</small></div>
<input type="file" class="mt-1 form-control" id="Documento">
<?php } ?>

<div class="table-responsive">
<table class="custom-table mt-3" style="font-size: 12.5px;" width="100%">
<thead class="tables-bg">
<tr>
<th>Detalle</th>
<th class="text-center align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>descargar.png"></th>
<th class="text-center align-middle" width="24"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</tr>
</thead> 

<tbody class="bg-light">
<?php
$sql_lista = "SELECT * FROM op_miselanea_documentos_archivo WHERE id_estacion = '".$idEstacion."' AND year = '".$idYear."' AND id_documento = '".$idDocumento."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

if($Session_IDUsuarioBD == 415){
$Eliminar = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png">';
}else{
$Eliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$idDocumento.','.$id.','.$idEstacion.','.$idYear.')">';	
}

echo '<tr>';
echo '<td class="align-middle p-2">'.$row_lista['detalle'].'</td>';
echo '<td class="align-middle p-2"><a href="'.RUTA_ARCHIVOS.''.$row_lista['archivo'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'descargar.png"></a></td>';
echo '<td class="align-middle p-2">'.$Eliminar.'</td>';
echo '</tr>';

}
}else{
echo "<tr><th colspan='3' class='text-center text-secondary fw-normal no-hover2'><small>No se encontró información para mostrar </small></th></tr>";
}
?>
	
</tbody>
</table>
</div>

</div>


<?php if($Session_IDUsuarioBD != 415){ ?>
<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-success" onclick="Guardar(<?=$idDocumento;?>,<?=$idEstacion;?>,<?=$idYear;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>
<?php } ?>

