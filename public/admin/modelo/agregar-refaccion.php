<?php
require('../../../app/help.php');

function idRefaccion($con){
$sql_usuario = "SELECT id FROM op_refacciones ORDER BY id desc LIMIT 1";
$result_usuario = mysqli_query($con, $sql_usuario);
$numero_usuario = mysqli_num_rows($result_usuario);
if ($numero_usuario == 0) {
$numid = 1;
}else{
while($row_usuario = mysqli_fetch_array($result_usuario, MYSQLI_ASSOC)){
$numid = $row_usuario['id'] + 1;
}
}
return $numid;
}
  
$aleatorio = uniqid();
$File  =   $_FILES['seleccionArchivos_file']['name'];
$upload_folder = "../../../archivos/".$aleatorio."-".$File;

$idRefaccion = idRefaccion($con);

if(move_uploaded_file($_FILES['seleccionArchivos_file']['tmp_name'], $upload_folder)) {
$Imagen = $aleatorio."-".$File;
}else{
$Imagen = "";
} 

$sql_insert = "INSERT INTO op_refacciones (
id,
id_estacion,
descripcion_f,
nombre,
imagen,
unidad,
estado_r,
costo,
modelo,
marca,
proveedor,
contacto,
area,
archivo,
status
    )
    VALUES 
    (
    '".$idRefaccion."',
    '".$_POST['idEstacion']."',
    '".$_POST['DescripcionRefaccion']."',

    '".$_POST['NombreRefaccion']."',
    '".$Imagen."',
    '".$_POST['Unidad']."',
    '".$_POST['EstadoR']."',
    '".$_POST['Costo']."',
    '".$_POST['Modelo']."',
    '".$_POST['Marca']."',
    '".$_POST['Proveedor']."',
    '".$_POST['Contacto']."',
    '".$_POST['Area']."',
    '',
    1
    )";

    
if(mysqli_query($con, $sql_insert)){

    if($_POST['Unidad'] != "" AND $_POST['Unidad'] > 0 ){

      $sql_insert2 = "INSERT INTO op_refacciones_unidades (
        id_refaccion,
        unidad
    )
    VALUES 
    (
    '".$idRefaccion."',
    '".$_POST['Unidad']."'
    )"; 

    if(mysqli_query($con, $sql_insert2)){
    echo 1;
    }else{
    echo 0;    
    }

    }else{
    echo 1;    
    }


}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------