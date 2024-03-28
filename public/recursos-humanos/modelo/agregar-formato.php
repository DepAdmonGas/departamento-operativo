<?php
require('../../../app/help.php');


function idReporte($con){
$sql = "SELECT id FROM op_rh_formatos ORDER BY id desc LIMIT 1";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero == 0) {
$id = 1;
}else{
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$id = $row['id'] + 1;
}
}
return $id;
}

$idReporte = idReporte($con);

$sql_insert = "INSERT INTO op_rh_formatos  (
id,
id_localidad,
formato,
status
    )
    VALUES 
    (
    '".$idReporte."',
    '".$_POST['idEstacion']."',
    '".$_POST['Formato']."',
    0
    )";
    
if(mysqli_query($con, $sql_insert)){
echo $idReporte;	
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------ 