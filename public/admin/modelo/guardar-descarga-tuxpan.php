<?php
require('../../../app/help.php');

function CreateThumb($pImageOrigen, $pImageDestino, $pWidth, $pHeight, $pMaxWidth, $pMaxHeight, $pCalidad){
        // SI WIDTH ES MAS ALTO, LO CORTO POR WIDTH Y VICEVERSA
        if($pWidth > $pHeight){
            $_porcentaje = $pMaxHeight*100/$pHeight;
            $_height = $pMaxHeight;
            $_width = ceil($_porcentaje*$pWidth/100);
        }else{
            $_porcentaje = $pMaxWidth*100/$pWidth;
            $_width = $pMaxWidth;
            $_height = ceil($_porcentaje*$pHeight/100);
        }
        $_pic = @imagecreatefromjpeg($pImageOrigen);
        $_tmp = imagecreatetruecolor($pMaxWidth, $pMaxHeight);
        imagecopyresized($_tmp, $_pic, 0, 0, 0, 0, $_width, $_height, $pWidth, $pHeight);
        imagejpeg($_tmp, $pImageDestino, $pCalidad);
        imagedestroy($_pic);
        imagedestroy($_tmp);
    }

function Folio($Estacion,$con){
$sql = "SELECT folio FROM op_descarga_tuxpa WHERE id_estacion = '".$Estacion."' ORDER BY id desc LIMIT 1";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero == 0) {
$id = 1;
}else{
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$id = $row['folio'] + 1;
}
}
return $id;
}

function IdPrincipal($con){
$sql = "SELECT id FROM op_descarga_tuxpa ORDER BY id desc LIMIT 1";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero == 0) {
$id = 1;
}else{
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$id = $row['id'] + 1;
}
}
return $id;
}

$Estacion = $_POST['Estacion'];

$IdPrincipal = IdPrincipal($con);
$Folio = Folio($Estacion,$con);

$aleatorio = uniqid();

$FacturaRemision_file  =   $_FILES['FacturaRemision_file']['name'];
$upload_FacturaRemision = "../../../archivos/tuxpan/".$aleatorio."-".$FacturaRemision_file;
if($FacturaRemision_file != ""){
if(move_uploaded_file($_FILES['FacturaRemision_file']['tmp_name'], $upload_FacturaRemision)) {
$FacturaRemision = $aleatorio."-".$FacturaRemision_file;

}
}else{
$FacturaRemision = "";
}

$InventarioInicial_file  =   $_FILES['InventarioInicial_file']['name'];
$upload_InventarioInicial = "../../../archivos/tuxpan/".$aleatorio."-".$InventarioInicial_file;
if($InventarioInicial_file != ""){
if(move_uploaded_file($_FILES['InventarioInicial_file']['tmp_name'], $upload_InventarioInicial)) {
$InventarioInicial = $aleatorio."-".$InventarioInicial_file;

}
}else{
$InventarioInicial = "";
}

$Nice_file  =   $_FILES['Nice_file']['name'];
$upload_Nice = "../../../archivos/tuxpan/".$aleatorio."-".$Nice_file;
if($Nice_file != ""){
if(move_uploaded_file($_FILES['Nice_file']['tmp_name'], $upload_Nice)) {
$Nice = $aleatorio."-".$Nice_file;

}
}else{
$Nice = "";
}


$InventarioFinal_file  =   $_FILES['InventarioFinal_file']['name'];
$upload_InventarioFinal = "../../../archivos/tuxpan/".$aleatorio."-".$InventarioFinal_file;
if($InventarioFinal_file != ""){
if(move_uploaded_file($_FILES['InventarioFinal_file']['tmp_name'], $upload_InventarioFinal)) {
$InventarioFinal = $aleatorio."-".$InventarioFinal_file;


}
}else{
$InventarioFinal = "";
}



$MetroContador_file  =   $_FILES['MetroContador_file']['name'];
$upload_MetroContador = "../../../archivos/tuxpan/".$aleatorio."-".$MetroContador_file;
if($MetroContador_file != ""){
if(move_uploaded_file($_FILES['MetroContador_file']['tmp_name'], $upload_MetroContador)) {
$MetroContador = $aleatorio."-".$MetroContador_file;


}
}else{
$MetroContador = "";
}

$MC20Grados_file  =   $_FILES['MC20Grados_file']['name'];
$upload_MC20Grados = "../../../archivos/tuxpan/".$aleatorio."-".$MC20Grados_file;
if($MC20Grados_file != ""){
if(move_uploaded_file($_FILES['MC20Grados_file']['tmp_name'], $upload_MC20Grados)) {
$MC20Grados = $aleatorio."-".$MC20Grados_file;


}
}else{
$MC20Grados = "";
}

$img1 = $_POST['baseImage1'];
$img1 = str_replace('data:image/png;base64,', '', $img1);
$fileData1 = base64_decode($img1);
$fileName1 = uniqid().'.png';

$img2 = $_POST['baseImage2'];
$img2 = str_replace('data:image/png;base64,', '', $img2);
$fileData2 = base64_decode($img2);
$fileName2 = uniqid().'.png';


    $sql_insert = "INSERT INTO op_descarga_tuxpa (
    id,
	folio,
	id_estacion,
	id_usuario,
	fecha_llegada,
	hora_llegada,
	producto,
    no_factura,
	sellos,
	inventario_inicial,
	nice,
	detuvo_venta,
	inventario_final,
	metro_contador,
	metro_contador20,
	merma,
	operador,
	transportista,
    no_factura_remision,
    litros,
    precio_litro,
    unidad,
    cuenta_litros
    )
    VALUES 
    (       
    '".$IdPrincipal."',     
    '".$Folio."',
    '".$Estacion."',
    '".$_POST['Responsable']."',
    '".$_POST['Fechallegada']."',
    '".$_POST['Horallegada']."',
    '".$_POST['Productos']."',

    '".$FacturaRemision."',
    '".$_POST['Sellos']."',
    '".$InventarioInicial."',
    '".$Nice."',
    '".$_POST['Sdvdld']."',
    '".$InventarioFinal."',
    '".$MetroContador."',
    '".$MC20Grados."',

    '".$_POST['Merma']."',
    '".$_POST['Operador']."',
    '".$_POST['Transportista']."',

    '".$_POST['NoFactura']."',
    '".$_POST['Litros']."',
    '".$_POST['PrecioLitro']."',
    '".$_POST['Unidad']."',
    '".$_POST['CuentaLitros']."'
    )";

        
    if(mysqli_query($con, $sql_insert)){


if(file_put_contents('../../../imgs/firma-tuxpan/'.$fileName1, $fileData1)){
$sql_insert = "INSERT INTO op_descarga_tuxpa_firma (
    id_descarga,
    tipo_firma,
    imagen_firma
    )
    VALUES 
    (
    '".$IdPrincipal."',
    'Encargado de estación',
    '".$fileName1."'
    )";
    
    if(mysqli_query($con, $sql_insert)){}

}
if(file_put_contents('../../../imgs/firma-tuxpan/'.$fileName2, $fileData2)){
$sql_insert = "INSERT INTO op_descarga_tuxpa_firma (
    id_descarga,
    tipo_firma,
    imagen_firma
    )
    VALUES 
    (
    '".$IdPrincipal."',
    'Operador',
    '".$fileName2."'
    )";
    
    if(mysqli_query($con, $sql_insert)){}
}

	echo 1;
    }else{
    echo 0;
    }

//------------------
mysqli_close($con);
//------------------