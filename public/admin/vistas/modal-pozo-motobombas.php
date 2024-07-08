<?php
require('../../../app/help.php');

$idReporte = $_GET['idReporte'];
$sql_lista = "SELECT * FROM op_nivel_explosividad WHERE id = '".$idReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$idEstacion = $row_lista['id_estacion'];	
}

?>

<div class="modal-header">
<h5 class="modal-title">Agregar ubicacion de pozo</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
 </div>


<div class="modal-body">

<div class="row">
	<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mb-2">
		<div>Pozo o Motobomba:</div>
		<select class="form-select mt-1" id="PozoMotobomba">
		<option></option>
		<?php 
		if($idEstacion == 1){
 
		echo '<option>MOTOBOMBA SUPER 1</option>';
		echo '<option>MOTOBOMBA SUPER 2</option>';
		echo '<option>MOTOBOMBA PREMIUM</option>';
		echo '<option>MOTOBOMBA DIESEL</option>';
		echo '<option>POZO DE OBSERVACIÓN 1</option>';
		echo '<option>POZO DE OBSERVACIÓN 2</option>';
		echo '<option>POZO DE OBSERVACIÓN 3</option>';
		echo '<option>POZO DE OBSERVACIÓN 4</option>';
		echo '<option>MANIFUEL</option>';

		}else if($idEstacion == 2){

		echo '<option>MOTOBOMBA SUPER</option>';
		echo '<option>MOTOBOMBA PREMIUM</option>';
		echo '<option>POZO DE OBSERVACIÓN 1</option>';
		echo '<option>POZO DE OBSERVACIÓN 2</option>';
		echo '<option>MANIFUEL</option>';

		}else if($idEstacion == 3){

		echo '<option>POZO DE OBSERVACIÓN 1</option>';
		echo '<option>POZO DE OBSERVACIÓN 2</option>';
		echo '<option>POZO DE OBSERVACIÓN 3</option>';
		echo '<option>POZO DE OBSERVACIÓN 4</option>';
		echo '<option>MOTOBOMBA DIESEL 1</option>';
		echo '<option>MOTOBOMBA DIESEL 2</option>';
		echo '<option>MOTOBOMBA SUPER 3</option>';
		echo '<option>MOTOBOMBA SUPER 4</option>';
		echo '<option>MOTOBOMBA PREMIUM 5</option>';
		echo '<option>MANIFUEL</option>';

		}else if($idEstacion == 4){

		echo '<option>POZO DE OBSERVACIÓN 1</option>';
		echo '<option>POZO DE OBSERVACIÓN 2</option>';
		echo '<option>POZO DE OBSERVACIÓN 3</option>';
		echo '<option>POZO DE OBSERVACIÓN 4</option>';
		echo '<option>POZO DE OBSERVACIÓN 5</option>';
		echo '<option>POZO DE OBSERVACIÓN 6</option>';
		echo '<option>POZO DE OBSERVACIÓN 7</option>';
		echo '<option>POZO DE OBSERVACIÓN 8</option>';
		echo '<option>MOTOBOMBA DIESEL</option>';
		echo '<option>MOTOBOMBA PREMIUM</option>';
		echo '<option>MOTOBOMBA SUPER 1</option>';
		echo '<option>MOTOBOMBA SUPER 2</option>';
		echo '<option>MANIFUEL</option>';

		}else if($idEstacion == 5){

		echo '<option>POZO DE OBSERVACIÓN 1</option>';
		echo '<option>POZO DE OBSERVACIÓN 2</option>';
		echo '<option>POZO DE OBSERVACIÓN 3</option>';
		echo '<option>POZO DE OBSERVACIÓN 4</option>';
		echo '<option>POZO DE OBSERVACIÓN 5</option>';
		echo '<option>POZO DE OBSERVACIÓN 6</option>';
		echo '<option>MOTOBOMBA SUPER 1</option>';
		echo '<option>MOTOBOMBA SUPER 2</option>';
		echo '<option>MOTOBOMBA PREMIUM 3</option>';
		echo '<option>MOTOBOMBA DIESEL 4</option>';
		echo '<option>MANIFUEL</option>';

		}else if($idEstacion == 6){

		echo '<option>POZO DE OBSERVACIÓN 1</option>';
		echo '<option>POZO DE OBSERVACIÓN 2</option>';
		echo '<option>POZO DE OBSERVACIÓN 3</option>';
		echo '<option>MOTOBOMBA TANQUE 1</option>';
		echo '<option>MOTOBOMBA TANQUE 2</option>';
		echo '<option>MOTOBOMBA TANQUE 3</option>';
		echo '<option>MOTOBOMBA TANQUE 4</option>';
		echo '<option>MANIFUEL</option>';

		}else if($idEstacion == 7){

		echo '<option>POZO DE OBSERVACIÓN 1</option>';
		echo '<option>POZO DE OBSERVACIÓN 2</option>';
		echo '<option>POZO DE OBSERVACIÓN 3</option>';
		echo '<option>POZO DE OBSERVACIÓN 4</option>';
		echo '<option>POZO DE OBSERVACIÓN 5</option>';	
		echo '<option>MOTOBOMBA SUPER 1</option>';
		echo '<option>MOTOBOMBA PREMIUM 2</option>';
		echo '<option>MANIFUEL</option>';

		}
		?>
		</select>	
	</div>

	<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2">
		<div>PPM:</div>
		<input type="number" class="form-control mt-1" id="PPM">
	</div>
</div>

<div>Ubicación de Pozo:</div>
<textarea class="form-control mt-1" id="Ubicacion"></textarea>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-danger" data-bs-dismiss="modal">
<span class="btn-label2"><i class="fa-solid fa-xmark"></i></span>Cancelar</button>


<button type="button" class="btn btn-labeled2 btn-success" onclick="GuardarPozo(<?=$idReporte;?>)">
         <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>

</div>
