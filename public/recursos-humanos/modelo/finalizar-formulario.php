<?php
require('../../../app/help.php');

$sql_lista = "SELECT * FROM op_rh_formatos WHERE id = '".$_POST['idReporte']."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$formato = $row_lista['formato'];	
}

if($formato == 1 || $formato == 2 || $formato == 4 || $formato == 6){
$Estatus = 1;	
}else{
$Estatus = 2;	
}

$sql1 = "UPDATE op_rh_formatos SET 
status = '".$Estatus."'
WHERE id ='".$_POST['idReporte']."' ";
if(mysqli_query($con, $sql1)){
echo 1;
}else{
echo 0;
}



//------------------
mysqli_close($con);
//------------------