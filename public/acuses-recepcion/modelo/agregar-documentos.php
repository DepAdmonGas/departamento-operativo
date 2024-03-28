<?php
require('../../../app/help.php');

$sql = "INSERT INTO op_acuse_recepcion_documentos (
id_acuse,
documento,
paginas,
original,
copia
    )
    VALUES 
    (
    '".$_POST['idReporte']."',
    '".$_POST['NomDocumento']."',
    '".$_POST['NumPaginas']."',
    '".$_POST['ValOriginal']."',
    '".$_POST['ValCopia']."'
    )";

if(mysqli_query($con, $sql)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------