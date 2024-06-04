<?php
require ('../../../app/help.php');

$horario = $_POST['horario'];
$dia = $_POST['dia'];
$idPersonal = $_POST['idPersonal'];
$idReporte = $_POST['idReporte'];

$sql = "SELECT * FROM op_rh_personal WHERE id = '" . $idPersonal . "' ";
$result = mysqli_query($con, $sql);
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $idEstacion = $row['id_estacion'];
}

if ($idEstacion == 9) {
    $idEstacionHorario = 2;
} else {
    $idEstacionHorario = $idEstacion;
}

function NomDia($dia)
{
    if ($dia == "1")
        $dia = "Lunes";
    if ($dia == "2")
        $dia = "Martes";
    if ($dia == "3")
        $dia = "Miércoles";
    if ($dia == "4")
        $dia = "Jueves";
    if ($dia == "5")
        $dia = "Viernes";
    if ($dia == "6")
        $dia = "Sábado";
    if ($dia == "7")
        $dia = "Domingo";
    return $dia;
}

$NomDia = NomDia($dia);

if ($horario == "Descanso") {
    $HoraEntrada = "00:00:00";
    $HoraSalida = "00:00:00";
} else {

    $sql = "SELECT * FROM op_rh_localidades_horario WHERE id_estacion = '" . $idEstacionHorario . "' AND titulo = '" . $horario . "' ";
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $HoraEntrada = $row['hora_entrada'];
        $HoraSalida = $row['hora_salida'];
    }
}


$sql1 = "SELECT * FROM op_rh_personal_horario_programar_detalle WHERE id_reporte = '" . $idReporte . "' AND id_personal = '" . $idPersonal . "' AND dia = '" . $NomDia . "' ";
$result1 = mysqli_query($con, $sql1);
$numero1 = mysqli_num_rows($result1);
if ($numero1 > 0) {

    $sql2 = "UPDATE op_rh_personal_horario_programar_detalle SET 
horario = '" . $horario . "',
hora_entrada = '" . $HoraEntrada . "',
hora_salida = '" . $HoraSalida . "'
WHERE id_reporte = '" . $idReporte . "' AND id_personal ='" . $idPersonal . "' AND dia = '" . $NomDia . "' ";
    if (mysqli_query($con, $sql2)) {
        echo 1;
    } else {
        echo 0;
    }

} else {

    $sql_insert = "INSERT INTO op_rh_personal_horario_programar_detalle  (
id_reporte,
id_estacion,
id_personal,
horario,
dia,
hora_entrada,
hora_salida
    )
    VALUES 
    (
    '" . $idReporte . "',
    '" . $_POST['idEstacion'] . "',
    '" . $idPersonal . "',
    '" . $horario . "',
    '" . $NomDia . "',
    '" . $HoraEntrada . "',
    '" . $HoraSalida . "'
    )";
    if (mysqli_query($con, $sql_insert)) {
        echo 1;
    } else {
        echo 0;
    }

}

//------------------
mysqli_close($con);
//------------------