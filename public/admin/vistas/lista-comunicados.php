<?php
require('../../../app/help.php');

$sql_listComunicados = "SELECT * FROM tb_comunicados_do ORDER BY fecha DESC";  
$result_listComunicados = mysqli_query($con, $sql_listComunicados);
$numero_listComunicados = mysqli_num_rows($result_listComunicados);

?>

<div class="row">
 
<?php

while($row_listComunicados = mysqli_fetch_array($result_listComunicados, MYSQLI_ASSOC)){
$GET_idComunicado = $row_listComunicados['id_comunicado'];

$titulo = $row_listComunicados['titulo'];
$archivo = $row_listComunicados['archivo'];

$explode = explode(' ', $row_listComunicados['fecha']);
$fecha_dia = FormatoFecha($explode[0]);

?>


<div class="col-xl-2 col-lg-2 col-md-4 col-sm-12 mt-1 mb-2" onclick="detalleComunicado(<?=$GET_idComunicado;?>)">
  <section class="card3 plan2 shadow-lg">
  <div class="inner2">
    
  <div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?>comunicado.png" draggable="false"/></div>
    
  <div class="product-info">
  <p class="mb-0 pb-0"><?=$fecha_dia;?></p>
  <h5><?=$titulo;?></h5>
  </div>

  </div>
  </section>
  </div>


 <?php
 }
 ?>
  

</div>
  

 