<?php
require('../../../app/help.php');

function Estacion($idEstacion,$con){
$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}
return $estacion;
}

function Responsable($idUsuario,$con){
$sql_usuario = "SELECT nombre_completo FROM op_rh_personal WHERE id = '".$idUsuario."' ";
$result_usuario = mysqli_query($con, $sql_usuario);
while($row_usuario = mysqli_fetch_array($result_usuario, MYSQLI_ASSOC)){
$usuario = $row_usuario['nombre_completo'];
}
return $usuario;
}

function Comodin($idUsuario,$con){
$sql_usuario = "SELECT nombre FROM tb_usuarios WHERE id = '".$idUsuario."' ";
$result_usuario = mysqli_query($con, $sql_usuario);
while($row_usuario = mysqli_fetch_array($result_usuario, MYSQLI_ASSOC)){
$usuario = $row_usuario['nombre'];
}
return $usuario;
}

$idPermiso = $_GET['idPermiso'];
$Tipo = $_GET['Tipo'];
$idEstacion = $_GET['idEstacion']; 

if($Tipo == 1){
$Titulo = "Crear permiso";
}else{
$Titulo = "Editar permiso";
}

$sql_lista = "SELECT * FROM op_rh_permisos WHERE id = '".$idPermiso."' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$idestacion = $row_lista['id_estacion'];
$idpersonal = $row_lista['id_personal'];
$Estacion = Estacion($idestacion,$con);
$Responsable = Responsable($idpersonal,$con);
$diastomados = $row_lista['dias_tomados'];
$observaciones = $row_lista['observaciones'];

$FechaInicio = $row_lista['fecha_inicio'];
$FechaTermino = $row_lista['fecha_termino'];
$Motivo = $row_lista['motivo'];

$idComodin = $row_lista['cubre_turno'];
$Comodin = Comodin($idComodin,$con);
}

?>
<div class="modal-header">
<h5 class="modal-title"><?=$Titulo;?></h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">


<label class="text-secondary mt-2">* Colaborador</label>

<?php 
 $sql_listaestacion = "SELECT id, nombre_completo FROM op_rh_personal WHERE id_estacion = '".$idEstacion."' AND estado = 1 ORDER BY nombre_completo ASC";
  $result_listaestacion = mysqli_query($con, $sql_listaestacion);

  echo '<select class="form-control titulos" id="Colaborador">';
  echo '<option value="'.$idpersonal.'">'.$Responsable.'</option>';

  while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
  $id = $row_listaestacion['id'];
  $estacion = $row_listaestacion['nombre_completo']; 
  echo '<option value="'.$id.'">'.$estacion.'</option>';
  }
  echo '</select>';

?>


<label class="text-secondary mt-2">* Del</label>
<input type="date" class="form-control" id="FechaInicio" value="<?=$FechaInicio;?>">

<label class="text-secondary mt-2">* Hasta</label>
<input type="date" class="form-control" id="FechaTermino" value="<?=$FechaTermino;?>">

<label class="text-secondary mt-2">* Días tomados</label>
<input type="text" class="form-control" id="DiasTomados" value="<?=$diastomados;?>">

<label class="text-secondary mt-2">* Quien cubre</label>
<?php 
 $sql = "SELECT id, nombre FROM tb_usuarios WHERE id_gas = 8 AND id_puesto = 6 AND estatus = 0 ORDER BY nombre ASC";
  $result = mysqli_query($con, $sql);

  echo '<select class="form-control titulos" id="Cubre">';
  echo '<option value="'.$idComodin.'">'.$Comodin.'</option>';

  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
  $idComodin = $row['id'];
  $Comodin = $row['nombre']; 
  echo '<option value="'.$idComodin.'">'.$Comodin.'</option>';
  }
  echo '</select>';

?>

<label class="text-secondary mt-2">* Motivo</label>
<textarea class="form-control titulos" id="Motivo"><?=$Motivo;?></textarea>

<label class="text-secondary mt-2">* Observaciones</label>
<textarea class="form-control titulos" id="Observacion"><?=$observaciones;?></textarea>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-primary" onclick="Crear(<?=$idPermiso;?>,<?=$Tipo;?>,<?=$idEstacion;?>)"><?=$Titulo;?></button>
</div>

