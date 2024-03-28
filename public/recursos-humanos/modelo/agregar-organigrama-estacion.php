<?php
require('../../../app/help.php');

function idVersion($idEstacion,$con){
$sql_usuario = "SELECT version FROM op_rh_organigrama_estacion WHERE id_estacion = '".$idEstacion."' ORDER BY version desc LIMIT 1";
$result_usuario = mysqli_query($con, $sql_usuario);
$numero_usuario = mysqli_num_rows($result_usuario);
if ($numero_usuario == 0) {
$numid = 1;
}else{
while($row_usuario = mysqli_fetch_array($result_usuario, MYSQLI_ASSOC)){
$numid = $row_usuario['version'] + 1;
}
}
return $numid;
}

$aleatorio = uniqid();
$File  =   $_FILES['seleccionArchivos_file']['name'];
$upload_folder = "../../../archivos/organigrama/".$aleatorio."-".$File;
$Imagen = $aleatorio."-".$File;
$idVersion = idVersion($_POST['idEstacion'],$con);

if(move_uploaded_file($_FILES['seleccionArchivos_file']['tmp_name'], $upload_folder)) {

$sql_insert = "INSERT INTO op_rh_organigrama_estacion (
id_estacion, version, archivo, observaciones
    )
    VALUES 
    (
    '".$_POST['idEstacion']."',
    '".$idVersion."',
    '".$Imagen."',
    '".$_POST['Observaciones']."'
    )";

if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
}

}else{
echo 0;
}






//------------------
mysqli_close($con);
//------------------