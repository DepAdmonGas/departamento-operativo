<?php
require('../../../app/help.php');

if($_POST['valCheck'] == 0){
 $valorCheckP = 1;
}else{
 $valorCheckP = 0; 	
}
 
if($_POST['num'] == 1){
$productoTb = "p1";	

}else if($_POST['num'] == 2){
$productoTb = "p2";	

}else if($_POST['num'] == 3){
$productoTb = "p3";	

}else if($_POST['num'] == 4){
$productoTb = "p4";	

}else if($_POST['num'] == 5){
$productoTb = "p5";	

}else if($_POST['num'] == 6){
$productoTb = "p6";	

}else if($_POST['num'] == 7){
$productoTb = "p7";	

}else if($_POST['num'] == 8){
$productoTb = "p8";	

}else if($_POST['num'] == 9){
$productoTb = "p9";	

}else if($_POST['num'] == 10){
$productoTb = "p10";	

}
 
 
$sql_update = "UPDATE op_formato_precios_detalle_c SET 
$productoTb = '".$valorCheckP."' 
WHERE id_precio = '".$_POST['idPrecio']."' AND producto = '".$_POST['producto']."'";


if(mysqli_query($con, $sql_update)){
echo 1;

}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------