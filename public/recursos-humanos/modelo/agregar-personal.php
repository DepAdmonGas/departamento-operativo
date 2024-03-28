<?php
require('../../../app/help.php');

function idPersonal($con){
$sql_usuario = "SELECT id FROM op_rh_personal ORDER BY id desc LIMIT 1";
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



$idEstacion = $_POST['idEstacion'];
$Tipo = $_POST['Tipo'];
$NombresCompleto = $_POST['NombresCompleto'];
$Puesto = $_POST['Puesto'];
$CURP = $_POST['CURP'];
$SD = $_POST['SD'];

if($Tipo == 0){

$idPersonal = idPersonal($con);

if($Puesto == 5 || $Puesto == 9){
$idEstacion = 9;
}else{
$idEstacion = $idEstacion;
}

$sql_insert = "INSERT INTO op_rh_personal (
id, id_estacion, fecha_ingreso, nombre_completo, puesto, curp, rfc, nss, sd, documentos, estado
    )
    VALUES 
    (
    '".$idPersonal."',
    '".$idEstacion."',
    '".$_POST['FechaIngreso']."',    
    '".$NombresCompleto."',
    '".$Puesto."',
    '".$CURP."',
    '".$_POST['RFC']."',
    '".$_POST['NSS']."',
    '".$SD."',
    '',
    1
    )";

    
if(mysqli_query($con, $sql_insert)){

$sql_insert2 = "INSERT INTO op_rh_personal_acceso (
id_personal, huella, pin
    )
    VALUES 
    (
    '".$idPersonal."',
    '',
    0
    )";

if(mysqli_query($con, $sql_insert2)){
echo 1;
}else{
echo 0;
}

}else{
echo 0;
}


}else{
$idPersonal = $_POST['idPersonal'];

$sql_edit = "UPDATE op_rh_personal SET 
nombre_completo = '".$NombresCompleto."',
puesto = '".$Puesto."',
curp = '".$CURP."',
sd = '".$SD."',
fecha_ingreso = '".$_POST['FechaIngreso']."',
rfc = '".$_POST['RFC']."',
nss = '".$_POST['NSS']."'
WHERE id = '".$idPersonal."' ";

if(mysqli_query($con, $sql_edit)) {
echo 1;
}else{
echo 0;
}

}


//------------------
mysqli_close($con);
//------------------