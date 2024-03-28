 <?php
require('../../../app/help.php');

$id = $_GET['id'];
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
 
$sql_personal = "SELECT * FROM op_recibo_nomina
WHERE id = '".$id."' ";

$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);

while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){

$percepciones = $row_personal['percepciones'];
$deducciones = $row_personal['deducciones'];
$isr = $row_personal['isr'];
$isr_retenido = $row_personal['isr_retenido'];
$total = $row_personal['total'];

}

?>

<div class="modal-header">
<h5 class="modal-title">Agregar recibo de nomina</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

      <div class="modal-body">

        <div class="text-secondary mt-2">Percepciones:</div>
        <input class="form-control" type="number" id="Percepciones" value="<?=$percepciones?>">

        <div class="text-secondary mt-2">Deducciones:</div>
        <input class="form-control" type="number" id="Deducciones" value="<?=$deducciones?>">

        <div class="text-secondary mt-2">ISR:</div>
        <input class="form-control" type="number" id="ISR" value="<?=$isr?>">

        <div class="text-secondary mt-2">ISR retenido:</div>
        <input class="form-control" type="number" id="ISR2" value="<?=$isr_retenido?>">


        <div class="text-secondary mt-2">Total:</div>
        <input class="form-control" type="number" id="Total" value="<?=$total?>">

        <div class="text-secondary mt-2">Recibo de Nomina:</div>
        <input class="form-control" type="file" id="Documento">

      </div>
          <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="EditarNominaServer(<?=$id;?>,<?=$idEstacion;?>,<?=$year;?>,<?=$mes;?>,<?=$semana;?>)">Editar</button>
      </div>
