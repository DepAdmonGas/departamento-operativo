<?php
require('../../../app/help.php');
$idReporte = $_GET['idReporte'];
$idStatus = $_GET['idStatus'];

if($idStatus == 0){
$ocultarTb = "";  
}else{
$ocultarTb = "d-none";
}

?>

<div class="table-responsive">  
        <table class="table table-sm table-bordered mb-0" style="font-size: .9em;">
          <tr class="tables-bg">
            <th colspan="6" class="text-center align-middle ">DATOS DEL PROVEEDOR</th>
          </tr>
          <tr class="bg-light align-middle">
            <td><b>Razón Social</b></td>
            <td><b>Dirección</b></td>
            <td><b>Contacto</b></td>
            <td><b>Email</b></td>
            <td width="16px" class="<?=$ocultarTb?>"><img src="<?=RUTA_IMG_ICONOS?>editar-tb.png" width="20px"></td>
            <td width="16px" class="<?=$ocultarTb?>"><img src="<?=RUTA_IMG_ICONOS?>eliminar.png" width="20px"></td>
          </tr>
          <tbody>
          	<?php 
 
$sql = "SELECT * FROM op_orden_compra_proveedor WHERE id_ordencompra = '".$idReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero > 0) {
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

$id = $row['id'];

echo '<tr class="align-middle">
<td>'.$row['razon_social'].'</td>
<td>'.$row['direccion'].'</td>
<td>'.$row['contacto'].'</td>
<td>'.$row['email'].'</td>
<td class="'.$ocultarTb.'"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" width="20px" onclick="ModalEditarProveedor('.$id.','.$idReporte.')"></td>
<td class="'.$ocultarTb.'"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" width="20px" onclick="EliminarProveedor('.$id.','.$idReporte.')"></td>
</tr>';
} 
}else{
echo "<tr><td colspan='6' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}

          	?>
            
          </tbody>
       </table>
      </div> 