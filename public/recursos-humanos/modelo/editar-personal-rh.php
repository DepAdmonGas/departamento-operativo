<?php
require('../../../app/help.php');
 
function nombreDepartamento($idEstacion, $con){
    $sql = "SELECT localidad
    FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
  
    $result = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $localidad = $row['localidad'];
    }
    return $localidad; 
}


//$aleatorio = uniqid();
$numeroAleatorio = rand(1, 1000000);
  
//$aleatorio = uniqid();
$numeroAleatorio2 = rand(1000, 9999);

$idEstacion = $_POST['idEstacion'];
$localidad = nombreDepartamento($idEstacion,$con);

  
$DocumentoPersonal_file  =   $_FILES['DocumentoPersonal_file']['name'];
$extension1 = pathinfo($DocumentoPersonal_file, PATHINFO_EXTENSION);
$upload_DocumentoPersonal_file = "../../../archivos/documentos-personal/requisicion/".$numeroAleatorio."-Requisicion-".$localidad."-".$numeroAleatorio2 . "." . $extension1;
$Requisicion = $numeroAleatorio."-Requisicion-".$localidad."-".$numeroAleatorio2 . "." . $extension1;

$DocumentoCV_file  =   $_FILES['DocumentoCV_file']['name'];
$extension2 = pathinfo($DocumentoCV_file, PATHINFO_EXTENSION);
$upload_DocumentoCV_file = "../../../archivos/documentos-personal/curriculum/".$numeroAleatorio."-Curriculum-".$localidad."-".$numeroAleatorio2 . "." . $extension2;
$CV = $numeroAleatorio."-Curriculum-".$localidad."-".$numeroAleatorio2 . "." . $extension2;

$DocumentoINE_file  =   $_FILES['DocumentoINE_file']['name'];
$extension3 = pathinfo($DocumentoINE_file, PATHINFO_EXTENSION);
$upload_DocumentoINE_file = "../../../archivos/documentos-personal/ine/".$numeroAleatorio."-Identificacion-".$localidad."-".$numeroAleatorio2. "." . $extension3;
$INE = $numeroAleatorio."-Identificacion-".$localidad."-".$numeroAleatorio2. "." . $extension3;

$DocumentoNacimiento_file  =   $_FILES['DocumentoNacimiento_file']['name'];
$extension4 = pathinfo($DocumentoNacimiento_file, PATHINFO_EXTENSION);
$upload_DocumentoNacimiento_file = "../../../archivos/documentos-personal/acta_nacimiento/".$numeroAleatorio."-Acta de Nacimiento-".$localidad."-".$numeroAleatorio2. "." . $extension4;
$Acta_nacimiento = $numeroAleatorio."-Acta de Nacimiento-".$localidad."-".$numeroAleatorio2. "." . $extension4;

$DocumentoDomicilio_file  =   $_FILES['DocumentoDomicilio_file']['name'];
$extension5 = pathinfo($DocumentoDomicilio_file, PATHINFO_EXTENSION);
$upload_DocumentoDomicilio_file = "../../../archivos/documentos-personal/comprobante_domicilio/".$numeroAleatorio."-Comprobante de Domicilio-".$localidad."-".$numeroAleatorio2. "." . $extension5;
$C_Domicilio = $numeroAleatorio."-Comprobante de Domicilio-".$localidad."-".$numeroAleatorio2. "." . $extension5;

$DocumentoNSS_file  =   $_FILES['DocumentoNSS_file']['name'];
$extension6 = pathinfo($DocumentoNSS_file, PATHINFO_EXTENSION);
$upload_DocumentoNSS_file = "../../../archivos/documentos-personal/nss/".$numeroAleatorio."-Comprobante IMSS-".$localidad."-".$numeroAleatorio2. "." . $extension6;
$NSS = $numeroAleatorio."-Comprobante IMSS-".$localidad."-".$numeroAleatorio2. "." . $extension6;

$DocumentoEstudios_file  =   $_FILES['DocumentoEstudios_file']['name'];
$extension7 = pathinfo($DocumentoEstudios_file, PATHINFO_EXTENSION);
$upload_DocumentoEstudios_file = "../../../archivos/documentos-personal/comprobante_estudios/".$numeroAleatorio."-Comprobante de Estudios-".$localidad."-".$numeroAleatorio2. "." . $extension7;
$C_Estudios = $numeroAleatorio."-Comprobante de Estudios-".$localidad."-".$numeroAleatorio2. "." . $extension7;

$DocumentoRecomendacion_file  =   $_FILES['DocumentoRecomendacion_file']['name'];
$extension8 = pathinfo($DocumentoRecomendacion_file, PATHINFO_EXTENSION);
$upload_DocumentoRecomendacion_file = "../../../archivos/documentos-personal/cartas_recomendacion/".$numeroAleatorio."-Carta de Recomendacion-".$localidad."-".$numeroAleatorio2. "." . $extension8;
$C_Recomendacion = $numeroAleatorio."-Carta de Recomendacion-".$localidad."-".$numeroAleatorio2. "." . $extension8;

$DocumentoCURP_file  =   $_FILES['DocumentoCURP_file']['name'];
$extension9 = pathinfo($DocumentoCURP_file, PATHINFO_EXTENSION);
$upload_DocumentoCURP_file = "../../../archivos/documentos-personal/curp/".$numeroAleatorio."-CURP-".$localidad."-".$numeroAleatorio2. "." . $extension9;
$CURP = $numeroAleatorio."-CURP-".$localidad."-".$numeroAleatorio2. "." . $extension9;

$DocumentoInfonavit_file  =   $_FILES['DocumentoInfonavit_file']['name'];
$extension10 = pathinfo($DocumentoInfonavit_file, PATHINFO_EXTENSION);
$upload_DocumentoInfonavit_file = "../../../archivos/documentos-personal/acta_infonavit/".$numeroAleatorio."-Aviso Infonavit-".$localidad."-".$numeroAleatorio2. "." . $extension10;
$A_Infonavit = $numeroAleatorio."-Aviso Infonavit-".$localidad."-".$numeroAleatorio2. "." . $extension10;

$DocumentoRFC_file  =   $_FILES['DocumentoRFC_file']['name'];
$extension11 = pathinfo($DocumentoRFC_file, PATHINFO_EXTENSION);
$upload_DocumentoRFC_file = "../../../archivos/documentos-personal/rfc/".$numeroAleatorio."-RFC-".$localidad."-".$numeroAleatorio2. "." . $extension11;
$RFC = $numeroAleatorio."-RFC-".$localidad."-".$numeroAleatorio2. "." . $extension11;
 
$DocumentoAntecedentes_file  =   $_FILES['DocumentoAntecedentes_file']['name'];
$extension12 = pathinfo($DocumentoAntecedentes_file, PATHINFO_EXTENSION);
$upload_DocumentoAntecedentes_file = "../../../archivos/documentos-personal/carta_antecedentes/".$numeroAleatorio."-Antecedentes Penales-".$localidad."-".$numeroAleatorio2. "." . $extension12;
$A_Penales = $numeroAleatorio."-Antecedentes Penales-".$localidad."-".$numeroAleatorio2. "." . $extension12;

$DocumentoContrato_file  =   $_FILES['DocumentoContrato_file']['name'];
$extension13 = pathinfo($DocumentoContrato_file, PATHINFO_EXTENSION);
$upload_DocumentoContrato_file = "../../../archivos/documentos-personal/contrato/".$numeroAleatorio."-Contrato-".$localidad."-".$numeroAleatorio2. "." . $extension13;
$Contrato = $numeroAleatorio."-Contrato-".$localidad."-".$numeroAleatorio2. "." . $extension13;

$tipo = $_POST['Tipo'];

if($tipo == 0){

//----- REQUISICION DEL PERSONAL -----
if($DocumentoPersonal_file != ""){
if(move_uploaded_file($_FILES['DocumentoPersonal_file']['tmp_name'], $upload_DocumentoPersonal_file)) {
$Requisicion2 = $Requisicion;
                
}else{
$Requisicion2 = "";
}
        
}

//----- CURRICULUM -----
if($DocumentoCV_file != ""){
if(move_uploaded_file($_FILES['DocumentoCV_file']['tmp_name'], $upload_DocumentoCV_file)) {
$CV2 = $CV;
                    
}else{
$CV2 = "";
}
            
}

//----- IDENTIFICACION OFICIAL -----
if($DocumentoINE_file != ""){
if(move_uploaded_file($_FILES['DocumentoINE_file']['tmp_name'], $upload_DocumentoINE_file)) {
$INE2 = $INE;
        
}else{
$INE2 = "";
}

}

//----- ACTA DE NACIMIENTO -----
if($DocumentoNacimiento_file != ""){
if(move_uploaded_file($_FILES['DocumentoNacimiento_file']['tmp_name'], $upload_DocumentoNacimiento_file)) {
$Acta_nacimiento2 = $Acta_nacimiento;
            
}else{
$Acta_nacimiento2 = "";
}
    
} 

//----- COMPROBANTE DE DOMICILIO -----
if($DocumentoDomicilio_file != ""){
if(move_uploaded_file($_FILES['DocumentoDomicilio_file']['tmp_name'], $upload_DocumentoDomicilio_file)) {
$C_Domicilio2 = $C_Domicilio;
                
}else{
$C_Domicilio2 = "";
}
        
} 

//----- AFILIACION AL IMSS -----
if($DocumentoNSS_file != ""){
if(move_uploaded_file($_FILES['DocumentoNSS_file']['tmp_name'], $upload_DocumentoNSS_file)) {
$NSS2 = $NSS;
        
}else{
$NSS2 = "";
}
}

//----- COMPROBANTE DE ESTUDIOS -----
if($DocumentoEstudios_file != ""){
if(move_uploaded_file($_FILES['DocumentoEstudios_file']['tmp_name'], $upload_DocumentoEstudios_file)) {
$C_Estudios2 = $C_Estudios;
                
}else{
$C_Estudios2 = "";
}
}

//----- CARTAS DE RECOMENDACION -----
if($DocumentoRecomendacion_file != ""){
if(move_uploaded_file($_FILES['DocumentoRecomendacion_file']['tmp_name'], $upload_DocumentoRecomendacion_file)) {
$C_Recomendacion2 = $C_Recomendacion;
            
}else{
$C_Recomendacion2 = "";
}
}

//----- CURP -----
if($DocumentoCURP_file != ""){
if(move_uploaded_file($_FILES['DocumentoCURP_file']['tmp_name'], $upload_DocumentoCURP_file)) {
$CURP2 = $CURP;
        
}else{
$CURP2 = "";
}
}
    
//----- AVISO DE INFONAVIT -----
if($DocumentoInfonavit_file != ""){
if(move_uploaded_file($_FILES['DocumentoInfonavit_file']['tmp_name'], $upload_DocumentoInfonavit_file)) {
$A_Infonavit2 = $A_Infonavit;
                
}else{
$A_Infonavit2 = "";
}
}

//----- RFC -----
if($DocumentoRFC_file != ""){
if(move_uploaded_file($_FILES['DocumentoRFC_file']['tmp_name'], $upload_DocumentoRFC_file)) {
$RFC2 = $RFC;
        
}else{
$RFC2 = "";
}
}
    
//----- CARTA DE ANTECEDENTES PENALES -----
if($DocumentoAntecedentes_file != ""){
if(move_uploaded_file($_FILES['DocumentoAntecedentes_file']['tmp_name'], $upload_DocumentoAntecedentes_file)) {
$A_Penales2 = $A_Penales;
            
}else{
$A_Penales2 = "";
}
}   

    
//----- CONTRATO  -----
if($DocumentoContrato_file != ""){
if(move_uploaded_file($_FILES['DocumentoContrato_file']['tmp_name'], $upload_DocumentoContrato_file)) {
$Contrato2 = $Contrato;
        
}else{
$Contrato2 = "";
}
}
    

$sql_add = "INSERT INTO op_rh_personal 
(id_estacion,
fecha_ingreso,
no_colaborador,
nombre_completo,
puesto,
sd,

requisicion,
curriculum,
ine,
acta_nacimiento,
c_domicilio,
nss,
c_estudios,
c_recomendacion,
curp,
a_infonavit,
rfc,
c_antecedentes,

contrato,
estado)

VALUES
 
('".$_POST['idEstacion']."',
'".$_POST['FechaIngreso']."',
'".$_POST['NoColaborador']."',
'".$_POST['NombresCompleto']."',
'".$_POST['Puesto']."',
'".$_POST['sd']."',

'".$Requisicion2."',
'".$CV2."',
'".$INE2."',
'".$Acta_nacimiento2."',
'".$C_Domicilio2."',
'".$NSS2."',
'".$C_Estudios2."',
'".$C_Recomendacion2."',
'".$CURP2."',
'".$A_Infonavit2."',
'".$RFC2."',
'".$A_Penales2."',

'',
1)";


if(mysqli_query($con, $sql_add)){
    echo 1;
}else{
    echo 0;
}


}else{

//----- REQUISICION DEL PERSONAL -----
if($DocumentoPersonal_file != ""){
if(move_uploaded_file($_FILES['DocumentoPersonal_file']['tmp_name'], $upload_DocumentoPersonal_file)) {
             
$sql_edit = "UPDATE op_rh_personal SET 
requisicion = '".$Requisicion."' WHERE id ='".$_POST['idPersonal']."' ";
mysqli_query($con, $sql_edit);
            
}
}

//----- CURRICULUM -----
if($DocumentoCV_file != ""){
if(move_uploaded_file($_FILES['DocumentoCV_file']['tmp_name'], $upload_DocumentoCV_file)) {
                 
$sql_edit = "UPDATE op_rh_personal SET 
curriculum = '".$CV."' WHERE id ='".$_POST['idPersonal']."' ";
mysqli_query($con, $sql_edit);
                
}
}

//----- IDENTIFICACION OFICIAL -----
if($DocumentoINE_file != ""){
if(move_uploaded_file($_FILES['DocumentoINE_file']['tmp_name'], $upload_DocumentoINE_file)) {
             
$sql_edit = "UPDATE op_rh_personal SET 
ine = '".$INE."' WHERE id ='".$_POST['idPersonal']."' ";
mysqli_query($con, $sql_edit);
            
}
}


//----- ACTA DE NACIMIENTO -----
if($DocumentoNacimiento_file != ""){
if(move_uploaded_file($_FILES['DocumentoNacimiento_file']['tmp_name'], $upload_DocumentoNacimiento_file)) {
                     
$sql_edit = "UPDATE op_rh_personal SET 
acta_nacimiento = '".$Acta_nacimiento."' WHERE id ='".$_POST['idPersonal']."' ";
mysqli_query($con, $sql_edit);
                    
}
}


//----- COMPROBANTE DE DOMICILIO -----
if($DocumentoDomicilio_file != ""){
if(move_uploaded_file($_FILES['DocumentoDomicilio_file']['tmp_name'], $upload_DocumentoDomicilio_file)) {
                         
$sql_edit = "UPDATE op_rh_personal SET 
c_domicilio = '".$C_Domicilio."' WHERE id ='".$_POST['idPersonal']."' ";
mysqli_query($con, $sql_edit);
                        
}
}
       

//----- AFILIACION AL IMSS -----
if($DocumentoNSS_file != ""){
if(move_uploaded_file($_FILES['DocumentoNSS_file']['tmp_name'], $upload_DocumentoNSS_file)) {
    
$sql_edit = "UPDATE op_rh_personal SET 
nss = '".$NSS."'WHERE id ='".$_POST['idPersonal']."' ";
mysqli_query($con, $sql_edit);
    
}
}

//----- COMPROBANTE DE ESTUDIOS -----
if($DocumentoEstudios_file != ""){
if(move_uploaded_file($_FILES['DocumentoEstudios_file']['tmp_name'], $upload_DocumentoEstudios_file)) {
                             
$sql_edit = "UPDATE op_rh_personal SET 
c_estudios = '".$C_Estudios."' WHERE id ='".$_POST['idPersonal']."' ";
mysqli_query($con, $sql_edit);
                            
}
}

//----- CARTAS DE RECOMENDACION -----
if($DocumentoRecomendacion_file != ""){
if(move_uploaded_file($_FILES['DocumentoRecomendacion_file']['tmp_name'], $upload_DocumentoRecomendacion_file)) {
                                 
$sql_edit = "UPDATE op_rh_personal SET 
c_recomendacion = '".$C_Recomendacion."' WHERE id ='".$_POST['idPersonal']."' ";
mysqli_query($con, $sql_edit);
                                
}
}

//----- CURP -----
if($DocumentoCURP_file != ""){
if(move_uploaded_file($_FILES['DocumentoCURP_file']['tmp_name'], $upload_DocumentoCURP_file)) {
    
$sql_edit = "UPDATE op_rh_personal SET 
curp = '".$CURP."'
WHERE id ='".$_POST['idPersonal']."' ";
mysqli_query($con, $sql_edit);
    
}
}

//----- AVISO DE INFONAVIT -----
if($DocumentoInfonavit_file != ""){
if(move_uploaded_file($_FILES['DocumentoInfonavit_file']['tmp_name'], $upload_DocumentoInfonavit_file)) {
                                     
$sql_edit = "UPDATE op_rh_personal SET 
a_infonavit = '".$A_Infonavit."' WHERE id ='".$_POST['idPersonal']."' ";
mysqli_query($con, $sql_edit);
                                    
}
}
    

//----- CONSTANCIA DE SITUACION FISCAL-----
if($DocumentoRFC_file != ""){
if(move_uploaded_file($_FILES['DocumentoRFC_file']['tmp_name'], $upload_DocumentoRFC_file)) {
    
$sql_edit = "UPDATE op_rh_personal SET 
rfc = '".$RFC."' WHERE id ='".$_POST['idPersonal']."' ";
mysqli_query($con, $sql_edit);
    
}
}


//----- CARTA DE ANTESCEDENTES NO PENALES -----
if($DocumentoAntecedentes_file != ""){
if(move_uploaded_file($_FILES['DocumentoAntecedentes_file']['tmp_name'], $upload_DocumentoAntecedentes_file)) {
                                         
$sql_edit = "UPDATE op_rh_personal SET 
c_antecedentes = '".$A_Penales."' WHERE id ='".$_POST['idPersonal']."' ";
mysqli_query($con, $sql_edit);
                                        
}
}


//----- CONTRATO -----
if($DocumentoContrato_file != ""){
if(move_uploaded_file($_FILES['DocumentoContrato_file']['tmp_name'], $upload_DocumentoContrato_file)) {
    
$sql_edit = "UPDATE op_rh_personal SET 
contrato = '".$Contrato."' WHERE id ='".$_POST['idPersonal']."' ";
mysqli_query($con, $sql_edit);
    
}
}

$sql_edit = "UPDATE op_rh_personal SET 
no_colaborador = '".$_POST['NoColaborador']."',
fecha_ingreso = '".$_POST['FechaIngreso']."',
nombre_completo = '".$_POST['NombresCompleto']."',
puesto = '".$_POST['Puesto']."',
sd = '".$_POST['sd']."'
WHERE id = '".$_POST['idPersonal']."' ";
       
if(mysqli_query($con, $sql_edit)){
echo 1;

}else{
echo 0;
}
        
        
//------------------
mysqli_close($con);
//------------------


}

?> 