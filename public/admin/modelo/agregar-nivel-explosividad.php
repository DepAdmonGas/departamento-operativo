<?php 
require('../../../app/help.php');

$idEstacion = $_POST['idEstacion'];

function id($con){
$sql = "SELECT id FROM op_nivel_explosividad ORDER BY id desc LIMIT 1";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero == 0) {
$numid = 1;
}else{
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$numid = $row['id'] + 1;
}
}
return $numid;
}

function folio($idEstacion,$con){
$sql = "SELECT folio FROM op_nivel_explosividad WHERE id_estacion = '".$idEstacion."' ORDER BY id desc LIMIT 1";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero == 0) {
$numid = 1;
}else{
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$numid = $row['folio'] + 1;
}
}
return $numid;
}

    $id = id($con);
    $folio = folio($idEstacion,$con);

    $sql_insert = "INSERT INTO op_nivel_explosividad (
    id,
    id_estacion,
    folio,
    fecha,
    estado
    )
    VALUES 
    (
    '".$id."',
    '".$idEstacion."',
    '".$folio."',
    '',
    0
    )"; 

    if(mysqli_query($con, $sql_insert)){
    echo $id;
    }else{
    echo 0;    
    }

    //------------------
mysqli_close($con);
//------------------