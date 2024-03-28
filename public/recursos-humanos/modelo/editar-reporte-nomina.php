<?php
require('../../../app/help.php');

$idPersonal = $_POST['idPersonal'];

function PersonalNomina($idPersonal, $con){
    $sql = "SELECT 
    op_rh_personal.no_colaborador, 
    op_rh_personal.nombre_completo, 
    op_rh_puestos.puesto 
    FROM op_rh_personal 
    INNER JOIN op_rh_puestos ON op_rh_personal.puesto = op_rh_puestos.id
    WHERE op_rh_personal.id = '".$idPersonal."' ";
  
    $result = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $nombreNomina = $row['nombre_completo'];
    }
  
    return $nombreNomina; 
  
    }
  
  //$aleatorio = uniqid();
  $numeroAleatorio = rand(1, 1000000);
  
  //$aleatorio = uniqid();
  $numeroAleatorio2 = rand(1000, 9999);
  
  $nombreUser = PersonalNomina($idPersonal,$con);

$NoDoc1  =   $_FILES['Documento_file']['name'];
$UpDoc1 = "../../../archivos/recibos-nomina/firmados/".$numeroAleatorio."-FirmaNomina".$nombreUser.$numeroAleatorio2;
$NomDoc1 = $numeroAleatorio."-FirmaNomina".$nombreUser.$numeroAleatorio2;

if(move_uploaded_file($_FILES['Documento_file']['tmp_name'], $UpDoc1)){

$sql_insert1 = "INSERT INTO op_recibo_nomina_documento (
id_nomina,
id_usuario,
documento
    )
    VALUES 
    (
    '".$_POST['id']."',
    '".$Session_IDUsuarioBD."',
    '".$NomDoc1."'
    )";

mysqli_query($con, $sql_insert1);

$sql2 = "UPDATE op_recibo_nomina SET 
status = 1
WHERE id ='".$_POST['id']."' ";
if(mysqli_query($con, $sql2)){
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