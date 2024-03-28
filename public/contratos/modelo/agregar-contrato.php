   <?php
require('../../../app/help.php');

$aleatorio = uniqid();
$NoDoc  =   $_FILES['Contrato_file']['name'];
$UpDoc = "../../../archivos/contratos-es/".$aleatorio."-".$NoDoc;
$NomDoc = $aleatorio."-".$NoDoc;


if(move_uploaded_file($_FILES['Contrato_file']['tmp_name'], $UpDoc)){

$sql_insert = "INSERT INTO op_contratos (
id_estacion,
fecha,
descripcion,
archivo,

objeto,
proveedor,
vencimiento,
firmas,
comentario,
categoria
    )
    VALUES 
    (
    '".$_POST['idEstacion']."',
    '".$_POST['FechaC']."',
    '".$_POST['DescripcionC']."',
    '".$NomDoc."',

    '".$_POST['Objeto']."',
    '".$_POST['Proveedor']."',
    '".$_POST['Vencimiento']."',
    '".$_POST['Firman']."',
    '".$_POST['Comentario']."',
    '".$_POST['Cate']."'
    )";

if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
}

}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------  