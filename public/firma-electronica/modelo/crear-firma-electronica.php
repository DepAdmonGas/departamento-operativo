<?php
require('../../../app/help.php');

$Usuario = $_POST['Usuario'];
$Password = $_POST['Password'];

function ValidaFirma($idUsuario,$con){

$sql = "SELECT id FROM tb_usuario_firma_electronica WHERE id_usuario = '".$idUsuario."' AND estatus = 1 LIMIT 1";	
$result_root = mysqli_query($con, $sql);
$num_result = mysqli_num_rows($result_root);
if ($num_result > 0) {

while($row_root = mysqli_fetch_array($result_root, MYSQLI_ASSOC)) {
$idFirma = $row_root['id'];

$sql = "UPDATE tb_usuario_firma_electronica SET 
estatus = 0
WHERE id = '".$idFirma."' ";
mysqli_query($con, $sql);

}

}
}

$sql = "SELECT id FROM tb_usuarios WHERE usuario = '".$Usuario."' AND password ='".$Password."' LIMIT 1";	
$result_root = mysqli_query($con, $sql);
$num_result = mysqli_num_rows($result_root);
if ($num_result > 0) {

while($row_root = mysqli_fetch_array($result_root, MYSQLI_ASSOC)) {
$idUsuario = $row_root['id'];
}

if($Session_IDUsuarioBD == $idUsuario){

$valida = ValidaFirma($idUsuario,$con);

$tokenFirma = bin2hex(random_bytes(3000));
$filename = "FIRMA ELECTRONICA-".uniqid().".cer";

$fecha_vencimiento = date("Y-m-d",strtotime($fecha_del_dia."+ 2 year"));

$sql_insert = "INSERT INTO tb_usuario_firma_electronica (
    id_usuario,
    codigo,
    nombre,
    fecha_creacion,
    fecha_vencimiento,
    estatus
    )
    VALUES 
    (
    '".$idUsuario."',
    '".$tokenFirma."',
    '".$filename."',
    '".$fecha_del_dia."',
    '".$fecha_vencimiento."',
    1
    )";

if(mysqli_query($con, $sql_insert)){

$Result = array (
"result"  => 1,
"tokenFirma" => $tokenFirma,
"filename" => $filename
);

}else{

$Result = array (
"result"  => 0,
"tokenFirma" => 0,
"filename" => 0
);

}

}else{

$Result = array (
"result"  => 0,
"tokenFirma" => 0,
"filename" => 0
);

}


}else{

$Result = array (
"result"  => 0,
"tokenFirma" => 0,
"filename" => 0
);

}

;

echo json_encode($Result);


//------------------
mysqli_close($con);
//------------------
?>