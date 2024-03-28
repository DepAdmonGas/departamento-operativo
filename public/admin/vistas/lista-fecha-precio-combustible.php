<?php
require('../../../app/help.php');

$sql_lista = "SELECT id, fecha FROM op_precio_combustible GROUP BY fecha ORDER BY fecha desc";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);


	if ($numero_lista > 0) {
   echo '<div class="row">';
	while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

	$timestamp = strtotime($row_lista['fecha']);

  echo '  <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mb-2 mt-2 ">
  <div class="card card-menuB rounded shadow-sm pointer" onclick="Detalle('.$timestamp.')">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon "> 
  <i class="fa-solid fa-calendar-days color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <h6>'.FormatoFecha($row_lista['fecha']).'</h6> 
  </div>
  </div>

  </div>
  </div>'; 

}
   echo '</div>';

}else{

echo '<div class="alert alert-secondary text-center" role="alert">
  No se encontró información para mostrar
</div>';	

}


