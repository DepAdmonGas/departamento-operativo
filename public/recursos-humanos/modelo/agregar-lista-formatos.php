<?php
require('../../../app/help.php');

//$aleatorio = uniqid();
$numeroAleatorio = rand(1, 1000000);
  
//$aleatorio = uniqid();
$numeroAleatorio2 = rand(1000, 9999);

$idDocumento = $_POST['idDocumento'];
$Formato = $_POST['Formato'];
$Clave = $_POST['Clave'];

$File  =   $_FILES['seleccionArchivos_file']['name'];
$extension1 = pathinfo($File, PATHINFO_EXTENSION);
$upload_folder = "../../../archivos/lista-formatos/".$numeroAleatorio."-Formato ".$Clave."-".$numeroAleatorio2 . "." . $extension1;
$Imagen = $numeroAleatorio."-Formato-".$Clave."-".$numeroAleatorio2 . "." . $extension1;


if(move_uploaded_file($_FILES['seleccionArchivos_file']['tmp_name'], $upload_folder)) {

    $sql_insert = "INSERT INTO op_lista_formatos (
    formato, nombre, archivo, status
        )
        VALUES 
        (
        '".$Clave."',
        '".$Formato."',
        '".$Imagen."',
        '0'
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
