<?php
require('../../../app/help.php');

if($_POST['num'] == 1){
$edit = "UPDATE tb_organigrama_estaciones SET registro_patronal = '".$_POST['valor']."'";

}else if($_POST['num'] == 2){
$edit = "UPDATE tb_organigrama_estaciones SET calle = '".$_POST['valor']."'";

}else if($_POST['num'] == 3){
$edit = "UPDATE tb_organigrama_estaciones SET numero_exterior = '".$_POST['valor']."'";

}else if($_POST['num'] == 4){
$edit = "UPDATE tb_organigrama_estaciones SET numero_interior = '".$_POST['valor']."'";
    
}else if($_POST['num'] == 5){
$edit = "UPDATE tb_organigrama_estaciones SET colonia = '".$_POST['valor']."'";
    
}else if($_POST['num'] == 6){
$edit = "UPDATE tb_organigrama_estaciones SET codigo_postal = '".$_POST['valor']."'";
    
}else if($_POST['num'] == 7){
$edit = "UPDATE tb_organigrama_estaciones SET estado = '".$_POST['valor']."'";
        
}else if($_POST['num'] == 8){
$edit = "UPDATE tb_organigrama_estaciones SET municipio = '".$_POST['valor']."'";
        
}else if($_POST['num'] == 9){
$edit = "UPDATE tb_organigrama_estaciones SET numero_telefono = '".$_POST['valor']."'";
            
}

$sql = "$edit
WHERE id = '".$_POST['id']."' ";

if(mysqli_query($con, $sql)){
echo 1;
}else{
echo 0;
}

//------------------
mysqli_close($con);
//------------------