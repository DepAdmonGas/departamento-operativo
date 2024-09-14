<?php
require('../../../app/help.php');

$idFormato = $_POST['idFormato'];
$tipoFirma = $_POST['tipoFirma'];
$TokenValidacion = $_POST['TokenValidacion'];

$Firma = "Firma: ".bin2hex(random_bytes(64)).".".uniqid();
 
if($tipoFirma == "B"){
$estado = 2;

}else if($tipoFirma == "C"){
$estado = 3;
}
 
$sqlLocalidad = "SELECT * FROM op_rh_formatos WHERE id = '".$idFormato."' ";
$resultLocalidad = mysqli_query($con, $sqlLocalidad);
$numeroLocalidad = mysqli_num_rows($resultLocalidad);
while($rowLocalidad = mysqli_fetch_array($resultLocalidad, MYSQLI_ASSOC)){
$Estacion = $rowLocalidad['id_localidad'];	
$formato = $rowLocalidad['formato'];  
}

$sql = "SELECT * FROM op_rh_formatos_token WHERE id_formato = '".$idFormato."' and id_usuario = '".$Session_IDUsuarioBD."' and token = '".$TokenValidacion."' ORDER BY id ASC LIMIT 1 ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

if($numero == 1){

if($formato == 1 AND $tipoFirma == "C"){

$sql_lista = "SELECT * FROM op_rh_formatos_alta WHERE id_formulario = '".$idFormato."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$Fecha = $row_lista['fecha_ingreso'];
$NombreC = $row_lista['apellido_p'].' '.$row_lista['apellido_m'].' '.$row_lista['nombres'];
$Puesto = $row_lista['puesto'];

$ine = $row_lista['ine'];
$curp = $row_lista['curp'];
$rfc = $row_lista['rfc'];
$nss = $row_lista['nss'];

$SalarioD = $row_lista['sd'];
$Documento = $row_lista['documento'];
GuardarPersonal($Estacion,$Fecha,$NombreC,$Puesto,$ine,$curp,$rfc,$nss,$SalarioD,$Documento,$con);
}
  
} 


if($formato == 6 AND $tipoFirma == "C"){

$sql_lista = "SELECT id_personal, sueldo FROM op_rh_formatos_ajuste_salarial WHERE id_formulario = '".$idFormato."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$GET_idpersonal = $row_lista['id_personal'];
$sueldo = $row_lista['sueldo'];

EditarSalario($GET_idpersonal,$sueldo,$con);
}
 
}

 
if($formato == 4){

$sql_lista = "SELECT * FROM op_rh_formatos_baja WHERE id_formulario = '".$idFormato."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$idPersonal = $row_lista['id_personal'];
$fecha_baja = $row_lista['fecha_baja'];
$motivo_baja = $row_lista['baja'];
$archivo_renuncia = $row_lista['archivo'];

EditarPersonal($idPersonal,$con);  
BajaPersonal($idPersonal,$fecha_baja,$motivo_baja,$archivo_renuncia, $con);
}
  
} 

$sql = "UPDATE op_rh_formatos SET 
status = '".$estado."'
WHERE id = '".$idFormato."' ";

if(mysqli_query($con, $sql)){

$sql_insert2 = "INSERT INTO op_rh_formatos_firma (
id_formato,
id_usuario,
tipo_firma,
firma
    )
    VALUES 
    (
    '".$idFormato."',
    '".$Session_IDUsuarioBD."',
    '".$tipoFirma."',
    '".$Firma."'
    )";

if(mysqli_query($con, $sql_insert2)){
echo 1;	
}else{
echo 0;
}
}else{
echo 0;
}


}else{
echo 0;	
}
 

function GuardarPersonal($Estacion,$Fecha,$NombreC,$Puesto,$ine,$curp,$rfc,$nss,$SalarioD,$Documento,$con){
$sql_insert = "INSERT INTO op_rh_personal (
id_estacion,fecha_ingreso,nombre_completo,puesto,ine,curp,rfc,nss,sd,documentos,estado
    )
    VALUES 
    (
    '".$Estacion."',
    '".$Fecha."',
    '".$NombreC."',
    '".$Puesto."',
    '".$ine."',    
    '".$curp."',
    '".$rfc."',
    '".$nss."',
    '".$SalarioD."',
    '".$Documento."',
    1
    )";
mysqli_query($con, $sql_insert);
}


function EditarSalario($GET_idpersonal,$sueldo,$con){
$sql = "UPDATE op_rh_personal SET 
sd = '".$sueldo."'
WHERE id = '".$GET_idpersonal."' ";
mysqli_query($con, $sql);
}



function EditarPersonal($idPersonal,$con){
$sql = "UPDATE op_rh_personal SET 
estado = 0
WHERE id = '".$idPersonal."' ";
mysqli_query($con, $sql);
}


function BajaPersonal($idPersonal,$fecha_baja,$motivo_baja,$archivo_renuncia, $con){
$sql_insert = "INSERT INTO op_rh_personal_baja_v2 (
id_personal, fecha_baja, motivo_baja, archivo_renuncia, proceso
    )
    VALUES 
    (
    '".$idPersonal."',
    '".$fecha_baja."',
    '".$motivo_baja."',
    '".$archivo_renuncia."',
    ''
    )";
    
mysqli_query($con, $sql_insert);
}





//------------------
mysqli_close($con);
//------------------



 