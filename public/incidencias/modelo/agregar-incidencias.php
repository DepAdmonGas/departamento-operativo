 <?php
require('../../../app/help.php');

$aleatorio = uniqid();

$NoDoc1  =   $_FILES['PDF_file']['name'];
$UpDoc1 = "../../../archivos/incidencias/".$aleatorio."-".$NoDoc1;

if(move_uploaded_file($_FILES['PDF_file']['tmp_name'], $UpDoc1)){
$NomDoc1 = $aleatorio."-".$NoDoc1;
}else{
$NomDoc1 = "";
}

if($_POST['id'] == 0){

$sql_insert2 = "INSERT INTO op_incidencias 
(id_estacion,
 id_categoria,
 year,
 mes,
 fecha,
 asunto,
 responsable,
 tiempo_actividad,
 archivo)

VALUES 
('".$_POST['idEstacion']."',
 '".$_POST['idCategoria']."',
 '".$_POST['year']."',
 '".$_POST['mes']."',
 '".$_POST['Fecha']."',
 '".$_POST['Asunto']."',
 '".$_POST['Responsable']."',
 '".$_POST['TiempoAct']."',
 '".$NomDoc1."')";

mysqli_query($con, $sql_insert2);
echo 1;

}else{


if($NoDoc1 != ""){

$sql_edit1 = "UPDATE op_incidencias SET 
    fecha = '".$_POST['Fecha']."',
    asunto = '".$_POST['Asunto']."',
    responsable = '".$_POST['Responsable']."',
    tiempo_actividad = '".$_POST['TiempoAct']."',    
    archivo = '".$NomDoc1."'
    WHERE id = '".$_POST['id']."' ";

mysqli_query($con, $sql_edit1);
echo 1;

}else{

    $sql_edit2 = "UPDATE op_incidencias SET 
    fecha = '".$_POST['Fecha']."',
    asunto = '".$_POST['Asunto']."',
    responsable = '".$_POST['Responsable']."',
    tiempo_actividad = '".$_POST['TiempoAct']."'
    WHERE id = '".$_POST['id']."' ";

mysqli_query($con, $sql_edit2);
echo 1;

}





}



//------------------
mysqli_close($con);
//------------------