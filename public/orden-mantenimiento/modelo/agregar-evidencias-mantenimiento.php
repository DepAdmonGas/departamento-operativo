<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];
$Detalle = $_POST['Detalle'];
$FileEvidencia = $_FILES['FileEvidencia']['name'];

$extension = pathinfo($FileEvidencia, PATHINFO_EXTENSION);
$ruta_file = "../../../archivos/"."MANTENIMIENTO-".$idReporte."-".strtotime($hoy).".".$extension;

$ruta_protocolo = "MANTENIMIENTO-".$idReporte."-".strtotime($hoy).".".$extension;

$allowTypes = array('jpg','png','jpeg','gif'); 

if(in_array($extension, $allowTypes)){
            // Image temp source 
            $imageTemp = $_FILES["FileEvidencia"]["tmp_name"]; 
             
            // Comprimos el fichero
            $compressedImage = compressImage($imageTemp, $ruta_file, 50); 
             
            if($compressedImage){ 
                
				$sql_insert1 = "INSERT INTO op_orden_mantenimiento_entregables (
				id_mantenimiento,
				detalle,
				archivo
				)
				VALUES
				(
				'".$idReporte."',
				'".$Detalle."',
				'".$ruta_protocolo."'
				)";
				mysqli_query($con, $sql_insert1);

            }else{ 
                
            } 
        }else{ 
             
        } 

function compressImage($source, $destination, $quality) { 
    // Obtenemos la información de la imagen
    $imgInfo = getimagesize($source); 
    $mime = $imgInfo['mime']; 
     
    // Creamos una imagen
    switch($mime){ 
        case 'image/jpeg': 
            $image = imagecreatefromjpeg($source); 
            break; 
        case 'image/png': 
            $image = imagecreatefrompng($source); 
            break; 
        case 'image/gif': 
            $image = imagecreatefromgif($source); 
            break; 
        default: 
            $image = imagecreatefromjpeg($source); 
    } 

    //$rotate = imagerotate($image, 270, 0);
    $rotate = $image;
     
    // Guardamos la imagen
    imagejpeg($rotate, $destination, $quality); 
     
    // Devolvemos la imagen comprimida
    return $destination; 
}

//------------------
mysqli_close($con);
//------------------