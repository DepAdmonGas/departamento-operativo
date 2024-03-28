 <?php
require('../../../app/help.php');

$sql_edit = "UPDATE op_rh_personal SET 
sd = '".$_POST['SalarioD']."'
WHERE id = '".$_POST['idPersonal']."' ";


if(mysqli_query($con, $sql_edit)) {
$result = 1;
}else{
$result = 0;
}

echo $result;

//------------------
mysqli_close($con);
//------------------
?>