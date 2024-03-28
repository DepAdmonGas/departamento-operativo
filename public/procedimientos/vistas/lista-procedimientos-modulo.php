<?php
require('../../../app/help.php');

$idModulo = $_GET["idModulo"];

$sql_listProcedimiento = "SELECT * FROM op_procedimientos_modulos WHERE modulo = '".$idModulo."' ORDER BY fecha DESC";  
$result_listProcedimiento = mysqli_query($con, $sql_listProcedimiento);
$numero_listProcedimiento = mysqli_num_rows($result_listProcedimiento);

?>


<style media="screen">
 .car-admin{
  border: 1px solid #eeeeee;box-shadow: 1px 1px 5px #EDEDED;border-bottom: 3px solid #3399cc;border-radius: 0;
  }
</style>

<div class="row">

<?php

if ($numero_listProcedimiento > 0){

while($row_listProcedimiento = mysqli_fetch_array($result_listProcedimiento, MYSQLI_ASSOC)){
$GET_idProcedimiento = $row_listProcedimiento['id'];

$titulo = $row_listProcedimiento['titulo'];
$archivo = $row_listProcedimiento['archivo'];

$explode = explode(' ', $row_listProcedimiento['fecha']);
$fecha_dia = FormatoFecha($explode[0]);

?>

<div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 mt-2 mb-1">
  <div class="card card-menuB rounded shadow-sm p-3 mb-2 pointer" onclick="detalleProcedimiento(<?=$GET_idProcedimiento;?>)">
                
    <div class="col-12 text-center">
      <h6><?=$titulo;?></h6>
      <img class="img-logo mt-2" src="<?php echo RUTA_IMG_ICONOS?>procedimiento.png" style="width: 25%;">
    </div>

<p class="card-text text-center mt-3 text-secondary"><small class="text-secondary"><?=$fecha_dia;?></small></p>

  </div>
  </div>

 <?php
 }

 }else{

echo '<div class="col-12 pb-0 mb-0">
<div class="alert alert-secondary text-center mb-0" role="alert">
  No se encontró información para mostrar.
</div>
</div>';

 }

 ?>
  

</div>
