<?php
require('../../../../../app/help.php');

$idListaNegra = $_GET['idListaNegra'];

$sql_archivos_baja = "SELECT * FROM op_rh_personal_lista_negra_archivos WHERE id_lista_negra = '".$idListaNegra."'";
$result_archivos_baja = mysqli_query($con, $sql_archivos_baja);
$numero_archivos_baja = mysqli_num_rows($result_archivos_baja);
   
?> 

<div class="modal-header">
<h5 class="modal-title">Pruebas</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
<div class="row">

<div class="col-12 mb-2">  
<div class="mb-1 text-secondary fw-bold">* DESCRIPCIÓN:</div>
<input type="text" class="form-control rounded-0" id="DescripcionArchivo">
</div>
 
<div class="col-12 mb-2">  
<div class="mb-1 text-secondary fw-bold">* ARCHIVO:</div>
<input type="file" class="form-control" id="Archivo">
</div>

</div>

<hr>


<div class="text-end">
<button type="button" class="btn btn-labeled2 btn-success" onclick="subirArchivoLN(<?=$idListaNegra;?>)">
<span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
</div>


<div class="table-responsive">
<table class="custom-table mt-3" style="font-size: .8em;" width="100%">

<thead class="tables-bg">
<tr>
<th class="align-middle text-center">Descripción:</th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</tr>
</thead>
<tbody>
<?php
 
if ($numero_archivos_baja > 0) {
while($row_archivos_baja = mysqli_fetch_array($result_archivos_baja, MYSQLI_ASSOC)){

$GET_idArchivo = $row_archivos_baja['id'];
$descripcionDoc = $row_archivos_baja['descripcion'];
$archivo = $row_archivos_baja['archivo'];


echo '<tr class="text-center bg-light">';
echo '<td class="align-middle">'.$descripcionDoc.'</td>';
echo '<td class="align-middle"><a href="'.RUTA_ARCHIVOS.'/documentos-personal/solicitud-baja/'.$archivo.'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>';
echo '<th class="align-middle text-center pointer" width="20" onclick="eliminarArchivoLN('.$GET_idArchivo.','.$idListaNegra.')"><img src="'.RUTA_IMG_ICONOS.'eliminar.png"></th>';
echo '</tr>';

}

}else{
echo "<tr class='bg-light'><th colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar</small></th></tr>";	
}

 


?>
</tbody>
</table>
</div>

</div>
    

