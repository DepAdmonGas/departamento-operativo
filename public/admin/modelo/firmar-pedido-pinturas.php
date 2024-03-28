<?php 
require('../../../app/help.php');

$token = uniqid();
$idReporte = $_POST['idReporte'];
$contenido = $_POST['contenido'];

$sql_firma = "SELECT id, id_usuario FROM tb_usuario_firma_electronica WHERE codigo = '".$contenido."' AND estatus = 1 ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
if($numero_firma == 1){

while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){
$id = $row_firma['id'];
$idUsuario = $row_firma['id_usuario'];
}

$sql_personal = "SELECT id_puesto FROM tb_usuarios WHERE id = '".$idUsuario."' ";
$result_personal = mysqli_query($con, $sql_personal);
while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
$idpuesto = $row_personal['id_puesto'];
}

if($idpuesto == 3 OR $idpuesto ==  13){

$sql_insert = "INSERT INTO op_pedido_pinturas_complementos_firma (
	token,
    id_firma,
    id_pedido,
    fecha,
    hora
    )
    VALUES 
    (
    '".$token."',
    '".$id."',
    '".$idReporte."',
    '".$fecha_del_dia."',
    '".$hora_del_dia."'
    )";

if(mysqli_query($con, $sql_insert)){


$sql_edit = "UPDATE op_pedido_pinturas_complementos SET 
status = 2
WHERE id = '".$idReporte."' ";

if(mysqli_query($con, $sql_edit)){
echo 3;
}else{
echo 2;
}


}else{
echo 2;
}


}else{
echo 1;		
}


}else{
echo 0;	
}


//------------------
mysqli_close($con);
//------------------