<?php
require('../../../app/help.php');

$aleatorio = uniqid();
$Ficha  =   $_FILES['Ficha_file']['name'];
$Imagen  =   $_FILES['Imagen_file']['name'];
$Factura  =   $_FILES['Factura_file']['name'];

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



//---------- FICHA DE DEPOSITO FALTANTE ----------
if ($Ficha != "") {
$upload_Ficha = "../../../archivos/".$aleatorio."-".$Ficha;
$DocumentoFicha = $aleatorio."-".$Ficha;
move_uploaded_file($_FILES['Ficha_file']['tmp_name'], $upload_Ficha);
$fecha_ficha = $fecha_actual;
$puntaje_ficha = $puntaje_fichas;

}else{
$upload_Ficha = "";
$DocumentoFicha = "";
$fecha_ficha = "";
$puntaje_ficha = "";

}    

//---------- IMAGEN DE BODEGA ----------
if ($Imagen != "") {
$upload_Imagen = "../../../archivos/".$aleatorio."-".$Imagen;
$DocumentoImagen = $aleatorio."-".$Imagen;
move_uploaded_file($_FILES['Imagen_file']['tmp_name'], $upload_Imagen);

}else{
$upload_Imagen = "";
$DocumentoImagen = "";

}

//---------- FACTURA ----------

if ($Factura != "") {
$upload_Factura = "../../../archivos/".$aleatorio."-".$Factura;
$DocumentoFactura = $aleatorio."-".$Factura;
move_uploaded_file($_FILES['Factura_file']['tmp_name'], $upload_Factura);
$fecha_factura = $fecha_actual;
$puntaje_factura = $puntaje_facturas;

}else{
$upload_Factura = "";
$DocumentoFactura = "";
$fecha_factura = "";
$puntaje_factura = "";

}

$sql_insert = "INSERT INTO op_aceites_documento (
    id_mes,
    fecha,
    ficha_deposito,
    fecha_evaluacion_ficha,
    puntaje_ficha,
    imagen_bodega,
    factura_venta,
    fecha_evaluacion_factura,
    puntaje_factura
    )
    VALUES 
    (
    '".$_POST['IdReporte']."',
    '".$fecha_del_dia."',
    '".$DocumentoFicha."',
    '".$fecha_ficha."',
    '".$puntaje_ficha."',
    '".$DocumentoImagen."',
    '".$DocumentoFactura."',
    '".$fecha_factura."',
    '".$puntaje_factura."'
    )";

if(mysqli_query($con, $sql_insert)){
echo 1;    
}else{
echo 0;
}






//------------------
mysqli_close($con);
//------------------
?>