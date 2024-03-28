<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$NoDoc1  =   $_FILES['Documento_file']['name'];
$UpDoc1 = "../../../archivos/documentos-personal/solicitud-baja/".$aleatorio."-".$NoDoc1;


if(move_uploaded_file($_FILES['Documento_file']['tmp_name'], $UpDoc1)){
$NomDoc1 = $aleatorio."-".$NoDoc1;
}else{
$NomDoc1 = '';    
}

$sql_insert = "INSERT INTO op_rh_formatos_baja (
id_formulario,
id_personal,
id_estacion,
fecha_baja,
baja,
archivo
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    '".$_POST['Empleado']."',
    '".$_POST['idEstacion']."',
    '".$_POST['FechaBaja']."',
    '".$_POST['Baja']."',
    '".$NomDoc1."'
    )";

if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
}


//------------------
mysqli_close($con);
//------------------ 