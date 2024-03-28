<?php
require('../../../app/help.php');
$tipo = $_GET['tipo'];


$sql_lista = "SELECT * FROM op_camioneta_saveiro_documentacion WHERE tipo = '".$tipo."' ORDER BY fecha DESC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


//---------- OBTENER NUMERO DE COMENTARIOS ----------
function ToComentarios($id,$con){
$sql_lista = "SELECT id FROM op_camioneta_saveiro_comentarios WHERE id_documento = '".$id."' ";
$result_lista = mysqli_query($con, $sql_lista);
            
return $numero_lista = mysqli_num_rows($result_lista);      
}
?>

<div class="border-0 p-3">
<div class="row">

<div class="col-10">
<h5><?=$tipo?></h5>
</div>

<div class="col-2">
<img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="NuevoDocumento('<?=$tipo?>')">
</div>

</div>

<hr>


<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0">
<thead class="tables-bg">
 <tr>
  <th class="align-middle tableStyle font-weight-bold text-center" width="60">No.</th>
  <th class="align-middle tableStyle font-weight-bold text-center">Fecha</th>
  <th class="align-middle tableStyle font-weight-bold text-center">Descripcion</th>

<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>archivo-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>comentario-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead> 

<tbody>
  
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$fecha = $row_lista['fecha'];
$descripcion = $row_lista['descripcion'];
$archivo = $row_lista['archivo'];

$ToComentarios = ToComentarios($id,$con);

if($ToComentarios > 0){
$Nuevo = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToComentarios.'</small></span></div>';
}else{
$Nuevo = ''; 
} 
 
echo '<tr >';
echo '<td class="align-middle text-center">'.$num.'</td>';
echo '<td class="align-middle">'.FormatoFecha($fecha).'</td>';
echo '<td class="align-middle text-center">'.$descripcion.'</td>';

echo '<td width="24px"><a href="'.RUTA_ARCHIVOS.'camioneta-saveiro/'.$archivo.'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'archivo-tb.png"></a></td>';
echo '<td class="align-middle text-center"><img class="pointer" width="20" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="EditarRegistro(\''.$tipo.'\','.$id.')" data-toggle="tooltip" data-placement="top" title="Editar"></td>';
echo '<td class="align-middle text-center">'.$Nuevo.'<img class="pointer" width="20" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" onclick="ModalComentario(\''.$tipo.'\','.$id.')" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
echo '<td class="align-middle text-center"><img class="pointer" width="20" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarRegistro(\''.$tipo.'\','.$id.')" data-toggle="tooltip" data-placement="top" title="Eliminar"></td>';

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