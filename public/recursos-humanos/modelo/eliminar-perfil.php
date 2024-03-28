 <?php
require ('../../../app/help.php');

$id = $_POST['id'];

$sql_delete = "UPDATE op_rh_localidades_perfil SET 
status = 0
WHERE id = '".$id."' ";


if(mysqli_query($con, $sql_delete)) {
$result = 1;
}else{
$result = 0;
}

echo $result;

//------------------
mysqli_close($con);
//------------------
?>