<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
?>


      <div class="modal-header">
        <h5 class="modal-title">Prueba de eficiencia</h5>
        
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>
      <div class="modal-body">

        <div class="row">
           

          <div class="col-12 mb-2">
            <div class="mb-1 text-secondary">Fecha:</div>
            <input class="form-control" type="date" id="Fecha">
          </div>
 
          <div class="col-12 mb-2 mb-2">
            <div class="mb-1 text-secondary">Archivo:</div>
            <input class="form-control" type="file" id="Archivo">
          </div>


        </div>


<div class="border p-3 mt-3">

      <div class="text-end">
        <button type="button" class="btn btn-sm btn-primary" onclick="GuardarArchivo(<?=$idEstacion;?>)">Agregar</button>
      </div>

      <hr> 

<div class="table-responsive">
      <table class="table table-sm table-bordered mb-0 pb-0" style="font-size: .9em;">
        <thead class="tables-bg">
          <th class="text-center align-middle font-weight-bold">Fecha</th>
            <th class="text-center align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
            <th class="text-center align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
        </thead> 
        <tbody>
         <?php

$sql_lista = "SELECT * FROM op_mantenimiento_preventivo_documentos WHERE id_estacion = '".$idEstacion."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

echo '<tr>'; 
echo '<td class="align-middle text-center">'.FormatoFecha($row_lista['fecha']).'</td>';
echo '<td class="align-middle text-center"><a href="'.RUTA_ARCHIVOS.'prueba-eficiencia/'.$row_lista['archivo'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarPrueba('.$id.','.$idEstacion.')"></td>';
echo '</tr>';

$num++;
}
}else{
echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?> 
        </tbody>
      </table>
    </div>

</div>

      </div>
