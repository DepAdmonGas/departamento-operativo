 <?php
require('../../../app/help.php');

$aleatorio = uniqid();

$NoDoc1  =   $_FILES['Documento_file']['name'];
$UpDoc1 = "../../../archivos/recibos-nomina/acuses/".$aleatorio."-".$NoDoc1;
$NomDoc1 = $aleatorio."-".$NoDoc1;

$idEstacion = $_POST['idEstacion'];
$year = $_POST['year'];
$mes = $_POST['mes'];
$Periodo = $_POST['semana'];
$fecha = $_POST['fecha'];


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

$sql_insert2 = "INSERT INTO op_recibo_nomina_acuse (
id_estacion,
year,
mes,
periodo,
fecha,
archivo 
    )
    VALUES 
    (
    '".$idEstacion."',
    '".$year."',
    '".$mes."',
    '".$nombreSemana."',
    '".$fecha."',
    '".$NomDoc1."'
    )";

mysqli_query($con, $sql_insert2);
echo 1;

}else{
echo 0;

}


//------------------
mysqli_close($con);
//------------------  


