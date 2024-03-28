<?php
require('../../../app/help.php');

$IdReporte = $_GET['IdReporte'];
?>

      <div class="modal-header">
        <h5 class="modal-title">Pago de servicio</h5>
        
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>
      <div class="modal-body">

        <div class="row">
           

          <div class="col-12 mb-2">
            <div class="mb-1 text-secondary">Concepto</div>
            <select class="form-select" id="Concepto">
              <option value="">Selecciona una opcion...</option>
              <option value="Servicio de Agua">Servicio de Agua</option>
              <option value="Servicio de Luz">Servicio de Luz</option>
              <option value="Servicio de Teléfono">Servicio de Teléfono</option>
              <option value="Servicio de Internet">Servicio de Internet</option>
            </select>

          </div>


          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2 mb-2">
            <div class="mb-1 text-secondary">Recibo</div>
            <input class="form-control" type="file" id="Recibo">
          </div>


          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-2 mb-2">
            <div class="mb-1 text-secondary">Pago</div>
            <input class="form-control" type="file" id="Pago">
          </div>

        </div>


<div class="border p-3 mt-3">

      <div class="text-end">
        <button type="button" class="btn btn-sm btn-primary" onclick="GuardarServicio(<?=$IdReporte;?>)">Agregar</button>
      </div>

      <hr>

<div class="table-responsive">
      <table class="table table-sm table-bordered mb-0 pb-0" style="font-size: .9em;">
        <thead class="tables-bg">
          <th class="text-center align-middle font-weight-bold">Concepto</th>
          <th class="text-center align-middle font-weight-bold">Recibo</th>
          <th class="text-center align-middle font-weight-bold">Pago</th>
            <th class="text-center align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
        </thead> 
        <tbody>
         <?php

$sql_lista = "SELECT * FROM op_pago_servicios WHERE id_mes = '".$IdReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];



echo '<tr>';
echo '<td class="align-middle text-center">'.$row_lista['concepto'].'</td>';
echo '<td class="align-middle text-center"><a href="../../../archivos/'.$row_lista['recibo'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>';
echo '<td class="align-middle text-center"><a href="../../../archivos/'.$row_lista['pago'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarPago('.$IdReporte.','.$id.')"></td>';
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
