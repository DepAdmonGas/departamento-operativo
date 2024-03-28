 <?php
require('../../../app/help.php');

$aleatorio = uniqid();
$NoDoc  =   $_FILES['Archivo_file']['name'];
$UpDoc = "../../../archivos/incidencias/".$aleatorio."-".$NoDoc;
$NomDoc = $aleatorio."-".$NoDoc;

if($NoDoc != ""){

if(move_uploaded_file($_FILES['Archivo_file']['tmp_name'], $UpDoc)){

$sql_edit1 = "UPDATE op_incidencias_estaciones SET 
fecha = '".$_POST['FechaInc']."',
hora = '".$_POST['HoraInc']."',
incidente = '".$_POST['IncidenciaInc']."',
responsable = '".$_POST['ResponsableInc']."',
asunto = '".$_POST['AsuntoInc']."',
comentarios = '".$_POST['ComentariosInc']."',
archivo = '".$NomDoc."'

WHERE id_incidencias_estaciones ='".$_POST['idIncidencia']."' ";


if(mysqli_query($con, $sql_edit1)){
echo 1;
}else{
echo 0;
}

}else{
echo 0;
}


}else{

$sql_edit2 = "UPDATE op_incidencias_estaciones SET 
fecha = '".$_POST['FechaInc']."',
hora = '".$_POST['HoraInc']."',
incidente = '".$_POST['IncidenciaInc']."',
responsable = '".$_POST['ResponsableInc']."',
asunto = '".$_POST['AsuntoInc']."',
comentarios = '".$_POST['ComentariosInc']."'

WHERE id_incidencias_estaciones ='".$_POST['idIncidencia']."' ";

if(mysqli_query($con, $sql_edit2)){
echo 1;
}else{
echo 0;
}

}


//------------------
mysqli_close($con);
//------------------   