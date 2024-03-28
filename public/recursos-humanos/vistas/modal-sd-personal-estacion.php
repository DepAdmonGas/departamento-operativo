<?php
require('../../../app/help.php');

$idPersonal = $_GET['idPersonal'];

$sql_personal = "SELECT nombre_completo, id_estacion, sd FROM op_rh_personal WHERE id = '".$idPersonal."' ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);

while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
$GET_idEstacion = $row_personal['id_estacion'];
$NombreCompleto = $row_personal['nombre_completo'];
$salario  = number_format($row_personal['sd'],2);


}

?>


<div class="modal-header">
<h5 class="modal-title">Salario Diario - <?=$NombreCompleto;?></h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>



<div class="modal-body">

<div class="row">

<div class="col-12 mb-2">    
<label class="text-secondary mb-1">Salario Diario</label><br>
<input class="form-control" type="text" id="SalarioD" value="<?=$salario?>"> 
</div>


</div>
</div>


      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="EditarSD(<?=$idPersonal?>,<?=$GET_idEstacion?>)">Editar Salario</button>
      </div> 