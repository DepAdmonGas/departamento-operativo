<?php
require('../../../app/help.php');

function idReporte($con){
$sql = "SELECT id FROM op_inventarios_diarios ORDER BY id desc LIMIT 1";
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

function Detalle($idReporte,$detalle,$sucursal,$destino,$con){

$sql_insert = "INSERT INTO op_inventarios_diarios_detalle  (
id_reporte,
detalle,
sucursal,
destino,
oct87,
oct91,
diesel
    )
    VALUES 
    (
    '".$idReporte."',
    '".$detalle."',
    '".$sucursal."',
    '".$destino."',
    '',
    '',
    ''
    )";

mysqli_query($con, $sql_insert);
}

$idReporte = idReporte($con);

$sql_insert = "INSERT INTO op_inventarios_diarios  (
id,
fecha,
estatus
    )
    VALUES 
    (
    '".$idReporte."',
    '',
    0
    )";


 if(mysqli_query($con, $sql_insert)){

Detalle($idReporte,'INVENTARIOS REALES','Palo solo',19,$con);
Detalle($idReporte,'INVENTARIOS REALES','San Agustin',20,$con);
Detalle($idReporte,'INVENTARIOS REALES','Interlomas',21,$con);
Detalle($idReporte,'INVENTARIOS REALES','Lago',22,$con);
Detalle($idReporte,'INVENTARIOS REALES','Gasomira',23,$con);
Detalle($idReporte,'INVENTARIOS REALES','Esmegas',24,$con);
Detalle($idReporte,'INVENTARIOS REALES','Xochimilco',38,$con);
Detalle($idReporte,'INVENTARIOS REALES','Bosque Real',0,$con);

//Detalle($idReporte,'CAPACIDAD ALMACENAJE','Palo solo',$con);
//Detalle($idReporte,'CAPACIDAD ALMACENAJE','San Agustin',$con);
//Detalle($idReporte,'CAPACIDAD ALMACENAJE','Interlomas',$con);
//Detalle($idReporte,'CAPACIDAD ALMACENAJE','Lago',$con);
//Detalle($idReporte,'CAPACIDAD ALMACENAJE','Gasomira',$con);
//Detalle($idReporte,'CAPACIDAD ALMACENAJE','Esmegas',$con);
//Detalle($idReporte,'CAPACIDAD ALMACENAJE','Xochimilco',$con);

 echo $idReporte;
 }else{
 echo 0;
 }

//------------------
mysqli_close($con);
//------------------