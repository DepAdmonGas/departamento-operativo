<?php 
require('../../../app/help.php');
$idReporte = $_GET['idReporte'];

function Evidencia($idReporte,$Detalle,$con)
{

$Contenido .= '<div class="row">';
$sql = "SELECT * FROM op_orden_mantenimiento_entregables
WHERE id_mantenimiento = '".$idReporte."' AND detalle = '".$Detalle."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

$Contenido .= '<div class="col-6 bg-light p-2">
<img class="float-end mb-1 pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$idReporte.','.$row['id'].')">
<img width="100%" src="../../archivos/'.$row['archivo'].'" />
</div>';

}
$Contenido .= '</div>';
return $Contenido;
}
?>

<div class="border p-3 mb-3">

<div class="row">

<div class="col-12">
<img class="float-end pointer" onclick="btnModal(<?=$idReporte;?>)" src="<?=RUTA_IMG_ICONOS;?>agregar.png">
</div>

</div>

<hr>

<div class="table-responsive">
      <table class="table table-sm table-bordered mb-0" style="font-size: .9em;">
         <tr class="tables-bg">
           <th colspan="2">Entregables del trabajo realizado</th>
         </tr>
         <tr class="bg-light">
           <td class="text-center"><b>Antes</b></td>
           <td class="text-center"><b>Despues</b></td>
         </tr>
         <tbody>
         	<tr>
         		<td class="p-3">
         		<?=Evidencia($idReporte,'Antes',$con);?>
         		</td>
         		<td class="p-3">
         		<?=Evidencia($idReporte,'Despues',$con);?>
         		</td>
         	</tr>
         </tbody>
       </table>
</div>

</div>