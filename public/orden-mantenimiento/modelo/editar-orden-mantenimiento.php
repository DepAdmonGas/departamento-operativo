<?php
require('../../../app/help.php');

$idReporte = $_POST['idReporte'];

if($_POST['categoria'] == 1){

$sql1 = "UPDATE op_orden_mantenimiento SET 
    tipo_mantenimiento = '".$_POST['valor']."'
    WHERE id = '".$idReporte."' ";

    if(mysqli_query($con, $sql1)){
    echo 1;
    }else{
    echo 0;
    }

}else if($_POST['categoria'] == 2){

$sql1 = "UPDATE op_orden_mantenimiento SET 
    tipo_trabajo = '".$_POST['valor']."'
    WHERE id = '".$idReporte."' ";

    if(mysqli_query($con, $sql1)){
    echo 1;
    }else{
    echo 0;
    }

}else if($_POST['categoria'] == 3){

$sql1 = "UPDATE op_orden_mantenimiento SET 
    seguimiento = '".$_POST['valor']."'
    WHERE id = '".$idReporte."' ";

    if(mysqli_query($con, $sql1)){
    echo 1;
    }else{
    echo 0;
    }

}else if($_POST['categoria'] == 4){

$sql1 = "UPDATE op_orden_mantenimiento SET 
    trabajo_terminado = '".$_POST['valor']."'
    WHERE id = '".$idReporte."' ";

    if(mysqli_query($con, $sql1)){
    echo 1;
    }else{
    echo 0;
    }

}else if($_POST['categoria'] == 5){

$sql1 = "UPDATE op_orden_mantenimiento SET 
    contrato_vigente = '".$_POST['valor']."'
    WHERE id = '".$idReporte."' ";

    if(mysqli_query($con, $sql1)){
    echo 1;
    }else{
    echo 0;
    }

}else if($_POST['categoria'] == 6){

$sql1 = "UPDATE op_orden_mantenimiento SET 
    garantia_trabajo = '".$_POST['valor']."'
    WHERE id = '".$idReporte."' ";

    if(mysqli_query($con, $sql1)){
    echo 1;
    }else{
    echo 0;
    }

}else if($_POST['categoria'] == 7){

$sql1 = "UPDATE op_orden_mantenimiento SET 
    marco_normativo = '".$_POST['valor']."'
    WHERE id = '".$idReporte."' ";

    if(mysqli_query($con, $sql1)){
    echo 1;
    }else{
    echo 0;
    }

}else if($_POST['categoria'] == 8){

$sql1 = "UPDATE op_orden_mantenimiento SET 
    entrada_vigor = '".$_POST['valor']."'
    WHERE id = '".$idReporte."' ";

    if(mysqli_query($con, $sql1)){
    echo 1;
    }else{
    echo 0;
    }

}else if($_POST['categoria'] == 9){

$sql1 = "UPDATE op_orden_mantenimiento SET 
    estatus_tramite = '".$_POST['valor']."'
    WHERE id = '".$idReporte."' ";

    if(mysqli_query($con, $sql1)){
    echo 1;
    }else{
    echo 0;
    }

}else if($_POST['categoria'] == 10){

$sql1 = "UPDATE op_orden_mantenimiento SET 
    descripcion = '".$_POST['valor']."'
    WHERE id = '".$idReporte."' ";

    if(mysqli_query($con, $sql1)){
    echo 1;
    }else{
    echo 0;
    }

}else if($_POST['categoria'] == 11){

$sql1 = "UPDATE op_orden_mantenimiento SET 
    obervaciones = '".$_POST['valor']."'
    WHERE id = '".$idReporte."' ";

    if(mysqli_query($con, $sql1)){
    echo 1;
    }else{
    echo 0;
    }

}else if($_POST['categoria'] == 12){

$sql1 = "UPDATE op_orden_mantenimiento_area SET 
    estatus = '".$_POST['valor']."'
    WHERE id = '".$idReporte."' ";

    if(mysqli_query($con, $sql1)){
    echo 1;
    }else{
    echo 0;
    }

}else if($_POST['categoria'] == 13){

$sql1 = "UPDATE op_orden_mantenimiento_trabajo SET 
    estatus = '".$_POST['valor']."'
    WHERE id = '".$idReporte."' ";

    if(mysqli_query($con, $sql1)){
    echo 1;
    }else{
    echo 0;
    }

}else if($_POST['categoria'] == 14){

$sql1 = "UPDATE op_orden_mantenimiento_trabajo SET 
    detalle = '".$_POST['valor']."'
    WHERE id = '".$idReporte."' ";

    if(mysqli_query($con, $sql1)){
    echo 1;
    }else{
    echo 0;
    }

}


//------------------
mysqli_close($con);
//------------------