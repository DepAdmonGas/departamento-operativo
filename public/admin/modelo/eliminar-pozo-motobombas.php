<?php
require('../../../app/help.php');

$sql1 = "DELETE FROM op_nivel_explosividad_pozo_motobomba WHERE id = '".$_POST['idNivel']."' ";
if (mysqli_query($con, $sql1)) {
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------