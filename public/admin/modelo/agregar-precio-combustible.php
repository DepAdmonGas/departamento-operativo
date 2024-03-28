<?php
require('../../../app/help.php');

$sql = "SELECT * FROM op_precio_combustible WHERE fecha = '".$_POST['Fecha']."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero == 0) {
    $sql_insert1 = "INSERT INTO op_precio_combustible (
    id_estacion,
    fecha,
    dato1,
    dato2,
    dato3,
    dato4,
    dato5,
    dato6,
    dato7,
    dato8,
    dato9
    )
    VALUES 
    (
    1,
    '".$_POST['Fecha']."',
    '".$_POST['IP11']."',
    '".$_POST['IP21']."',
    '".$_POST['IP31']."',
    '".$_POST['IP41']."',
    '".$_POST['IP51']."',
    '".$_POST['IP61']."',
    '".$_POST['IP71']."',
    '".$_POST['IP81']."',
    '".$_POST['IP91']."'
    )";
    
    if(mysqli_query($con, $sql_insert1)){ 
	
    }else{
    
    }

    //---------------------------------------------------------------------------

    $sql_insert2 = "INSERT INTO op_precio_combustible (
    id_estacion,
    fecha,
    dato1,
    dato2,
    dato3,
    dato4,
    dato5,
    dato6,
    dato7,
    dato8,
    dato9
    )
    VALUES 
    (
    2,
    '".$_POST['Fecha']."',
    '".$_POST['IP12']."',
    '".$_POST['IP22']."',
    '".$_POST['IP32']."',
    '".$_POST['IP42']."',
    '".$_POST['IP52']."',
    '".$_POST['IP62']."',
    '".$_POST['IP72']."',
    '".$_POST['IP82']."',
    '".$_POST['IP92']."'
    )";
    
    if(mysqli_query($con, $sql_insert2)){ 
	
    }else{
    
    }
    //-------------------------------------------------------------------------

    $sql_insert3 = "INSERT INTO op_precio_combustible (
    id_estacion,
    fecha,
    dato1,
    dato2,
    dato3,
    dato4,
    dato5,
    dato6,
    dato7,
    dato8,
    dato9
    )
    VALUES 
    (
    3,
    '".$_POST['Fecha']."',
    '".$_POST['IP13']."',
    '".$_POST['IP23']."',
    '".$_POST['IP33']."',
    '".$_POST['IP43']."',
    '".$_POST['IP53']."',
    '".$_POST['IP63']."',
    '".$_POST['IP73']."',
    '".$_POST['IP83']."',
    '".$_POST['IP93']."'
    )";
    
    if(mysqli_query($con, $sql_insert3)){ 
	
    }else{
    
    }

    //-------------------------------------------------------------------------

    $sql_insert4 = "INSERT INTO op_precio_combustible (
    id_estacion,
    fecha,
    dato1,
    dato2,
    dato3,
    dato4,
    dato5,
    dato6,
    dato7,
    dato8,
    dato9
    )
    VALUES 
    (
    4,
    '".$_POST['Fecha']."',
    '".$_POST['IP14']."',
    '".$_POST['IP24']."',
    '".$_POST['IP34']."',
    '".$_POST['IP44']."',
    '".$_POST['IP54']."',
    '".$_POST['IP64']."',
    '".$_POST['IP74']."',
    '".$_POST['IP84']."',
    '".$_POST['IP94']."'
    )";
    
    if(mysqli_query($con, $sql_insert4)){ 
	
    }else{
    
    }

    //-------------------------------------------------------------------------

    $sql_insert5 = "INSERT INTO op_precio_combustible (
    id_estacion,
    fecha,
    dato1,
    dato2,
    dato3,
    dato4,
    dato5,
    dato6,
    dato7,
    dato8,
    dato9
    )
    VALUES 
    (
    5,
    '".$_POST['Fecha']."',
    '".$_POST['IP15']."',
    '".$_POST['IP25']."',
    '".$_POST['IP35']."',
    '".$_POST['IP45']."',
    '".$_POST['IP55']."',
    '".$_POST['IP65']."',
    '".$_POST['IP75']."',
    '".$_POST['IP85']."',
    '".$_POST['IP95']."'
    )";
    
    if(mysqli_query($con, $sql_insert5)){ 
	
    }else{
    
    }

    //-------------------------------------------------------------------------

    $sql_insert6 = "INSERT INTO op_precio_combustible (
    id_estacion,
    fecha,
    dato1,
    dato2,
    dato3,
    dato4,
    dato5,
    dato6,
    dato7,
    dato8,
    dato9
    )
    VALUES 
    (
    6,
    '".$_POST['Fecha']."',
    '".$_POST['IP16']."',
    '".$_POST['IP26']."',
    '".$_POST['IP36']."',
    '".$_POST['IP46']."',
    '".$_POST['IP56']."',
    '".$_POST['IP66']."',
    '".$_POST['IP76']."',
    '".$_POST['IP86']."',
    '".$_POST['IP96']."'
    )";
    
    if(mysqli_query($con, $sql_insert6)){ 
	
    }else{
    
    }

    //-------------------------------------------------------------------------

    $sql_insert7 = "INSERT INTO op_precio_combustible (
    id_estacion,
    fecha,
    dato1,
    dato2,
    dato3,
    dato4,
    dato5,
    dato6,
    dato7,
    dato8,
    dato9
    )
    VALUES 
    (
    7,
    '".$_POST['Fecha']."',
    '".$_POST['IP17']."',
    '".$_POST['IP27']."',
    '".$_POST['IP37']."',
    '".$_POST['IP47']."',
    '".$_POST['IP57']."',
    '".$_POST['IP67']."',
    '".$_POST['IP77']."',
    '".$_POST['IP87']."',
    '".$_POST['IP97']."'
    )";
    
    if(mysqli_query($con, $sql_insert7)){ 
	
    }else{
    
    }

echo 1;

}else{

echo 0;
}

//------------------
mysqli_close($con);
//------------------