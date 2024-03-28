  <?php
require('../../../app/help.php');

$aleatorio = uniqid();

$NoDoc1  =   $_FILES['Documento_file']['name'];
$UpDoc1 = "../../../archivos/licitacion-municipal/".$aleatorio."-".$NoDoc1;

if(move_uploaded_file($_FILES['Documento_file']['tmp_name'], $UpDoc1)){
$NomDoc1 = $aleatorio."-".$NoDoc1;
}else{
$NomDoc1 = "";
}


if($NoDoc1 != ""){

$sql_edit1 = "UPDATE op_licitacion_municipal SET 
    fecha = '".$_POST['Fecha']."',
    nombre_formato = '".$_POST['Formato']."', 
    archivo = '".$NomDoc1."'
    WHERE id = '".$_POST['idLicitacion']."' ";

mysqli_query($con, $sql_edit1);
echo 1;

}else{

    $sql_edit2 = "UPDATE op_licitacion_municipal SET 
    fecha = '".$_POST['Fecha']."',
    nombre_formato = '".$_POST['Formato']."'
    WHERE id = '".$_POST['idLicitacion']."' ";

mysqli_query($con, $sql_edit2);
echo 1;

}


//------------------
mysqli_close($con);
//------------------