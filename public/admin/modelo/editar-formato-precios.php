<?php
require('../../../app/help.php');

//----------VALOR DELIVERY ----------
if($_POST['num'] == 1){
$edit = "UPDATE op_formato_precios_detalle_c SET pemex = '".$_POST['valor']."' ";

}else if($_POST['num'] == 2){
$edit = "UPDATE op_formato_precios_detalle_c SET delivery_montera = '".$_POST['valor']."',  delivery_tuxpan = '".$_POST['valor']."'";

}else if($_POST['num'] == 4){
$edit = "UPDATE op_formato_precios_detalle_c SET delivery_vopak = '".$_POST['valor']."' ";

}else if($_POST['num'] == 14){
$edit = "UPDATE op_formato_precios_transporte SET precio = '".$_POST['valor']."' ";

}else if($_POST['num'] == 15){
$edit = "UPDATE op_formato_precios SET fecha = '".$_POST['valor']."'";

//----------VALOR PICK UP ----------

}else if($_POST['num'] == 9){
$edit = "UPDATE op_formato_precios_detalle_c SET pickup_tuxpan = '".$_POST['valor']."', pickup_montera = '".$_POST['valor']."'";

}else if($_POST['num'] == 10){
$edit = "UPDATE op_formato_precios_detalle_c SET pickup_vopak = '".$_POST['valor']."'";

}else if($_POST['num'] == 12){
$edit = "UPDATE op_formato_precios_detalle_c SET pickup_tizayuca = '".$_POST['valor']."'";

}else if($_POST['num'] == 13){
$edit = "UPDATE op_formato_precios_detalle_c SET pickup_puebla = '".$_POST['valor']."'";

}else if($_POST['num'] == 14){
$edit = "UPDATE op_formato_precios_transporte SET precio = '".$_POST['valor']."'";

}else if($_POST['num'] == 0){
$edit = "UPDATE op_formato_precios SET estatus = 1";

}
 

$sql = "$edit
WHERE id = '".$_POST['id']."' ";
if(mysqli_query($con, $sql)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------
?> 