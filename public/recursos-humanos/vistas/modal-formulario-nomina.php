<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$esdep = $_GET['esdep'];
$year = $_GET['year'];
$mes = $_GET['mes'];
$semana = $_GET['semana'];

if($semana == 1){
  $nombreSemana = "Primera semana";

}else if($semana == 2){
  $nombreSemana = "Segunda semana";

}else if($semana == 3){
  $nombreSemana = "Tercera semana";

}else if($semana == 4){
  $nombreSemana = "Cuarta semana";

}else if($semana == 5){
  $nombreSemana = "Quinta semana";

}else if($semana == 6){
  $nombreSemana = "Primera quincena";

}else if($semana == 7){
  $nombreSemana = "Segunda quincena";

}else if($semana == 8){
  $nombreSemana = "Aguinaldo";
}
 
$sql_personal = "SELECT
op_rh_personal.id,
op_rh_personal.id_estacion,
op_rh_personal.nombre_completo,
op_rh_personal.puesto AS idPuesto,
op_rh_puestos.puesto
FROM op_rh_personal
INNER JOIN op_rh_puestos 
ON op_rh_personal.puesto = op_rh_puestos.id
WHERE op_rh_personal.id_estacion = '".$idEstacion."' AND op_rh_personal.estado = 1 ORDER BY op_rh_personal.id ASC ";

$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);

function personalLista($idPersonal,$year,$mes,$semana,$con){

$sql_personal = "SELECT * FROM op_recibo_nomina WHERE id_personal_nomina = '".$idPersonal."' AND year = '".$year."' AND mes = '".$mes."' AND periodo = '".$semana."' ";

$result_personal = mysqli_query($con, $sql_personal);
return $numero_personal = mysqli_num_rows($result_personal);

}

?>

<div class="modal-header">
<h5 class="modal-title">Agregar recibo de nomina</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

      <div class="modal-body">

        <div class="mb-1 text-secondary">Nombre del Personal:</div>
        <select class="form-select" id="Personal">
          
          <option></option>

          <?php
          while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
          $idPersonal = $row_personal['id'];
          $nombrePersonal = $row_personal['nombre_completo'];

          $personalLista =  personalLista($idPersonal,$year,$mes,$nombreSemana,$con);

          if($personalLista == 1){
            $ocultarOption = "d-none";
         
          }else{
            $ocultarOption = "";

          }
 
          echo '<option class="'.$ocultarOption.'" value="'.$idPersonal.'">'.$nombrePersonal.'</option>';

          }
          ?>

        </select>
 

        <div class="text-secondary mt-2">Percepciones:</div>
        <input class="form-control" type="number" id="Percepciones">

        <div class="text-secondary mt-2">Deducciones:</div>
        <input class="form-control" type="number" id="Deducciones">

        <div class="text-secondary mt-2">ISR:</div>
        <input class="form-control" type="number" id="ISR">

        <div class="text-secondary mt-2">ISR retenido:</div>
        <input class="form-control" type="number" id="ISR2">


        <div class="text-secondary mt-2">Total:</div>
        <input class="form-control" type="number" id="Total">

        <div class="text-secondary mt-2">Recibo de Nomina:</div>
        <input class="form-control" type="file" id="Documento">

      </div>
          <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="AgregarDocumento(<?=$idEstacion;?>,<?=$year;?>,<?=$mes;?>,<?=$semana;?>)">Agregar</button>
      </div>
