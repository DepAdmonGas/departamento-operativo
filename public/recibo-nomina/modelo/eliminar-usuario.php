<?php
require('../../../app/help.php');

$sql_delete = "DELETE FROM op_recibo_nomina_v2
    WHERE id = '".$_POST['idReporte']."' 
    AND id_estacion = '".$_POST['idEstacion']."' 
    AND no_semana_quincena = '".$_POST['SemQui']."'";

if(mysqli_query($con, $sql_delete)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);