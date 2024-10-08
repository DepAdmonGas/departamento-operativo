<?php
require('../../../app/help.php');

$sql_insert = "UPDATE tb_organigrama_plantilla SET status = 1 WHERE id = '".$_POST['idPlantilla']."'";

if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------
