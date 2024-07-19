<?php
require('../../../app/help.php'); 

$aleatorio = uniqid();

if (isset($_FILES['Contrato_file'])) {
$NoDoc  =   $_FILES['Contrato_file']['name'];
$UpDoc = "../../../archivos/contratos-es/".$aleatorio."-".$NoDoc;
$NomDoc = $aleatorio."-".$NoDoc;
}


if (isset($_FILES['Contrato_file'])) {
if(move_uploaded_file($_FILES['Contrato_file']['tmp_name'], $UpDoc)){

$sql_edit1 = "UPDATE op_contratos SET 
fecha = '".$_POST['FechaC']."',
descripcion = '".$_POST['DescripcionC']."',
archivo = '".$NomDoc."',
objeto = '".$_POST['Objeto']."',
proveedor = '".$_POST['Proveedor']."',
vencimiento = '".$_POST['Vencimiento']."',
firmas = '".$_POST['Firman']."',
comentario = '".$_POST['Comentario']."'
WHERE id_contratos ='".$_POST['idContrato']."' ";

if(mysqli_query($con, $sql_edit1)){
echo 1;
}else{
echo 0;
}

}else{
echo 0;
}

 
}else{

$sql_edit2 = "UPDATE op_contratos SET 
fecha = '".$_POST['FechaC']."',
descripcion = '".$_POST['DescripcionC']."',
objeto = '".$_POST['Objeto']."',
proveedor = '".$_POST['Proveedor']."',
vencimiento = '".$_POST['Vencimiento']."',
firmas = '".$_POST['Firman']."',
comentario = '".$_POST['Comentario']."'
WHERE id_contratos ='".$_POST['idContrato']."' ";

if(mysqli_query($con, $sql_edit2)){
echo 1;
}else{
echo 0;
}

}


//------------------
mysqli_close($con);
//------------------   
