<?php
require('../../../app/help.php');

$NomPuesto = $_POST['NomPuesto'];
$idPuesto = $_POST['idPuesto'];
$Tipo = $_POST['Tipo'];

if($Tipo == 0){

$sql_insert = "INSERT INTO op_rh_puestos  (
puesto,
status
    )
    VALUES 
    (
    '".$NomPuesto."',
    1
    )";
if(mysqli_query($con, $sql_insert)){
echo 1;	
}else{
echo 0;
}

}else if($Tipo == 1){

$sql1 = "UPDATE op_rh_puestos SET 
puesto = '".$NomPuesto."'
WHERE id ='".$idPuesto."' ";
if(mysqli_query($con, $sql1)){
echo 1;
}else{
echo 0;
}

}

//------------------
mysqli_close($con);
//------------------