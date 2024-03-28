 <?php
require('../../../app/help.php');

$aleatorio = uniqid();

$NoDoc1  =   $_FILES['Archivo_file']['name'];
$UpDoc1 = "../../../archivos/cuenta-litros/".$aleatorio."-".$NoDoc1;

if(move_uploaded_file($_FILES['Archivo_file']['tmp_name'], $UpDoc1)){
$NomDoc1 = $aleatorio."-".$NoDoc1;
}else{
$NomDoc1 = "";
}

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
 

$sql_insert = "INSERT INTO op_cuenta_litros_detalle (
    id_cuenta_litros,
    hora,
    embarque,
    transporte,
    producto,
    tanque,
    litros,
    descarga_neto,
    descarga_bruto,
    litros_c,
    tad,
    unidad,
    venta_momento,
    folio_merma,
    comentario,
    archivo

    )
    VALUES 
    (
    '".$_POST['idCuentaLitros']."',
    '".$_POST['horaCL']."',
    '".$_POST['embarqueCL']."',
    '".$transporteEM."',
    '".$_POST['productoCL']."',
    '".$_POST['tanqueCL']."',
    '".$_POST['facturaCL']."',
    '".$_POST['descargaNetoCL']."',
    '".$_POST['descargaBrutoCL']."',
    '".$_POST['descargaGradosCL']."',
    '".$_POST['tadCL']."',
    '".$_POST['unidadCL']."',
    '".$_POST['ventaCL']."',
    '".$_POST['mermaCL']."',
    '".$comnentarioVal."',
    '".$NomDoc1."'
    )";


mysqli_query($con, $sql_insert);
echo 1;

//------------------
mysqli_close($con);
//------------------ 