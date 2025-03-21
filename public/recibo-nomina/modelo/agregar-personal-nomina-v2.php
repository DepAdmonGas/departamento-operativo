<?php
require('../../../app/help.php');

$cadena = implode(",", $_POST['personal']);
$array = explode(",", $cadena);

for ($i=0; $i < count($array) ; $i++) { 

$sql_usuarios = "SELECT puesto FROM op_rh_personal WHERE id = '".$array[$i]."' ";
$result_usuarios = mysqli_query($con, $sql_usuarios);
$numero_usuarios = mysqli_num_rows($result_usuarios);
$row_usuarios = mysqli_fetch_array($result_usuarios, MYSQLI_ASSOC);
$puesto = $row_usuarios['puesto'];

$sql_insert = "INSERT INTO op_recibo_nomina_v2 (
    year,
    mes,
    no_semana_quincena,
    descripcion,
    id_estacion,
    id_usuario,
    id_puesto,
    importe_total,
    nomina_original,
    prima_vacacional
    ) 
    VALUES 
    (
    '".$_POST['year']."',
    '".$_POST['mes']."',
    '".$_POST['noSemQuin']."',
    '".$_POST['descripcion']."',
    '".$_POST['idEstacion']."',
    '".$array[$i]."',
    '".$puesto."',
    0,0,0
    )";
    

$result = mysqli_query($con, $sql_insert);
}

echo ($result) ? true : false;

//------------------
mysqli_close($con);
//------------------