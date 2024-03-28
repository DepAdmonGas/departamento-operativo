   <?php
require('../../../app/help.php');

$sql = "DELETE FROM op_contratos WHERE id_contratos = '".$_POST['idContrato']."' ";
if (mysqli_query($con, $sql)) {
echo 1;
} else {
echo 0;
}

//------------------
mysqli_close($con);
//------------------
?>