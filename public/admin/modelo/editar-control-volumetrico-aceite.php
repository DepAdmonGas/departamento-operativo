<?php
require ('../../../app/help.php');

$sql_edit1 = "UPDATE op_control_volumetrico_resumen_aceites SET 
    volumetrico = '" . $_POST['Total'] . "'
    WHERE id_mes='" . $_POST['IdReporte'] . "' ";
    mysqli_query($con, $sql_edit1);


echo 1;

//------------------
mysqli_close($con);
//------------------
?>