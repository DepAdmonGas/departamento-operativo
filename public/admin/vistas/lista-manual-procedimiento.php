 <?php
require('../../../app/help.php');

$sql_listManuales = "SELECT * FROM tb_manuales_do ORDER BY fecha DESC";  
$result_listManuales = mysqli_query($con, $sql_listManuales);
$numero_listManuales = mysqli_num_rows($result_listManuales);
 
?>
 
<style media="screen">
 .car-admin{
  border: 1px solid #eeeeee;box-shadow: 1px 1px 5px #EDEDED;border-bottom: 3px solid #3399cc;border-radius: 0;
  }
</style>

<div class="row">

<?php

if($numero_listManuales > 0){

while($row_listManuales = mysqli_fetch_array($result_listManuales, MYSQLI_ASSOC)){
$GET_idManual = $row_listManuales['id_manuales_do'];

$descripcion = $row_listManuales['descripcion'];
$documento = $row_listManuales['documento'];

$explode = explode(' ', $row_listManuales['fecha']);
$fecha_dia = FormatoFecha($explode[0]);

?>

<div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 mt-1 mb-2">
  <div class="card card-menuB rounded shadow-sm p-3 mb-2 pointer" onclick="detalleManuales(<?=$GET_idManual;?>)">
                
    <div class="col-12 text-center">
      <h6><?=$descripcion;?></h6>
      <img class="img-logo mt-2" src="<?php echo RUTA_IMG_ICONOS?>manual.png" style="width: 25%;">
    </div>

 
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
  

 