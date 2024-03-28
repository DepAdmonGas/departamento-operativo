  <?php
require('../../../app/help.php');

$aleatorio = uniqid();

$NoDoc1  =   $_FILES['Archivo_file']['name'];
$UpDoc1 = "../../../archivos/cuenta-litros/".$aleatorio."-".$NoDoc1;
$NomDoc1 = $aleatorio."-".$NoDoc1;

if($_POST['embarqueCL'] == "Pemex"){
$transporteEM = "";
}else{
$transporteEM = $_POST['transporteCL']; 
}

if($_POST['comentariosCL'] == ""){
$comnentarioVal = "Sin comentarios.";
}else{
$comnentarioVal = $_POST['comentariosCL'];
}

 
if($NoDoc1 != ""){

if(move_uploaded_file($_FILES['Archivo_file']['tmp_name'], $UpDoc1)){

$sql_edit1 = "UPDATE op_cuenta_litros_detalle SET 
hora = '".$_POST['horaCL']."',
embarque = '".$_POST['embarqueCL']."',
transporte = '".$transporteEM."',
tanque = '".$_POST['tanqueCL']."',
producto = '".$_POST['productoCL']."',
litros = '".$_POST['facturaCL']."',
descarga_neto = '".$_POST['descargaNetoCL']."',
descarga_bruto = '".$_POST['descargaBrutoCL']."',
litros_c = '".$_POST['descargaGradosCL']."',
tad = '".$_POST['tadCL']."',
unidad = '".$_POST['unidadCL']."',
venta_momento = '".$_POST['ventaCL']."',
folio_merma = '".$_POST['mermaCL']."',
comentario = '".$comnentarioVal."',
archivo = '".$NomDoc1."'

WHERE id_detalle ='".$_POST['idDetalle']."' ";

if(mysqli_query($con, $sql_edit1)){
echo 1;
}else{
echo 0;
}

}else{
echo 0;
}


}else{

$sql_edit2 = "UPDATE op_cuenta_litros_detalle SET 
hora = '".$_POST['horaCL']."',
embarque = '".$_POST['embarqueCL']."',
transporte = '".$transporteEM."',
tanque = '".$_POST['tanqueCL']."',
producto = '".$_POST['productoCL']."',
litros = '".$_POST['facturaCL']."',
descarga_neto = '".$_POST['descargaNetoCL']."',
descarga_bruto = '".$_POST['descargaBrutoCL']."',
litros_c = '".$_POST['descargaGradosCL']."',
tad = '".$_POST['tadCL']."',
unidad = '".$_POST['unidadCL']."',
venta_momento = '".$_POST['ventaCL']."',
folio_merma = '".$_POST['mermaCL']."',
comentario = '".$comnentarioVal."'

WHERE id_detalle ='".$_POST['idDetalle']."' ";

if(mysqli_query($con, $sql_edit2)){
echo 1;
}else{
echo 0;
}

}



//------------------
mysqli_close($con);
//------------------ 