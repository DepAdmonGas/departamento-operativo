<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$Ficha  =   $_FILES['Ficha_file']['name'];
$Imagen  =   $_FILES['Imagen_file']['name'];
$Factura  =   $_FILES['Factura_file']['name'];

$upload_Ficha = "../../../archivos/".$aleatorio."-".$Ficha;
$upload_Imagen = "../../../archivos/".$aleatorio."-".$Imagen;
$upload_Factura = "../../../archivos/".$aleatorio."-".$Factura;
 
$DocumentoFicha = $aleatorio."-".$Ficha;
$DocumentoImagen = $aleatorio."-".$Imagen;
$DocumentoFactura = $aleatorio."-".$Factura;

$year = $_POST['year'];
$mes = $_POST['mes'];
$mes_formateado = sprintf("%02d", $mes);
$fecha_actual = date("Y-m-d"); 

//---------- FECHAS FACTURA----------
$fecha_02 = date("$year-$mes_formateado-02");
$fecha_03 = date("$year-$mes_formateado-03");
$fecha_04 = date("$year-$mes_formateado-04");

if($fecha_actual <= $fecha_02){
$puntaje_facturas = 3;

}else if($fecha_actual > $fecha_02 && $fecha_actual <= $fecha_03){
$puntaje_facturas = 2;

}else if($fecha_actual > $fecha_03 && $fecha_actual <= $fecha_04){
$puntaje_facturas = 1;  

}else{
$puntaje_facturas = 0;   

}


//---------- FECHAS FICHA----------
$fecha_10 = date("$year-$mes_formateado-10");
$fecha_20 = date("$year-$mes_formateado-20");

if($fecha_actual <= $fecha_02){
$puntaje_fichas = 3;
    
}else if($fecha_actual > $fecha_02 && $fecha_actual <= $fecha_10){
$puntaje_fichas = 2;
    
}else if($fecha_actual > $fecha_10 && $fecha_actual <= $fecha_20){
$puntaje_fichas = 1;  
    
}else{
$puntaje_fichas = 0;   
    
}


if($Ficha != ""){
if(move_uploaded_file($_FILES['Ficha_file']['tmp_name'], $upload_Ficha)) {

$sql_edit1 = "UPDATE op_aceites_documento SET 
    ficha_deposito = '".$DocumentoFicha."',
    fecha_evaluacion_ficha = '".$fecha_actual."',
    puntaje_ficha = '".$puntaje_fichas."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit1);

}
}

if($Imagen != ""){
if(move_uploaded_file($_FILES['Imagen_file']['tmp_name'], $upload_Imagen)) {

$sql_edit1 = "UPDATE op_aceites_documento SET 
    imagen_bodega = '".$DocumentoImagen."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit1);
 
}
}

if($Factura != ""){
if(move_uploaded_file($_FILES['Factura_file']['tmp_name'], $upload_Factura)) {

$sql_edit1 = "UPDATE op_aceites_documento SET 
    factura_venta = '".$DocumentoFactura."',
    fecha_evaluacion_factura = '".$fecha_actual."',
    puntaje_factura = '".$puntaje_facturas."'
    WHERE id='".$_POST['id']."' ";
mysqli_query($con, $sql_edit1);
 
}
}

echo 1;

//------------------
mysqli_close($con);
//------------------
?>