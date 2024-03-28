<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$img = $_POST['base64'];
$img = str_replace('data:image/png;base64,', '', $img);
$fileData = base64_decode($img);
$fileName = $aleatorio.'.png';

function idReporte($con){
$sql = "SELECT id FROM op_rh_permisos ORDER BY id desc LIMIT 1";
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

if($_POST['tipo'] == 1){

$sql_insert = "INSERT INTO op_rh_permisos (
id,
id_estacion,
id_personal,

fecha_inicio,
fecha_termino,
dias_tomados,
cubre_turno,

motivo,
observaciones,
estado
    )
    VALUES 
    (
    '".$idReporte."',
    '".$_POST['Estacion']."',
   	'".$_POST['Colaborador']."',
   	'".$_POST['FechaInicio']."',
   	'".$_POST['FechaTermino']."',
   	'".$_POST['DiasTomados']."',
   	'".$_POST['Cubre']."',
    '".$_POST['Motivo']."',
   	'".$_POST['Observacion']."',
   	0
    )";

if(mysqli_query($con, $sql_insert)){

if(file_put_contents('../../../imgs/firma/'.$fileName, $fileData)){
$sql_insert2 = "INSERT INTO op_rh_permisos_firma (
id_permiso,
id_usuario,
tipo_firma,
firma
    )
    VALUES 
    (
    '".$idReporte."',
    '".$_POST['Colaborador']."',
    'A',
    '".$fileName."'
    )";

mysqli_query($con, $sql_insert2);
}

echo 1;
}else{
echo 0;
}

}else if($_POST['tipo'] == 2){

$sql2 = "UPDATE op_rh_permisos SET 
id_personal = '".$_POST['Colaborador']."',

fecha_inicio = '".$_POST['FechaInicio']."',
fecha_termino = '".$_POST['FechaTermino']."',

dias_tomados = '".$_POST['DiasTomados']."',

cubre_turno = '".$_POST['Cubre']."',
motivo = '".$_POST['Motivo']."',
observaciones = '".$_POST['Observacion']."'
WHERE id ='".$_POST['idPermiso']."' ";
if(mysqli_query($con, $sql2)){

$sqlEliminar = "DELETE FROM op_rh_permisos_firma WHERE id_permiso = '".$_POST['idPermiso']."' AND id_usuario = '".$_POST['Colaborador']."' ";
mysqli_query($con, $sqlEliminar);

if(file_put_contents('../../../imgs/firma/'.$fileName, $fileData)){
$sql_insert2 = "INSERT INTO op_rh_permisos_firma (
id_permiso,
id_usuario,
tipo_firma,
firma
    )
    VALUES
    (
    '".$_POST['idPermiso']."',
    '".$_POST['Colaborador']."',
    'A',
    '".$fileName."'
    )";

mysqli_query($con, $sql_insert2);
}

echo 1;

}else{
echo 0;
}

}else if($_POST['tipo'] == 3){

if(file_put_contents('../../../imgs/firma/'.$fileName, $fileData)){
$sql_insert2 = "INSERT INTO op_rh_permisos_firma (
id_permiso,
id_usuario,
tipo_firma,
firma
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    '".$Session_IDUsuarioBD."',
    '".$_POST['tipoFirma']."',
    '".$fileName."'
    )";

mysqli_query($con, $sql_insert2);

$sql = "UPDATE op_rh_permisos SET 
estado = 1
WHERE id = '".$_POST['idReporte']."' ";

mysqli_query($con, $sql);

}

echo 1;

}



//------------------
mysqli_close($con);
//------------------




