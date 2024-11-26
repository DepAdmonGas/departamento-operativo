 <?php
require('../../../app/help.php');

// Valida si ya esta en la bd el registro , en caso que no este, lo agrega
$unidad = validaDato($_POST['unidadCL'],2,$con);
$transporte = validaDato($_POST['transporteCL'],3,$con);

if($unidad == 0){
    agregaDato($_POST['unidadCL'],2,$con);
}
if($transporte == 0){
    agregaDato($_POST['transporteCL'],3,$con);
}
function validaDato($dato,$opcion,$con){
    $id = 0;
    $columna = "nombre_chofer";
    $tabla = "tb_pivoteo_chofer";
    if($opcion == 2){
        $columna = "no_unidad";
        $tabla = "tb_unidades_transporte";
    }else if($opcion == 3){
        $columna = "nombre_transporte";
        $tabla = "tb_lista_transportes";
    }
    $sql = "SELECT $columna FROM $tabla WHERE $columna = '$dato' ORDER BY id DESC LIMIT 1";
    $result = $con->query($sql);
    if ($result->num_rows > 0) {
      $id = 1;
    }
    return $id;
}
function agregaDato($dato,$opcion,$con){
    $columna = "nombre_chofer";
    $tabla = "tb_pivoteo_chofer";
    if($opcion == 2){
        $columna = "no_unidad";
        $tabla = "tb_unidades_transporte";
    }else if($opcion == 3){
        $columna = "nombre_transporte";
        $tabla = "tb_lista_transportes";
    }
    $sql = "INSERT INTO $tabla ($columna,estado) 
            VALUES ('$dato',0)";
    $con->query($sql);
}



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