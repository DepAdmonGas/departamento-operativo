<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$idReporte = $_POST['idReporte'];

$img1 = $_POST['baseImage1'];
$img1 = str_replace('data:image/png;base64,', '', $img1);
$fileData1 = base64_decode($img1);
$fileName1 = uniqid().'.png';

$img2 = $_POST['baseImage2'];
$img2 = str_replace('data:image/png;base64,', '', $img2);
$fileData2 = base64_decode($img2);
$fileName2 = uniqid().'.png';

$sql_edit1 = "UPDATE op_nivel_explosividad SET 
    fecha = '".$_POST['Fecha']."',
    estado = 1
    WHERE id = '".$idReporte."' ";

	if(mysqli_query($con, $sql_edit1)){

    $sql_insert1 = "INSERT INTO op_nivel_explosividad_detalle (
    id_reporte,
    elemento1,
    elemento2,
    elemento3,
    elemento4,
    elemento5,	
    elemento6,	
    elemento7,	
    elemento8,	
    elemento9,	
    elemento10,	
    elemento11,	
    elemento12,	
    elemento13,	
    elemento14,	
    elemento15,	
    elemento16,	
    elemento17,	
    elemento18,	
    observaciones
    )
    VALUES 
    (       
    '".$idReporte."',    
    '".$_POST['Elemento1']."',
    '".$_POST['Elemento2']."',
    '".$_POST['Elemento3']."',
    '".$_POST['Elemento4']."',
    '".$_POST['Elemento5']."',	
    '".$_POST['Elemento6']."',	
    '".$_POST['Elemento7']."',	
    '".$_POST['Elemento8']."',	
    '".$_POST['Elemento9']."',	
    '".$_POST['Elemento10']."',	
    '".$_POST['Elemento11']."',	
    '".$_POST['Elemento12']."',	
    '".$_POST['Elemento13']."',	
    '".$_POST['Elemento14']."',	
    '".$_POST['Elemento15']."',	
    '".$_POST['Elemento16']."',	
    '".$_POST['Elemento17']."',	
    '".$_POST['Elemento18']."',	
    '".$_POST['Observaciones']."'
    )";
    
    if(mysqli_query($con, $sql_insert1)){

if(file_put_contents('../../../imgs/firma/'.$fileName1, $fileData1)){
$sql_insert2 = "INSERT INTO op_nivel_explosividad_firma (
    id_reporte,
    id_usuario,
    tipo_firma,
    imagen_firma
    )
    VALUES 
    (
    '".$idReporte."', 
    '".$Session_IDUsuarioBD."', 
    'FIRMA DE QUIEN TOMA MEDICIÓN',
    '".$fileName1."'
    )";
    
    if(mysqli_query($con, $sql_insert2)){}

}
if(file_put_contents('../../../imgs/firma/'.$fileName2, $fileData2)){
$sql_insert3 = "INSERT INTO op_nivel_explosividad_firma (
    id_reporte,
    id_usuario,
    tipo_firma,
    imagen_firma
    )
    VALUES 
    (
    '".$idReporte."',  
    '".$_POST['Encargado']."',	
    'FIRMA POR LA ESTACIÓN',
    '".$fileName2."'
    )";
    
    if(mysqli_query($con, $sql_insert3)){}
}

	echo 1;
    }

	}else{
	echo 0;
	}

//------------------
mysqli_close($con);
//------------------