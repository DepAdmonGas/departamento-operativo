<?php
require('../../../app/help.php');

if($_POST['tipo'] == "2"){
$sql_insert = "UPDATE tb_organigrama_plantilla SET documento_perfil = '' WHERE id = '".$_POST['idPlantilla']."'";
}
     
if($_POST['tipo'] == "1"){
$sql_insert = "UPDATE tb_organigrama_plantilla SET documento_contrato = '' WHERE id = '".$_POST['idPlantilla']."'";
}
        
if(mysqli_query($con, $sql_insert)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------
