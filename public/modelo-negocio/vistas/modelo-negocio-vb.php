<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];

function ValidaUsuario($idReporte,$idUsuario,$con){
$sql = "SELECT * FROM op_modelo_negocio_firma WHERE id_modelo_negocio = '".$idReporte."' AND id_usuario= '".$idUsuario."' ";
$result = mysqli_query($con, $sql); 
$numero = mysqli_num_rows($result);
return $numero;
}

function Responsable($id, $con){

$sql_resp = "SELECT * FROM tb_usuarios WHERE id = '".$id."'  ";
         $result_resp = mysqli_query($con, $sql_resp);
         $numero_resp = mysqli_num_rows($result_resp);
         while($row_resp = mysqli_fetch_array($result_resp, MYSQLI_ASSOC)){
          $Usuario = $row_resp['nombre'];
          
         }
         return $Usuario;
}

$ValidaUsuario = ValidaUsuario($idReporte,$Session_IDUsuarioBD,$con);


$sql_comen = "SELECT * FROM op_modelo_negocio_comentario WHERE id_modelo_negocio = '".$idReporte."' ORDER BY id DESC ";
$result_comen = mysqli_query($con, $sql_comen);
$numero_comen = mysqli_num_rows($result_comen);
?>

<div class="border p-3">
<h5>Comentarios</h5>
<hr>

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

<div style="font-size: .8em;" class="mb-1"><b><?=$NomUsuario;?></b></div>
<div class="bg-primary text-white" style="border-radius: 30px;">
<p class="p-3 pb-2"><?=$comentario;?></p>
</div>

<div class="text-end" style="font-size: .8em;margin-top: -10px"><?=$FechaFormato;?>, <?=$HoraFormato;?></div>

</div>
<?php
}
}else{
echo "<div class='text-center' style='margin-top: 150px;'><small>No se encontraron comentarios</small></div>";
}
?>
</div>

<div class="mb-2 text-secondary mt-2"><small>Comentario:</small></div>
<textarea class="form-control rounded-0" id="Comentario"></textarea>

<div class="text-end mt-3">
<button type="button" class="btn btn-info text-white" onclick="GuardarComentario(<?=$idReporte;?>)">Guardar</button>
</div>
</div> 

<div class="border p-3 mt-3">
<h5>VoBo para el modelo de negocio</h5>
<hr>
<?php
$sql = "SELECT * FROM op_modelo_negocio_firma WHERE id_modelo_negocio = '".$idReporte."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
echo '<span class="badge bg-success p-2 mr-3 mb-2" style="font-size: .9em;">'.Responsable($row['id_usuario'],$con).'</span>';
}

if($ValidaUsuario == 0){ ?>

<div class="row">
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12"> 
<div class="border p-3">
<div class="mb-2 text-secondary text-center">FIRMA DE VOBO</div>
<hr>
<h4 class="text-primary text-center">Token Móvil</h4>
<small class="text-secondary">Agregue el token enviado a su número de teléfono o de clic en el siguiente botón para crear uno</small>
<button class="btn btn-sm mb-2 bg-light" onclick="CrearToken(<?=$idReporte;?>)"><small>Crear token</small></button>
<button class="btn btn-sm mb-2 bg-light" onclick="CrearTokenEmail(<?=$idReporte;?>)"><small>Crear token vía email</small></button>
<hr>
<div class="input-group mt-3">
<input type="text" class="form-control" placeholder="Token de seguridad" aria-label="Token de seguridad" aria-describedby="basic-addon2" id="TokenValidacion">
<div class="input-group-append">
<button class="btn btn-outline-secondary" type="button" onclick="Firmar(<?=$idReporte;?>)">Firmar solicitud</button>
</div>
</div>
</div>
</div>
</div>

<?php } ?>


</div> 