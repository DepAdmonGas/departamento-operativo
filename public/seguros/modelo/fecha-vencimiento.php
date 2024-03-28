<?php
require('../../../app/help.php');

$EmisionP = $_POST['EmisionP'];

$fecha = date("Y-m-d",strtotime($EmisionP."+ 1 year"));
$Resultado = '<input class="form-control" type="date" id="VencimientoP" value="'.$fecha.'" >';	

echo $Resultado;