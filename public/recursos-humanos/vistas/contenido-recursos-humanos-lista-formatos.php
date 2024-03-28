<?php 
require('../../../app/help.php');

$sql_lista = "SELECT * FROM op_lista_formatos";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>
  

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">
  <tr> 
  <th class="align-middle text-center">#</th>
  <th class="align-middle text-center">Clave del formato</th>
  <th class="align-middle text-center">Nombre del formato</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>word.png" data-toggle="tooltip" data-placement="top" title="Descargar"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  </tr>
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {
$num = 1;
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
echo '<td class="text-center align-middle"><a onclick="ModalEditar('.$id.')"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png"></a></td>';
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