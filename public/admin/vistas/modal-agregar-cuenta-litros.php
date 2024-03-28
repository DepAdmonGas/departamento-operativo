  <?php
require('../../../app/help.php');
$idCuentaLitros = $_GET['idCuentaLitros'];

?>  

    <div class="modal-header">
    <h5 class="modal-title">Agregar Cuenta Litros</h5>  
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
 
 
    <div class="modal-body">
 	
 	<div class="mb-1 text-secondary">*Hora:</div>
    <input class="form-control" type="time" id="horaCL">

    <div class="mt-2 mb-1 text-secondary">*Embarque</div>
    <select class="form-select" id="embarqueCL" onchange="Embarque()">
          <option></option>
          <option>Pemex</option>
          <option>Delivery</option>
          <option>Pick Up</option> 
    </select>
 
  
 <div id="DivTransporte" style="display: none;">
    <div class="mt-2 mb-1 text-secondary">*Nombre del transporte</div>
    <select class="form-select" id="transporteCL">

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
   
   
    <div class="mb-1 mt-2 text-secondary">*Tanque:</div>
    <input class="form-control" type="number" id="tanqueCL">


    <div class="mb-1 mt-2 text-secondary">*Producto:</div>
    <select class="form-select" id="productoCL">
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


    <div class="mb-1 mt-2 text-secondary">*TAD:</div>
    <select class="form-select" id="tadCL">
    <option></option>
    <option>Atlacomulco</option>
    <option>Tizayuca</option>
    <option>Tuxpan</option>
    <option>Puebla</option>
    <option>Vopack</option>
		<option>Monterra</option>
    </select>


    <div class="mb-1 mt-2 text-secondary">*Unidad:</div>
    <select class="form-select" id="unidadCL">
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

  
    <div class="mb-1 mt-2 text-secondary">*Factura:</div>
    <input class="form-control" type="number" id="facturaCL">

    <div class="mb-1 mt-2 text-secondary">*Tirilla de Descarga Neto:</div>
    <input class="form-control" type="number" id="descargaNetoCL">

    <div class="mb-1 mt-2 text-secondary">*Tirilla de Descarga Bruto:</div>
    <input class="form-control" type="number" id="descargaBrutoCL">

    <div class="mb-1 mt-2 text-secondary">*Cuenta Litros a 20° C:</div>
    <input class="form-control" type="number" id="descargaGradosCL">

    <div class="mb-1 mt-2 text-secondary">*Venta al momento:</div>
    <input class="form-control" type="number" id="ventaCL">

    <div class="mb-1 mt-2 text-secondary">*Folio de merma:</div>
    <input class="form-control" type="number" id="mermaCL">

    <div class="mb-1 mt-2 text-secondary">*Imagen:</div>
    <input class="form-control" type="file" id="imagenCL">


    <div class="mb-1 mt-2 text-secondary">Comentarios:</div>
    <textarea class="form-control" id="comentariosCL"></textarea>


	</div>


    <div class="modal-footer">
    <button type="button" class="btn btn-primary rounded-0" onclick="agregarCL(<?=$idCuentaLitros?>)">Guardar</button>
    </div>