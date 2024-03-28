  <?php
require('../../../app/help.php');

$aleatorio = uniqid();
$NoDoc  =   $_FILES['Archivo_file']['name'];
$UpDoc = "../../../archivos/incidencias/".$aleatorio."-".$NoDoc;
$NomDoc = $aleatorio."-".$NoDoc;


if(move_uploaded_file($_FILES['Archivo_file']['tmp_name'], $UpDoc)){

$sql_insert = "INSERT INTO op_incidencias_estaciones (
id_estacion,
fecha,
hora,
incidente,
responsable,
asunto,
comentarios,
archivo
    )
    VALUES 
    (
    '".$_POST['idEstacion']."',
    '".$_POST['FechaInc']."',
    '".$_POST['HoraInc']."',
    '".$_POST['IncidenciaInc']."',
    '".$_POST['ResponsableInc']."',
    '".$_POST['AsuntoInc']."',
    '".$_POST['ComentariosInc']."',
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