 <?php
require('../../../app/help.php');

$aleatorio = uniqid();
$NoDoc  =   $_FILES['Poliza_file']['name'];
$UpDoc = "../../../archivos/poliza-estacion/".$aleatorio."-".$NoDoc;
$NomDoc = $aleatorio."-".$NoDoc;

if(move_uploaded_file($_FILES['Poliza_file']['tmp_name'], $UpDoc)){

$sql_insert = "INSERT INTO op_poliza_es (
id_estacion,
emision,
vencimiento,
archivo
    )
    VALUES 
    (
    '".$_POST['idEstacion']."',
    '".$_POST['EmisionP']."',
    '".$_POST['VencimientoP']."',
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