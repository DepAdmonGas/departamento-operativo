<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];

$sql = "DELETE FROM op_rh_rol_comodines WHERE id = '".$idReporte."' ";

if (mysqli_query($con, $sql)) {
echo 1;
} else {
echo 0;
}

//------------------
mysqli_close($con);
//------------------
?>