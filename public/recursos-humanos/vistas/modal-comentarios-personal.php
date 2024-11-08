<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idPersonal = $_GET['idPersonal'];

function Responsable($id, $con){
$sql_resp = "SELECT * FROM tb_usuarios WHERE id = '".$id."'  ";
$result_resp = mysqli_query($con, $sql_resp);
$numero_resp = mysqli_num_rows($result_resp);
    
while($row_resp = mysqli_fetch_array($result_resp, MYSQLI_ASSOC)){
$Usuario = $row_resp['nombre'];          
}
    
return $Usuario;
    
}


$sql_resp = "SELECT nombre_completo FROM op_rh_personal WHERE id = '".$idPersonal."'  ";
$result_resp = mysqli_query($con, $sql_resp);
$numero_resp = mysqli_num_rows($result_resp);
        
while($row_resp = mysqli_fetch_array($result_resp, MYSQLI_ASSOC)){
$personalName = $row_resp['nombre_completo'];          
}
        

$sql_comen = "SELECT * FROM op_rh_personal_comentarios WHERE id_personal = '".$idPersonal."' ORDER BY id DESC ";
$result_comen = mysqli_query($con, $sql_comen);
$numero_comen = mysqli_num_rows($result_comen);

?>


<div class="modal-header">
    <h5 class="modal-title">Comentarios - <?=$personalName?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
<div class="border-bottom" style="height: 300px;overflow: auto;">


<?php

if ($numero_comen > 0) {
    while($row_comen = mysqli_fetch_array($result_comen, MYSQLI_ASSOC)){
    $idUsuario = $row_comen['id_usuario'];
    $comentario = $row_comen['comentario'];
    
    $NomUsuario = Responsable($idUsuario, $con);
    
    if ($Session_IDUsuarioBD == $idUsuario) {
    $margin = "margin-left: 30px;margin-right: 5px;";
    }else{
    $margin = "margin-right: 30px;margin-left: 5px;";
    }
    
    $fechaExplode = explode(" ", $row_comen['fecha_hora']);
    $FechaFormato = FormatoFecha($fechaExplode[0]);
    $HoraFormato = date("g:i a",strtotime($fechaExplode[1]));
    ?>
    <div class="mt-1" style="<?=$margin;?>">
    
    <div style="font-size: .7em;" class="mb-1"><?=$NomUsuario;?></div>
    <div class="bg-primary text-white" style="border-radius: 30px;">
    <p class="p-2 pb-0"><?=$comentario;?></p>
    </div>
    <div class="text-end" style="font-size: .7em;margin-top: -10px"><?=$FechaFormato;?>, <?=$HoraFormato;?></div>
    
    </div>
    <?php
    }
    }else{
        echo "<div class='text-center' style='margin-top: 150px;'><small>No se encontraron comentarios</small></div>";
    }

?>

</div>

<div class="mb-1 text-secondary mt-2">COMENTARIO:</div>
<textarea class="form-control rounded-0" id="Comentario"></textarea>

</div>


<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="GuardarComentario(<?=$idEstacion?>,<?=$idPersonal?>)">Guardar</button>
</div>