 <?php
require('../../../app/help.php');
$idLicitacion = $_GET['idLicitacion'];

$sql = "SELECT * FROM op_licitacion_municipal WHERE id = '".$idLicitacion."' ";  
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$idYear = $row['year'];
$fecha = $row['fecha'];
$nombre_formato = $row['nombre_formato'];
$archivo = $row['archivo'];
}

?>

<div class="modal-header">
<h5 class="modal-title">Editar Licitación Municipal</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">
	
<div class="row">

<div class="col-12 mb-2"> 
<div class="mb-1 text-secondary">Fecha:</div>
<input type="date" class="form-control rounded-0" id="fechaLicitacion" value="<?=$fecha?>">  
</div>

<div class="col-12 mb-2"> 
<div class="mb-1 text-secondary">Nombre del formato:</div>
<input type="text" class="form-control rounded-0" id="nombreFormato" value="<?=$nombre_formato?>">    
</div>

<div class="col-12"> 
<div class="mb-1 text-secondary">Documento:</div>
<input class="form-control" type="file" id="archivoLicitacion">
</div>

</div>

</div>
    
  
  <div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
  <button type="button" class="btn btn-success" onclick="editarLicitacion(<?=$idYear?>,<?=$idLicitacion?>)">Editar</button>
  </div> 