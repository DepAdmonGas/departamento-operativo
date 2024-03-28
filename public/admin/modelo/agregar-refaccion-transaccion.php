<?php
require('../../../app/help.php');

$aleatorio = uniqid();

function idReporte($con){
$sql = "SELECT id FROM op_refacciones_transaccion ORDER BY id desc LIMIT 1";
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

$idReporte = idReporte($con);

$idEstacion = $_POST['idEstacion'];
$idRefacccion = $_POST['idRefacccion'];
$idEstacionR = $_POST['idEstacionR'];
$idRefaccionE = $_POST['idRefaccionE'];
$check = $_POST['check'];
$Observaciones = $_POST['Observaciones'];


$img = $_POST['base64'];
$img = str_replace('data:image/png;base64,', '', $img);
$fileData = base64_decode($img);
$fileName = $aleatorio.'.png';

 $sqlRS = "SELECT * FROM op_refacciones WHERE id = '".$idRefacccion."'";
 $resultRS = mysqli_query($con, $sqlRS);
 $numeroRS = mysqli_num_rows($resultRS);
 while($rowRS = mysqli_fetch_array($resultRS, MYSQLI_ASSOC)){
 $nombre = $rowRS['nombre'];
 $imagen = $rowRS['imagen'];
 $costo = $rowRS['costo'];
 $modelo = $rowRS['modelo'];
 $marca = $rowRS['marca'];
 $proveedor = $rowRS['proveedor'];
 $contacto = $rowRS['contacto'];
 $area = $rowRS['area'];
 $archivo = $rowRS['archivo'];
 $unidad = $rowRS['unidad'];
 }

 if($unidad != 0){
 if($idRefaccionE == 0){
 if($check == 0){
 echo 3;	
 }else{
 $idRefaccionN = AgregarRefaccion($idEstacionR,$nombre,$imagen,$costo,$modelo,$marca,$proveedor,$contacto,$area,$archivo,$con);
 $Agregar = Agregar($idReporte,$idEstacion,$idRefacccion,$idEstacionR,$idRefaccionN,$fileData,$fileName,
 	$Session_IDUsuarioBD,$unidad,$Observaciones,$con);
 echo $Agregar;
 }
 }else{

 ActRefaccion($idRefaccionE,$con);
 $Agregar = Agregar($idReporte,$idEstacion,$idRefacccion,$idEstacionR,$idRefaccionE,$fileData,$fileName,
 	$Session_IDUsuarioBD,$unidad,$Observaciones,$con);
 echo $Agregar;
 }
 }else{
 echo 2;
 }

 function ActRefaccion($idRefaccionE,$con){

$sql = "SELECT unidad FROM op_refacciones WHERE id = '".$idRefaccionE."'";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$unidad = $row['unidad'];
}

$Piezas = $unidad + 1; 

$sql_edit = "UPDATE op_refacciones SET 
    unidad = '".$Piezas."'
    WHERE id = '".$idRefaccionE."' ";
    mysqli_query($con, $sql_edit);

return true;
 }


 function Agregar($idReporte,$idEstacion,$idRefacccion,$idEstacionR,$idRefaccionE,$fileData,$fileName,$Session_IDUsuarioBD,$unidad,$Observaciones,$con)
 {

 	$AcUnidad = $unidad - 1;

 $sql_insert2 = "INSERT INTO op_refacciones_transaccion (
 id,
id_estacion,
id_refaccion,
id_estacion_receptora,
id_refaccion_receptora,
piezas,
observaciones,
estado
    )
    VALUES 
    (
    '".$idReporte."',
    '".$idEstacion."',
    '".$idRefacccion."',
    '".$idEstacionR."',
    '".$idRefaccionE."',
    1,
    '".$Observaciones."',
    0
    )";

if(mysqli_query($con, $sql_insert2)){

if(file_put_contents('../../../imgs/firma/'.$fileName, $fileData)){

$sql_insert2 = "INSERT INTO op_refacciones_transaccion_firma (
id_reporte,
id_usuario,
tipo_firma,
firma
    )
    VALUES 
    (
    '".$idReporte."',
    '".$Session_IDUsuarioBD."',
    'A',
    '".$fileName."'
    )";

mysqli_query($con, $sql_insert2);

$sql_edit3 = "UPDATE op_refacciones SET 
    unidad = '".$AcUnidad."'
    WHERE id = '".$idRefacccion."' ";
mysqli_query($con, $sql_edit3);

}

$resultado = 1;
}else{
$resultado = 0;
}
return $resultado;	

 }

 function idRefaccion($con){
$sql_usuario = "SELECT id FROM op_refacciones ORDER BY id desc LIMIT 1";
$result_usuario = mysqli_query($con, $sql_usuario);
$numero_usuario = mysqli_num_rows($result_usuario);
if ($numero_usuario == 0) {
$numid = 1;
}else{
while($row_usuario = mysqli_fetch_array($result_usuario, MYSQLI_ASSOC)){
$numid = $row_usuario['id'] + 1;
}
}
return $numid;
}

 function AgregarRefaccion($idEstacion,$nombre,$imagen,$costo,$modelo,$marca,$proveedor,$contacto,$area,$archivo,$con){

 	$idRefaccion = idRefaccion($con);

 	$sql_insert = "INSERT INTO op_refacciones (
id,
id_estacion,
nombre,
imagen,
unidad,
costo,
modelo,
marca,
proveedor,
contacto,
area,
archivo,
status
    )
    VALUES 
    (
    '".$idRefaccion."',
    '".$idEstacion."',
    '".$nombre."',
    '".$imagen."',
    1,
    '".$costo."',
    '".$modelo."',
    '".$marca."',
    '".$proveedor."',
    '".$contacto."',
    '".$area."',
    '".$archivo."',
    1
    )";
    
if(mysqli_query($con, $sql_insert)){

$sql_insert2 = "INSERT INTO op_refacciones_unidades (
id_refaccion,
unidad
    )
    VALUES 
    (
    '".$idRefaccion."',
    1
    )"; 

    if(mysqli_query($con, $sql_insert2)){
    $Return = $idRefaccion;
    }else{
    $Return = 0;    
    }



}else{
$Return = 0;
}

return $Return;
}

//------------------
mysqli_close($con);
//------------------