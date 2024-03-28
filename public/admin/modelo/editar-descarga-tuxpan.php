 <?php
require('../../../app/help.php');

$aleatorio = uniqid();

//---------- Factura de remision ----------
$FacturaRemision_file  =   $_FILES['FacturaRemision_file']['name'];
$upload_FacturaRemision = "../../../archivos/tuxpan/".$aleatorio."-".$FacturaRemision_file;
if($FacturaRemision_file != ""){
if(move_uploaded_file($_FILES['FacturaRemision_file']['tmp_name'], $upload_FacturaRemision)) {
$FacturaRemision = $aleatorio."-".$FacturaRemision_file;
$Facturaconsulta = "no_factura = '".$FacturaRemision."',";
}
}else{
$FacturaRemision = "";
$Facturaconsulta = "";
}


//---------- Inventario inicial ----------
$InventarioInicial_file  =   $_FILES['InventarioInicial_file']['name'];
$upload_InventarioInicial = "../../../archivos/tuxpan/".$aleatorio."-".$InventarioInicial_file;
if($InventarioInicial_file != ""){
if(move_uploaded_file($_FILES['InventarioInicial_file']['tmp_name'], $upload_InventarioInicial)) {
$InventarioInicial = $aleatorio."-".$InventarioInicial_file;
$InInicialconsulta = "inventario_inicial = '".$InventarioInicial."',";

}
}else{
$InventarioInicial = "";
$InInicialconsulta = "";
}


//---------- Medida Nice ----------
$Nice_file  =   $_FILES['Nice_file']['name'];
$upload_Nice = "../../../archivos/tuxpan/".$aleatorio."-".$Nice_file;
if($Nice_file != ""){
if(move_uploaded_file($_FILES['Nice_file']['tmp_name'], $upload_Nice)) {
$Nice = $aleatorio."-".$Nice_file;
$Niceconsulta = "nice = '".$Nice."',";

}
}else{
$Nice = "";
$Niceconsulta = "";

}



//---------- Inventario final ----------
$InventarioFinal_file  =   $_FILES['InventarioFinal_file']['name'];
$upload_InventarioFinal = "../../../archivos/tuxpan/".$aleatorio."-".$InventarioFinal_file;
if($InventarioFinal_file != ""){
if(move_uploaded_file($_FILES['InventarioFinal_file']['tmp_name'], $upload_InventarioFinal)) {
$InventarioFinal = $aleatorio."-".$InventarioFinal_file;
$InFinalconsulta = "inventario_final = '".$InventarioFinal."',";

}
}else{
$InventarioFinal = "";
$InFinalconsulta = "";
}


//---------- Metro contador ----------
$MetroContador_file  =   $_FILES['MetroContador_file']['name'];
$upload_MetroContador = "../../../archivos/tuxpan/".$aleatorio."-".$MetroContador_file;
if($MetroContador_file != ""){
if(move_uploaded_file($_FILES['MetroContador_file']['tmp_name'], $upload_MetroContador)) {
$MetroContador = $aleatorio."-".$MetroContador_file;
$MCconsulta = "metro_contador = '".$MetroContador."',";


}
}else{
$MetroContador = "";
$MCconsulta = "";

}


//---------- Metro contador °C ----------
$MC20Grados_file  =   $_FILES['MC20Grados_file']['name'];
$upload_MC20Grados = "../../../archivos/tuxpan/".$aleatorio."-".$MC20Grados_file;

if($MC20Grados_file != ""){
if(move_uploaded_file($_FILES['MC20Grados_file']['tmp_name'], $upload_MC20Grados)) {
$MC20Grados = $aleatorio."-".$MC20Grados_file;
$MC20gradosconsulta = "metro_contador20 = '".$MC20Grados."',";
}
}else{
$MC20Grados = "";
$MC20gradosconsulta = "";
}


//---------- UPADTE FORMATO ----------

$sql_update = "UPDATE op_descarga_tuxpa 
SET fecha_llegada = '".$_POST['Fechallegada']."', 
	hora_llegada = '".$_POST['Horallegada']."', 
	producto = '".$_POST['Productos']."',
	$Facturaconsulta 
	sellos = '".$_POST['Sellos']."', 
	$InInicialconsulta 
	$Niceconsulta
	detuvo_venta = '".$_POST['Sdvdld']."',
	$InFinalconsulta
	$MCconsulta
	$MC20gradosconsulta
	merma = '".$_POST['Merma']."',
	operador = '".$_POST['Operador']."',
	transportista = '".$_POST['Transportista']."',
	no_factura_remision = '".$_POST['NoFactura']."',
	litros = '".$_POST['Litros']."', 
	precio_litro = '".$_POST['PrecioLitro']."',
	unidad = '".$_POST['Unidad']."',
	cuenta_litros = '".$_POST['CuentaLitros']."'

	WHERE id = '".$_POST['idFormato']."' " ;


	if(mysqli_query($con, $sql_update)){
		echo 1;

	}else{
		echo 0;
	}


//------------------
mysqli_close($con);
//------------------