   <?php
require('../../../app/help.php');

$sql = "DELETE FROM op_poliza_incidencia WHERE id_poliza_incidencia = '".$_POST['idPolizaInc']."' ";
if (mysqli_query($con, $sql)) {
echo 1;
} else {
echo 0;
}

//------------------
mysqli_close($con);
//------------------
?>