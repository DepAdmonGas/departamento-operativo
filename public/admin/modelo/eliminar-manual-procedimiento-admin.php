<?php
require('../../../app/help.php');

$sql1 = "DELETE FROM tb_manuales_do WHERE id_manuales_do = '".$_POST['id']."' ";
if (mysqli_query($con, $sql1)) {
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------