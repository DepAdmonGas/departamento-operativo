<?php
require '../../../app/help.php';

$idUsuario = $_POST['idUsuario'];
$stmt = $con->prepare("SELECT id FROM op_token_telegram WHERE id_usuario = ?");
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$stmt->store_result();
if($stmt->num_rows > 0){
  // Actualiza el estatus del token anterior para ya no ser usado
  $estatus = 1;
  $stmt = $con->prepare("UPDATE op_token_telegram SET estatus=? WHERE id_usuario = ?");
  $stmt->bind_param("ii", $estatus,$idUsuario);
  $stmt->execute();
  // Genera un nuevo token para ser usado en otro dispositivo
  $token = bin2hex(random_bytes(3));
  $sql = "INSERT INTO op_token_telegram (id_usuario,token,estatus) VALUES ('$idUsuario','$token',0)";
  $result = mysqli_query($con, $sql);
}
echo $token;