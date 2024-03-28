<?php
require('../../../app/help.php');

$sql_update = "UPDATE op_almacen_proveedores SET 

fecha = '".$_POST['Fecha']."',
razon_social = '".$_POST['RazonSocial']."',
actividad_economica = '".$_POST['ActividadEco']."',
email = '".$_POST['Email']."',
rfc = '".$_POST['RFC']."',
ciudad = '".$_POST['Ciudad']."',
telefono_1 = '".$_POST['Telefono1']."',
telefono_2 = '".$_POST['Telefono2']."',
direccion = '".$_POST['Direccion']."',
beneficiario = '".$_POST['Beneficiario']."',
banco = '".$_POST['Banco']."',
metodo_pago = '".$_POST['Metodopago']."',
cfdi = '".$_POST['CFDI']."',
moneda = '".$_POST['Moneda']."',
forma_pago = '".$_POST['FormaPago']."',
descripcion = '".$_POST['Descripcion']."'

WHERE id ='".$_POST['idProveedor']."' ";
 
	if (mysqli_query($con, $sql_update)) {
	echo 1;
	}else{
	echo 0;		
	}

?>