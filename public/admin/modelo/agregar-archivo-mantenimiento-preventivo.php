 <?php
require('../../../app/help.php');

$aleatorio = uniqid();
$NoDoc1  =   $_FILES['Archivo_file']['name'];
$UpDoc1 = "../../../archivos/prueba-eficiencia/".$aleatorio."-".$NoDoc1;
$NomDoc1 = $aleatorio."-".$NoDoc1;

if(move_uploaded_file($_FILES['Archivo_file']['tmp_name'], $UpDoc1)){
$sql_insert3 = "INSERT INTO op_mantenimiento_preventivo_documentos (
id_estacion,
fecha,
descripcion,
archivo
    )
    VALUES 
    (
    '".$_POST['idEstacion']."',
    '".$_POST['Fecha']."',
    'Prueba de eficiencia',
    '".$NomDoc1."'
    )";

if(mysqli_query($con, $sql_insert3)){

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