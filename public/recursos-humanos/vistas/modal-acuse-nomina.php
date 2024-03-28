<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$year = $_GET['year'];
$mes = $_GET['mes'];
$semana = $_GET['semana'];

if($semana == 1){
  $nombreSemana = "Primera Semana";

}else if($semana == 2){
  $nombreSemana = "Segunda Semana";

}else if($semana == 3){
  $nombreSemana = "Tercera Semana";

}else if($semana == 4){
  $nombreSemana = "Cuarta Semana";

}else if($semana == 5){
  $nombreSemana = "Quinta Semana";

}else if($semana == 6){
  $nombreSemana = "Primera Quincena";

}else if($semana == 7){
  $nombreSemana = "Segunda Quincena";

}else if($semana == 8){
  $nombreSemana = "Aguinaldo";
}


?>
 
      <div class="modal-header">
        <h5 class="modal-title">Acuses de Recibo de Nomina</h5>
        
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
            <input class="form-control" type="file" id="Documento">
          </div>


        </div>


<div class="border p-3 mt-3">

      <div class="text-end">
        <button type="button" class="btn btn-sm btn-primary" onclick="GuardarAcuse(<?=$idEstacion;?>,<?=$year;?>,<?=$mes;?>,<?=$semana;?>)">Agregar</button>
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

$sql_lista = "SELECT * FROM op_recibo_nomina_acuse WHERE id_estacion = '".$idEstacion."' AND year = '".$year."' AND mes = '".$mes."' AND periodo = '".$nombreSemana."' ORDER BY fecha ASC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

echo '<tr>'; 
echo '<td class="align-middle text-center">'.FormatoFecha($row_lista['fecha']).'</td>';
echo '<td class="align-middle text-center"><a href="'.RUTA_ARCHIVOS.'recibos-nomina/acuses/'.$row_lista['archivo'].'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a></td>';
echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="EliminarAcuse('.$id.','.$idEstacion.','.$year.','.$mes.','.$semana.')"></td>';
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
