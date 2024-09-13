  <?php
require('../../../app/help.php');
$idCuentaLitros = $_GET['idCuentaLitros'];

?>  
<script type="text/javascript">
  $('.selectize').selectize({
    sortField: 'text'
});
</script>
    <div class="modal-header">
    <h5 class="modal-title">Agregar Cuenta Litros</h5>  
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
 
 
    <div class="modal-body">
 	
 	<div class="mb-1 text-secondary fw-bold">* HORA:</div>
    <input class="form-control rounded-0" type="time" id="horaCL">

    <div class="mt-2 mb-1 text-secondary fw-bold">* EMBARQUE:</div>
    <select class="form-select rounded-0" id="embarqueCL" onchange="Embarque()">
          <option></option>
          <option>Pemex</option>
          <option>Delivery</option>
          <option>Pick Up</option> 
    </select>
 
  
 <div id="DivTransporte" style="display: none;">
    <div class="mt-2 mb-1 text-secondary fw-bold">* NOMBRE DEL TRANSPORTE:</div>
    <select class="selectize pointer rounded-0" id="transporteCL">

    <option></option>
    <?php
    $sql_unidades = "SELECT nombre_transporte FROM tb_lista_transportes WHERE estado = 0 ORDER BY nombre_transporte ASC";
    $result_unidades = mysqli_query($con, $sql_unidades);
    $numero_unidades = mysqli_num_rows($result_unidades); 

    while($row_unidades = mysqli_fetch_array($result_unidades, MYSQLI_ASSOC)){
    $nombre_transporte = $row_unidades['nombre_transporte'];

    echo '<option>'.$nombre_transporte.'</option>';
    
    }

    ?>

    </select>
  </div>
   
   
    <div class="mb-1 mt-2 text-secondary fw-bold">* TANQUE:</div>
    <input class="form-control rounded-0" type="number" id="tanqueCL">


    <div class="mb-1 mt-2 text-secondary fw-bold">* PRODUCTO:</div>
    <select class="form-select rounded-0" id="productoCL">
	<option></option>
	<?php
 
	$sql_lista = "SELECT 
	tb_estaciones.producto_uno,
	tb_estaciones.producto_dos,
	tb_estaciones.producto_tres

	FROM op_cuenta_litros 
	INNER JOIN tb_estaciones ON op_cuenta_litros.id_estacion = tb_estaciones.id
	WHERE op_cuenta_litros.id_cuenta_litros = '".$idCuentaLitros."' ";

	$result_lista = mysqli_query($con, $sql_lista);
	$numero_lista = mysqli_num_rows($result_lista); 

	while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
	$productouno = $row_lista['producto_uno'];
	$productodos = $row_lista['producto_dos'];
	$productotres = $row_lista['producto_tres'];

	if($productotres == ""){
		$ocultarS = "d-none";
	}else{
		$ocultarS = "";
	}

	}  
	?>
 
	<option><?=$productouno?></option>
	<option><?=$productodos?></option>
	<option class="<?=$ocultarS?>"><?=$productotres?></option>
	</select>


    <div class="mb-1 mt-2 text-secondary fw-bold">* TAD:</div>
    <select class="form-select rounded-0" id="tadCL">
    <option></option>
    <option>Atlacomulco</option>
    <option>Tizayuca</option>
    <option>Tuxpan</option>
    <option>Puebla</option>
    <option>Vopack</option>
		<option>Monterra</option>
    </select>


    <div class="mb-1 mt-2 text-secondary fw-bold">* UNIDAD:</div>
    <div id="contenido-unidad">
    <select class="selectize pointer rounded-0" id="unidadCL">
    <option></option>
    <?php
    $sql_unidades = "SELECT no_unidad FROM tb_unidades_transporte WHERE estado = 0 ORDER BY no_unidad ASC";
    $result_unidades = mysqli_query($con, $sql_unidades);
    $numero_unidades = mysqli_num_rows($result_unidades); 
    while($row_unidades = mysqli_fetch_array($result_unidades, MYSQLI_ASSOC)){
    $no_unidad = $row_unidades['no_unidad'];
    echo '<option>'.$no_unidad.'</option>';
    }
    ?>
    </select>
    </div>

  
    <div class="mb-1 mt-2 text-secondary fw-bold">* FACTURA:</div>
    <input class="form-control rounded-0" type="number" id="facturaCL">

    <div class="mb-1 mt-2 text-secondary fw-bold">* TIRILLA DE DESCARGA NETO:</div>
    <input class="form-control rounded-0" type="number" id="descargaNetoCL">

    <div class="mb-1 mt-2 text-secondary fw-bold">* TIRILLA DE DESCARGA BRUTO:</div>
    <input class="form-control rounded-0" type="number" id="descargaBrutoCL">

    <div class="mb-1 mt-2 text-secondary fw-bold">* CUENTA LITROS A 20° C:</div>
    <input class="form-control rounded-0" type="number" id="descargaGradosCL">

    <div class="mb-1 mt-2 text-secondary fw-bold">* VENTA AL MOMENTO:</div>
    <input class="form-control rounded-0" type="number" id="ventaCL">

    <div class="mb-1 mt-2 text-secondary fw-bold">* FOLIO DE MERMA:</div>
    <input class="form-control rounded-0" type="number" id="mermaCL">

    <div class="mb-1 mt-2 text-secondary fw-bold">* IMAGEN:</div>
    <input class="form-control rounded-0" type="file" id="imagenCL">


    <div class="mb-1 mt-2 text-secondary">COMENTARIOS:</div>
    <textarea class="form-control rounded-0" id="comentariosCL"></textarea>


	</div>


    <div class="modal-footer">
    <button type="button" class="btn btn-labeled2 btn-success" onclick="agregarCL(<?=$idCuentaLitros?>)">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
    </div>