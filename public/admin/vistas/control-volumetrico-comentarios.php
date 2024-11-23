<?php
require ('../../../app/help.php');

$IdReporte = $_GET['IdReporte'];
$idEstacion = $_GET['idEstacion'];

function Responsable($id, $con)
{

    $sql_resp = "SELECT * FROM tb_usuarios WHERE id = '" . $id . "'  ";
    $result_resp = mysqli_query($con, $sql_resp);
    $numero_resp = mysqli_num_rows($result_resp);
    while ($row_resp = mysqli_fetch_array($result_resp, MYSQLI_ASSOC)) {
        $Usuario = $row_resp['nombre'];

    }
    return $Usuario;

}
 
$sql_comen = "SELECT * FROM op_control_volumetrico_comentario WHERE id_mes = '" . $IdReporte . "' ORDER BY id DESC ";
$result_comen = mysqli_query($con, $sql_comen);
$numero_comen = mysqli_num_rows($result_comen);

?>


<div class="table-responsive mt-3">
<table class="custom-table w-100">
<thead class="tables-bg">
<tr>
<th class="align-middle text-center">Comentarios</th>
</tr>
</thead>
        
<tbody class="bg-white">
<tr>
                
<th class="text-start no-hover fw-normal">             
<div class="row bg-white">
<div class="col-12">                   
<!-- Contenedor con scroll -->
<div class="comment-section-container" style="max-height: 425px; overflow-y: auto;">

<?php
if ($numero_comen > 0) {
while ($row_comen = mysqli_fetch_array($result_comen, MYSQLI_ASSOC)) {
$idUsuario = $row_comen['id_usuario'];
$comentario = $row_comen['comentario'];
$NomUsuario = Responsable($idUsuario, $con);
$margin = ($Session_IDUsuarioBD == $idUsuario) ? "ms-5" : "ms-2";

$imgMsg = ($Session_IDUsuarioBD == $idUsuario) ? "user-msg1.png" : "user-msg2.png";

$fechaExplode = explode(" ", $row_comen['fecha_hora']);
$FechaFormato = FormatoFecha($fechaExplode[0]);
$HoraFormato = date("g:i a", strtotime($fechaExplode[1]));
?>
                                        
<div class="d-flex flex-column comment-section p-3 <?= $margin ?>">                                           
<div class="d-flex flex-row user-info">
<img class="rounded-circle" src="<?=RUTA_IMG_ICONOS.$imgMsg?>" width="40" height="40" alt="User">
<div class="d-flex flex-column justify-content-start ms-2">
<span class="d-block fw-bold name"><?= $NomUsuario; ?></span>
<span class="date text-black-50 mt-1"><?= $FechaFormato; ?>, <?= $HoraFormato; ?></span>
<!-- Burbuja de comentario -->
<span class="badge title-table-bg fw-normal text-white mt-2 p-2 shadow-sm text-start" style="font-size: 0.8rem; border-radius: 12px;">
<?= $comentario; ?>
</span>
</div>
</div>
</div>
                                                      
<?php
}
} else {
echo '

<div class="d-flex flex-column comment-section p-3">                                           
<div class="d-flex flex-row user-info">
<img class="rounded-circle" src="'.RUTA_IMG_ICONOS.'user-msg1.png" width="40" height="40" alt="User">
<div class="d-flex flex-column justify-content-start ms-2">
<span class="d-block fw-bold name">Sin nombre de usuario</span>
<span class="date text-black-50 mt-1">Fecha y hora no disponibles</span>
<!-- Burbuja de comentario -->
<span class="badge title-table-bg fw-normal text-white mt-2 p-2 shadow-sm text-start" style="font-size: 0.8rem; border-radius: 12px;">
No se encontraron comentarios
</span>
</div>
</div>
</div>

';
}
?>
</div>
</div>
</div>
</th>
</tr>

<!-- Sección de entrada de texto -->
<tr>
<th class="text-start no-hover ">
<div class="d-flex flex-row align-items-start ">
<textarea class="form-control shadow-none textarea" id="Comentario" placeholder="Escribe tu comentario aquí..." style="height: 100px;"></textarea>
</div>
</th>
</tr>

<!-- Sección de agregar comentario -->
<tr>
<th class="text-start no-hover p-3">
<div class="text-end">

<button type="button" class="btn btn-labeled2 btn-success" onclick="GuardarComentario(<?= $IdReporte; ?>,<?= $idEstacion; ?>)">
<span class="btn-label2"><i class="fa-regular fa-comment"></i></span>Guardar Comentario</button>

</div>
</th>
</tr>

</tbody>
</table>
</div>
  