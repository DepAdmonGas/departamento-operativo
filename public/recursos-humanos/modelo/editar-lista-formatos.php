<?php
require ('../../../app/help.php');

$idDocumento = $_POST['idDocumento'];
$Formato = $_POST['Formato'];
$Clave = $_POST['Clave'];

$sql_edit = "UPDATE op_lista_formatos SET 
formato = '".$Clave."',
nombre = '".$Formato."'
WHERE id = '".$idDocumento."' ";

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