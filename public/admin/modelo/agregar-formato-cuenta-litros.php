<?php 
require('../../../app/help.php');

$idEstacion = $_POST['idEstacion'];
$year = $_POST['year'];
$mes = $_POST['mes'];

function idCuentaLitros($con){
$sql = "SELECT id_cuenta_litros  FROM op_cuenta_litros  ORDER BY id_cuenta_litros DESC LIMIT 1";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero == 0) {
$numid = 1;
}else{
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$numid = $row['id_cuenta_litros'] + 1;
}
}
return $numid;
}


$idCuentaLitros = idCuentaLitros($con);


    $sql_insert = "INSERT INTO op_cuenta_litros (
    id_cuenta_litros,
    id_estacion,
    fecha,
    year,
    mes,
    estatus
    )
    VALUES 
    ( 
    '".$idCuentaLitros."',
    '".$idEstacion."',
    '".$fecha_del_dia."',
    '".$year."',
    '".$mes."',
    0)"; 


    if(mysqli_query($con, $sql_insert)){
    echo $idCuentaLitros;
    }else{
    echo 0;    
    }


?>