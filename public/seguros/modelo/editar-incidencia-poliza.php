
<?php
require('../../../app/help.php');

$aleatorio = uniqid();

if (isset($_FILES['Evidencia_file'])) {
$NoDoc  =   $_FILES['Evidencia_file']['name'];
$UpDoc = "../../../archivos/incidencias-poliza-es/".$aleatorio."-".$NoDoc;
$NomDoc = $aleatorio."-".$NoDoc;
}

if (isset($_FILES['Evidencia_file'])) {
if(move_uploaded_file($_FILES['Evidencia_file']['tmp_name'], $UpDoc)){

$sql_edit1 = "UPDATE op_poliza_incidencia SET 
fecha = '".$_POST['FechaP']."',
hora = '".$_POST['HoraP']."',
asunto = '".$_POST['AsuntoP']."',
observaciones = '".$_POST['ObservacionesP']."',
solucion = '".$_POST['SolucionP']."',
archivo = '".$NomDoc."'
WHERE id_poliza_incidencia ='".$_POST['idPolizaInc']."' ";

if(mysqli_query($con, $sql_edit1)){
echo 1;
}else{
echo 0;
}

}else{
echo 0;
}


}else{

$sql_edit2 = "UPDATE op_poliza_incidencia SET 
fecha = '".$_POST['FechaP']."',
hora = '".$_POST['HoraP']."',
asunto = '".$_POST['AsuntoP']."',
observaciones = '".$_POST['ObservacionesP']."',
solucion = '".$_POST['SolucionP']."'
WHERE id_poliza_incidencia ='".$_POST['idPolizaInc']."' ";

if(mysqli_query($con, $sql_edit2)){
echo 1;
}else{
echo 0;
}

}


//------------------
mysqli_close($con);
//------------------   
