<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];


?>
<div class="modal-header">
<h5 class="modal-title">PDF</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
    <div class="modal-body">

    <div class="mb-2 mt-2 text-secondary">Archivo:</div>
    <input type="file" id="Archivo">


      <div class="text-right">
        <button type="button" class="btn btn-primary" onclick="AgregarPDF(<?=$idEstacion;?>)">Guardar</button>
      </div>

       <hr>

       <?php  

$sql = "SELECT * FROM op_pedido_pinturas_complementos_pdf WHERE id_estacion = '".$idEstacion."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

echo '<table class="table table-sm table-bordered">';

$i = 1;
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$id = $row['id'];

echo '<tr>
<td>'.$i.'</td>
<td class="text-center align-middle" width="20px" style="cursor: pointer;""><a href="../archivos/'.$row['archivo'].'" download><img src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>
<td class="text-center align-middle" width="20px" style="cursor: pointer;""><img src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="eliminar('.$id.','.$idEstacion.')"></td>
</tr>';


$i++;
}

echo '</table>';
?>
</div>

