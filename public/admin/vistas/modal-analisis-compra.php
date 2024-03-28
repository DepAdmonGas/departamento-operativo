<?php
require('../../../app/help.php');


$Year = $_GET['year'];
$Mes = $_GET['mes'];

$sql_listaestacion = "SELECT id, nombre FROM tb_estaciones WHERE numlista <= 8 ORDER BY numlista ASC";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
?>


<div class="modal-header">
<h5 class="modal-title">Buscar</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>

<div class="modal-body">

<div class="mt-3 text-secondary">TAD</div>
          <select class="form-control" id="BTad">
            <option></option>
            <option>906 Tizayuca</option>
            <option>904 Tuxpan</option>
            <option>Pemex</option>
            <option>903 Atlacomulco</option>
            <option>901 Vopack</option>
          </select>

<div class="mt-3 text-secondary">Estación:</div>
<select class="form-control" id="BEstacion">
<option></option>
<?php 
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
echo '<option value="'.$row_listaestacion['id'].'">'.$row_listaestacion['nombre'].'</option>';
}
?>
</select>

<div class="mt-3 text-secondary">Producto:</div>
<select class="form-control" id="BProducto">
<option></option>
<option value="G SUPER">87 Oct</option>
<option value="G PREMIUM">91 Oct</option>
<option value="G DIESEL">DIESEL</option>
</select>


          <div class="mt-3 text-secondary">Transporte</div>
          <select class="form-control" id="BTransporte">
            <option></option>
            <option>RODRIGO ZORRILLA PONCE DE LEON</option>
            <option>PETRO ASFALTOS DEL SURESTE, S.A. DE C.V.</option>
            <option>TRANSPORTES SANTA FE DEL SURESTE, S.A. DE C.V.</option>
            <option>TRANSPORTES ESPECIALIZADOS SANTANA GONZALES SA DE CV</option>
          </select>


          <div class="mt-3 text-secondary">Unidad</div>
          <select class="form-control" id="BUnidad">
            <option></option>
            <option>PAS-547</option>
            <option>PAS-573</option>
            <option>PAS-569</option>
            <option>PAS-541</option>
            <option>PAS-545</option>
            <option>PAS-575</option>
            <option>TSF-1141</option>
            <option>TSF-1142</option>
            <option>TSF-1156</option>
            <option>SG01</option>
            <option>SG02</option>
            <option>SG03</option>
            </select>

		<div class="mt-3 text-secondary">Status:</div>
		<select class="form-control" id="BStatus">
		<option></option>
		<option value="Pendiente">Pendiente</option>
		<option value="Pagada">Pagada</option>
		</select>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="Buscar(<?=$Year?>,<?=$Mes?>)">Guardar</button>
      </div>

</div>
