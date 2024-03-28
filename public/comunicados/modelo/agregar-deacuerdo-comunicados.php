<?php
require('../../../app/help.php');

$idComunicado = $_POST['idComunicado'];
$idGerente = $_POST['idGerente'];


$sql_visto = "INSERT INTO tb_comunicados_grte (id_comunicado,id_gerente)
VALUES (".$idComunicado.",".$idGerente.")";

if(mysqli_query($con, $sql_visto)){
echo 1;
}else{
echo 0;
}


//------------------
mysqli_close($con);
//------------------



































