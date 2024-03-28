 <?php
require('../../../app/help.php');

$fechaCL = $_POST['fechaCL'];

$sql_edit = "UPDATE op_cuenta_litros SET fecha = '".$fechaCL."' WHERE id_cuenta_litros = '".$_POST['idCuentaLitros']."' ";
if(mysqli_query($con, $sql_edit)){
echo 1;
}else{
echo 0;   
}


//------------------
mysqli_close($con);
//------------------