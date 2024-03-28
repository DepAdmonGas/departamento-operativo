<?php
require('../../../app/help.php');

$sql_listComunicados = "SELECT * FROM tb_comunicados_do ORDER BY fecha DESC";  
$result_listComunicados = mysqli_query($con, $sql_listComunicados);
$numero_listComunicados = mysqli_num_rows($result_listComunicados);

?>

<style media="screen">
 .car-admin{
  border: 1px solid #eeeeee;box-shadow: 1px 1px 5px #EDEDED;border-bottom: 3px solid #3399cc;border-radius: 0;
  }
</style>

<div class="row">

<?php

while($row_listComunicados = mysqli_fetch_array($result_listComunicados, MYSQLI_ASSOC)){
$GET_idComunicado = $row_listComunicados['id_comunicado'];

$titulo = $row_listComunicados['titulo'];
$archivo = $row_listComunicados['archivo'];

$explode = explode(' ', $row_listComunicados['fecha']);
$fecha_dia = FormatoFecha($explode[0]);

?>

<div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 mt-1 mb-2">
  <div class="card card-menuB rounded shadow-sm p-3 mb-2 pointer" onclick="detalleComunicado(<?=$GET_idComunicado;?>)">
                
    <div class="col-12 text-center">
      <h6><?=$titulo;?></h6>
      <img class="img-logo mt-2" src="<?php echo RUTA_IMG_ICONOS?>comunicado.png" style="width: 25%;">
    </div>

<p class="card-text text-center mt-3 text-secondary"><small class="text-secondary"><?=$fecha_dia;?></small></p>

  </div>
  </div>

 <?php
 }
 ?>
  

</div>
  

 