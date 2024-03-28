<?php
require('../../../app/help.php');

$aleatorio = uniqid();

$NoDoc1  =   $_FILES['Documento_file']['name'];
$UpDoc1 = "../../../archivos/recibos-nomina/".$aleatorio."-".$NoDoc1;
$NomDoc1 = $aleatorio."-".$NoDoc1;


if($NoDoc1 != ""){
if(move_uploaded_file($_FILES['Documento_file']['tmp_name'], $UpDoc1)){


$sql_edit2 = "UPDATE op_recibo_nomina SET 
    percepciones = '".$_POST['Percepciones']."',
    deducciones = '".$_POST['Deducciones']."',
    isr = '".$_POST['ISR']."',
    isr_retenido = '".$_POST['ISR2']."',
    total = '".$_POST['Total']."',
    nomina = '".$NomDoc1."'

    WHERE id =  '".$_POST['idNomina']."' ";


if(mysqli_query($con, $sql_edit2)){
echo 1;

}else{
echo 0;
}

}

}else{

    $sql_edit2 = "UPDATE op_recibo_nomina SET 
    percepciones = '".$_POST['Percepciones']."',
    deducciones = '".$_POST['Deducciones']."',
    isr = '".$_POST['ISR']."',
    isr_retenido = '".$_POST['ISR2']."',
    total = '".$_POST['Total']."'

    WHERE id =  '".$_POST['idNomina']."' ";


if(mysqli_query($con, $sql_edit2)){
echo 1;

}else{
echo 0;
}

}


  
//------------------
mysqli_close($con);
//------------------ 