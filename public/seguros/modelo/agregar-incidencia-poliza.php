  <?php
require('../../../app/help.php');

$aleatorio = uniqid();
$NoDoc  =   $_FILES['Evidencia_file']['name'];
$UpDoc = "../../../archivos/incidencias-poliza-es/".$aleatorio."-".$NoDoc;
$NomDoc = $aleatorio."-".$NoDoc;


if(move_uploaded_file($_FILES['Evidencia_file']['tmp_name'], $UpDoc)){

$sql_insert = "INSERT INTO op_poliza_incidencia (
id_estacion,
fecha,
hora,
asunto,
observaciones,
solucion,
archivo
    )
    VALUES 
    (
    '".$_POST['idEstacion']."',
    '".$_POST['FechaP']."',
    '".$_POST['HoraP']."',
    '".$_POST['AsuntoP']."',
    '".$_POST['ObservacionesP']."',
    '".$_POST['SolucionP']."',
    '".$NomDoc."'
    )";

if(mysqli_query($con, $sql_insert)){
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