<?php
require('../../../app/help.php');

if($_POST['Tipo'] == 1){

$sql1 = "UPDATE op_rh_personal SET 
documentos = ''
WHERE id ='".$_POST['IdDato']."' ";
if(mysqli_query($con, $sql1)){
echo 1;
}else{
echo 0;
}

}else if($_POST['Tipo'] == 2){

$sql = "DELETE FROM op_rh_personal_documentos WHERE id= '".$_POST['IdDato']."' ";

	if (mysqli_query($con, $sql)) {
	echo 1;
	} else {
	echo 0;
	}

}

//------------------
mysqli_close($con);
//------------------