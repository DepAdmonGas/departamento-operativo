<?php
require('../../../app/help.php');

$idEstacion = $_POST['idEstacion'];
$idPersonal = $_POST['idPersonal'];
   
$Percepciones = $_POST['Percepciones'];
$Deducciones = $_POST['Deducciones'];
$ISR = $_POST['ISR'];
$ISR2 = $_POST['ISR2'];
$Total = $_POST['Total'];

$year = $_POST['year'];
$mes = $_POST['mes'];
$Periodo = $_POST['Periodo'];

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
$UpDoc1 = "../../../archivos/recibos-nomina/".$numeroAleatorio."-ReciboNomina".$nombreUser.$numeroAleatorio2;
$NomDoc1 = $numeroAleatorio."-ReciboNomina".$nombreUser.$numeroAleatorio2;

if($Periodo == 1){
  $nombreSemana = "Primera semana";

}else if($Periodo == 2){
  $nombreSemana = "Segunda semana";

}else if($Periodo == 3){
  $nombreSemana = "Tercera semana";

}else if($Periodo == 4){
  $nombreSemana = "Cuarta semana";

}else if($Periodo == 5){
  $nombreSemana = "Quinta semana";

}else if($Periodo == 6){
  $nombreSemana = "Primera quincena";

}else if($Periodo == 7){
  $nombreSemana = "Segunda quincena";

}else if($Periodo == 8){
  $nombreSemana = "Aguinaldo";
}


if(move_uploaded_file($_FILES['Documento_file']['tmp_name'], $UpDoc1)){

$sql_insert2 = "INSERT INTO op_recibo_nomina (
id_estacion,
id_usuario,
id_personal_nomina,
percepciones,
deducciones,
isr,
isr_retenido,
total,
year,
mes,
periodo,
nomina,
status 
    )
    VALUES 
    (
    '".$idEstacion."',
    '".$Session_IDUsuarioBD."', 
    '".$idPersonal."', 
    '".$Percepciones."',
    '".$Deducciones."',
    '".$ISR."',
    '".$ISR2."',
    '".$Total."',
    '".$year."',
    '".$mes."',
    '".$nombreSemana."',
    '".$NomDoc1."',
    0
    )";

mysqli_query($con, $sql_insert2);
echo 1;

}else{
echo 0;

}


//------------------
mysqli_close($con);
//------------------  


