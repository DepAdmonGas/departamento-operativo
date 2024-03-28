<?php
require('../../../app/help.php');

$idPersonal = $_GET['idPersonal'];
$GET_year = $_GET['idYear'];
$GET_mes = $_GET['idMes'];


$sql_lista = "SELECT * FROM op_recibo_nomina WHERE id_personal_nomina = '".$idPersonal."' AND year='".$GET_year."' AND mes='".$GET_mes."' ORDER BY fecha ASC ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>

<div class="row">
  
<?php
if($numero_lista > 0){
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$GET_idNomina = $row_lista['id'];
$fecha = $row_lista['fecha'];

$explode = explode(" ", $fecha);
$fecha_desc = $explode[0];

$periodo = $row_lista['periodo'];
$status = $row_lista['status'];

if ($status == 1) {

$bgAlert = "bg-success";
$bgAlertImg = 'cheque.png';
$bgAlertCard = "card-menuB";

}else{
 
$bgAlert = "bg-danger";
$bgAlertImg = 'cheque_X.png';
$bgAlertCard = "card-menuB-disabled";

}
 
?>

<div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 mt-1 mb-2">

  <div class="card <?=$bgAlertCard;?> rounded shadow-sm p-3 mb-2 pointer" onclick="detalleNomina(<?=$GET_idNomina;?>)">
    
    <div class="row">

  <div class="col-12">
    <span class="badge <?=$bgAlert;?> rounded-circle float-end p-1">    
    <img class="float-start" src="<?=RUTA_IMG_ICONOS;?><?=$bgAlertImg;?>">
  </span>
  </div>

    <div class="col-12 text-center">
      <h6><?=$periodo;?></h6>
      <img class="img-logo mt-2" src="<?php echo RUTA_IMG_ICONOS?>nomina.png" style="width: 25%;">
    </div>

  </div>

<p class="card-text text-center mt-3 text-secondary"><small class="text-secondary"><?=FormatoFecha($fecha_desc)?></small></p>

  </div>

</div>





<?php
}
}else{
echo '
<div class="col-12 mt-2">
<div class="alert alert-secondary text-center" role="alert">
  No se encontró información para mostrar.
</div>
</div>';
}
?>



</div>
</div>








  