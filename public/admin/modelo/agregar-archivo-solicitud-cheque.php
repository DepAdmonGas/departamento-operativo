<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$NoDoc1  =   $_FILES['Archivo_file']['name'];
$UpDoc1 = "../../../archivos/".$aleatorio."-".$NoDoc1;
$NomDoc1 = $aleatorio."-".$NoDoc1;

if(move_uploaded_file($_FILES['Archivo_file']['tmp_name'], $UpDoc1)){
$sql_insert3 = "INSERT INTO op_solicitud_cheque_documento (
id_solicitud,
nombre,
documento
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    '".$_POST['Documento']."',
    '".$NomDoc1."'
    )";

if(mysqli_query($con, $sql_insert3)){

if($_POST['Documento'] == 'COTIZACIÓN'){
$sqlComent = "INSERT INTO op_solicitud_cheque_comentario (
    id_solicitud,
    id_usuario,
    comentario
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    '".$Session_IDUsuarioBD."',
    'Factura contra entrega.'
    )";
mysqli_query($con, $sqlComent);	
}

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