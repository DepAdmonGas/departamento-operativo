<?php
require('../../../app/help.php');

$aleatorio = uniqid();

function idBaja($con){
$sql = "SELECT id FROM op_rh_personal_baja ORDER BY id desc LIMIT 1";
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

$idBaja = idBaja($con);


$NoDoc1  =   $_FILES['ActaHechos_file']['name'];
$UpDoc1 = "../../../archivos/documentos-personal/solicitud-baja/".$aleatorio."-".$NoDoc1;
$NomDoc1 = '';

$NoDoc2  =   $_FILES['CartaRenuncia_file']['name'];
$UpDoc2 = "../../../archivos/documentos-personal/solicitud-baja/".$aleatorio."-".$NoDoc2;
$NomDoc2 = '';

$NoDoc3  =   $_FILES['Finiquito_file']['name'];
$UpDoc3 = "../../../archivos/documentos-personal/solicitud-baja/".$aleatorio."-".$NoDoc3;
$NomDoc3 = '';


$sql_insert = "INSERT INTO op_rh_personal_baja (
id, id_personal, fecha_baja, motivo, detalle, proceso, estado_proceso
    )
    VALUES 
    (
    '".$idBaja."',
    '".$_POST['idPersonal']."',
    '".$_POST['FechaBaja']."',
    '".$_POST['Motivo']."',
    '".$_POST['Detalle']."',
    '',
    0
    )";

if(mysqli_query($con, $sql_insert)){

if(move_uploaded_file($_FILES['ActaHechos_file']['tmp_name'], $UpDoc1)){
$NomDoc1 = $aleatorio."-".$NoDoc1;

$sql1 = "INSERT INTO op_rh_personal_baja_archivos (
id_baja, descripcion, archivo
    )
    VALUES 
    (
    '".$idBaja."',
    'Acta de hechos',
    '".$NomDoc1."'
    )";
mysqli_query($con, $sql1);
}

if(move_uploaded_file($_FILES['CartaRenuncia_file']['tmp_name'], $UpDoc2)){
$NomDoc2 = $aleatorio."-".$NoDoc2;

$sql2 = "INSERT INTO op_rh_personal_baja_archivos (
id_baja, descripcion, archivo
    )
    VALUES 
    (
    '".$idBaja."',
    'Carta de Renuncia',
    '".$NomDoc2."'
    )";
mysqli_query($con, $sql2);
}

if(move_uploaded_file($_FILES['Finiquito_file']['tmp_name'], $UpDoc3)){
$NomDoc3 = $aleatorio."-".$NoDoc3;

$sql3 = "INSERT INTO op_rh_personal_baja_archivos (
id_baja, descripcion, archivo
    )
    VALUES 
    (
    '".$idBaja."',
    'Finiquito',
    '".$NomDoc3."'
    )";
mysqli_query($con, $sql3);
}

$sql_edit = "UPDATE op_rh_personal SET 
estado = 0
WHERE id = '".$_POST['idPersonal']."' ";
mysqli_query($con, $sql_edit);

if($_POST['Motivo'] == 'Mala practica'){

$sqlListaN = "INSERT INTO op_rh_personal_lista_negra (
id_personal, fecha,  motivo, detalle
    )
    VALUES 
    (
    '".$_POST['idPersonal']."',
    '".$_POST['FechaBaja']."',
    '".$_POST['Motivo']."',
    '".$_POST['Detalle']."'
    )";
mysqli_query($con, $sqlListaN);

}

echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------