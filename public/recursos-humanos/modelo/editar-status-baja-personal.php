<?php
require('../../../app/help.php');

$proceso = $_POST['Proceso'];
$status = $_POST['Status'];


if($status == 0){
     
if($proceso == "Finiquito"){
$estado = 2;
     
}else if($proceso == "Junta de conciliacion y arbitraje" || $proceso == "Demanda"){
$estado = 1;
}
      
}else if($status == 1){

if($proceso == "Junta de conciliacion y arbitraje" || $proceso == "Demanda"){
$estado = 2;

}
     
}


$sql_edit = "UPDATE op_rh_personal_baja_v2 SET 
status = ".$estado."
WHERE id_baja = '".$_POST['idBaja']."' ";

  
if(mysqli_query($con, $sql_edit)) {
$result = 1;
}else{
$result = 0;
}

echo $result;

//------------------
mysqli_close($con);
//------------------
?>


