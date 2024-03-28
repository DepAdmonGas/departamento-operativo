 <?php
require('../../../app/help.php');

if($_POST['num'] == 1){
$edit = "UPDATE op_orden_compra_proveedor SET descuento = '".$_POST['valor']."'";

}else if($_POST['num'] == 2){
$edit = "UPDATE op_orden_compra_proveedor SET envio_cp = '".$_POST['valor']."'";

}

$sql = "$edit
WHERE id = '".$_POST['idProveedor']."' ";

if(mysqli_query($con, $sql)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------
?> 