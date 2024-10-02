 <?php
require('../../../app/help.php');

$aleatorio = uniqid();

if (isset($_FILES['Poliza_file'])) {
$NoDoc  =   $_FILES['Poliza_file']['name'];
$UpDoc = "../../../archivos/poliza-estacion/".$aleatorio."-".$NoDoc;
$NomDoc = $aleatorio."-".$NoDoc;
}

if (isset($_FILES['Poliza_file'])) {
if(move_uploaded_file($_FILES['Poliza_file']['tmp_name'], $UpDoc)){

$sql_edit1 = "UPDATE op_poliza_es SET 
emision = '".$_POST['EmisionP']."',
vencimiento = '".$_POST['VencimientoP']."',
archivo = '".$NomDoc."'
WHERE id_poliza ='".$_POST['idPoliza']."' ";

if(mysqli_query($con, $sql_edit1)){
echo 1;
}else{
echo 0;
}

}else{
echo 0;
}


}else{
 
$sql_edit2 = "UPDATE op_poliza_es SET 
emision = '".$_POST['EmisionP']."',
vencimiento = '".$_POST['VencimientoP']."'
WHERE id_poliza ='".$_POST['idPoliza']."' ";

if(mysqli_query($con, $sql_edit2)){
echo 1;
}else{
echo 0;
}

}


//------------------
mysqli_close($con);
//------------------   