 <?php
require('../../../app/help.php');

$sql_estaciones = "SELECT * FROM op_rh_localidades WHERE numlista <= 8 OR numlista = 12 OR numlista = 22 OR numlista = 23 ORDER BY numlista ASC";
$result_estaciones = mysqli_query($con, $sql_estaciones);
$numero_estacion = mysqli_num_rows($result_estaciones);

function nombreEstaciones($numlista,$con){

  if($numlista <= 8){
  $sql_estaciones2 = "SELECT razonsocial FROM tb_estaciones WHERE numlista = '".$numlista."' ";
  $result_estaciones2 = mysqli_query($con, $sql_estaciones2);
  $numero_estaciones2 = mysqli_num_rows($result_estaciones2);

  while($row_estaciones2 = mysqli_fetch_array($result_estaciones2, MYSQLI_ASSOC)){
    $nombre_ES2 = strtoupper($row_estaciones2['razonsocial']);
  }


  }else if($numlista == 12){
    $nombre_ES2 = "DEPARTAMENTO";

  }else if($numlista == 22){
    $nombre_ES2 = "COMERCIALIZALIZADORA DE ARTICULOS GASOLINEROS S.A. DE C.V.";

  }else if($numlista == 23){
    $nombre_ES2 = "COMERCIAL GASOLINERA QUITARGA S.A. DE C.V.";
  }

  return $nombre_ES2;

}


function imagenesES($numlista){
  
  if($numlista == 22 || $numlista == 23){
  $img_ES = "camion.png";
 
  }else if($numlista == 12){
  $img_ES = "oficina.png";
 
  }else{
  $img_ES = "gasolinera-csf.png";
  }

  return $img_ES;
}

?>

 <div class="row">
 <?php
 while($row_estaciones = mysqli_fetch_array($result_estaciones, MYSQLI_ASSOC)){
 $GET_idEstacion = $row_estaciones['id'];
 
 $no_lista = $row_estaciones['numlista'];
 $nombre_ES = $row_estaciones['localidad'];
 $razonsocial = nombreEstaciones($no_lista,$con);
 $imagenesES = imagenesES($no_lista);


 ?>
 
  <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mt-1 mb-2" onclick="estacionesCSF(<?=$GET_idEstacion?>)">   
  <section class="card3 plan2 shadow-lg">
  <div class="inner2">
    
  <div class="product-image"><img src="<?=RUTA_IMG_ICONOS;?><?=$imagenesES?>" draggable="false"/></div>
    
  <div class="product-info">
  <p class="mb-0 pb-0"><?=$razonsocial?></p>
  <h2><?=$nombre_ES?></h2>
  </div>

  </div>
  </section>
  </div>


 <?php
 }
 ?>
  

</div>
  
 



  