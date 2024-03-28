<?php 
require('../../../app/help.php');

$sql_lista = "SELECT * FROM op_formatos_lista WHERE estado = 1";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function Documento($id,$con){
$sql = "SELECT documento FROM op_formatos_lista_documento ORDER BY id desc LIMIT 1";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$documento = $row['documento'];
}
return $documento;	
}
?>
  

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0" style="font-size: .9em;">
<thead class="tables-bg">
  <tr> 
  <th class="text-center align-middle tableStyle font-weight-bold">#</th>
  <th class="align-middle tableStyle font-weight-bold">Fecha hora</th>
  <th class="align-middle tableStyle font-weight-bold">Nombre Formato</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>descargar.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  </tr>
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

$id = $row_lista['id'];

$Documento = Documento($id,$con);

$fechaExplode = explode(" ", $row_lista['fecha']);
$FechaFormato = FormatoFecha($fechaExplode[0]);
$HoraFormato = date("g:i a",strtotime($fechaExplode[1]));

echo '<tr>';
echo '<td class="text-center align-middle"><b>'.$num.'</b></td>';
echo '<td class="align-middle">'.$FechaFormato.', '.$HoraFormato.'</td>';
echo '<td class="align-middle">'.$row_lista['nombre'].'</td>';
echo '<td class="text-center align-middle"><a onclick="ModalDocumentos('.$id.')"><img class="pointer" src="'.RUTA_IMG_ICONOS.'descargar.png"></a></td>';
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