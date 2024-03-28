 <?php
require('../../../app/help.php');

$sql_edit1 = "UPDATE op_orden_compra_proveedor SET 
   razon_social = '".$_POST['RazonSocial']."',
   direccion = '".$_POST['Direccion']."',
   contacto = '".$_POST['Contacto']."',
   email = '".$_POST['Email']."'

   WHERE id = '".$_POST['idProveedor']."' ";


if(mysqli_query($con, $sql_edit1)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------