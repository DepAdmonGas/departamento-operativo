 <?php
require('../../../app/help.php');

$sql = "DELETE FROM op_poliza_es WHERE id_poliza = '".$_POST['idPoliza']."' ";
if (mysqli_query($con, $sql)) {
echo 1;
} else {
echo 0;
}

//------------------
mysqli_close($con);
//------------------
?>