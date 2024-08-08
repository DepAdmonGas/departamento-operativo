<?php
require('../../../app/help.php');

$sql = "SELECT nombre, usuario, password FROM tb_usuarios WHERE usuario = '".$_POST['NomUsuario']."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

if($numero != 0){

$sql_edit = "UPDATE tb_usuarios SET 
usuario = '".$_POST['NomUsuario']."',
password = '".$_POST['PasswordOriginal']."'
WHERE id = '".$_POST['idUsuario']."' ";

if(mysqli_query($con, $sql_edit)){
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
?>