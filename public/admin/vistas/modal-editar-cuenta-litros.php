  <?php
require('../../../app/help.php');
$idDetalle = $_GET['idDetalle'];

	$sql_lista = "SELECT * FROM op_cuenta_litros_detalle WHERE id_detalle = '".$idDetalle."' ";

	$result_lista = mysqli_query($con, $sql_lista);
	$numero_lista = mysqli_num_rows($result_lista); 

	while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

	$id_cuenta_litros = $row_lista['id_cuenta_litros'];
	$hora = $row_lista['hora'];
	$embarque = $row_lista['embarque'];
	$transporte = $row_lista['transporte'];
	$tanque = $row_lista['tanque'];
	$producto = $row_lista['producto'];

	$litros = $row_lista['litros'];
	$descarga_neto = $row_lista['descarga_neto'];
	$descarga_bruto = $row_lista['descarga_bruto'];
	$litros_c = $row_lista['litros_c'];
	$archivo = $row_lista['archivo'];
	$comentario = $row_lista['comentario'];
	$tad = $row_lista['tad'];
	$unidad = $row_lista['unidad'];
	$venta = $row_lista['venta_momento'];
	$merma = $row_lista['folio_merma'];

	if($embarque == "Pemex"){
	$displayV = 'style="display: none;"';
	}else if($embarque == "Delivery"){
	$displayV = 'style="display: block;"';
	}else if($embarque == "Pick Up"){
	$displayV = 'style="display: block;"';
	}else{
	$displayV = 'style="display: none;"';
	}

	}


	if($comentario == "Sin comentarios."){
	$comentarioText = "";	
	}else{
	$comentarioText = $comentario;
	}

	?>
 <script type="text/javascript">
  $('.selectize').selectize({
    sortField: 'text'
});
</script>
    <div class="modal-header">
    <h5 class="modal-title">Editar Cuenta Litros</h5>  
	<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

 
    <div class="modal-body">
 	
 	<div class="mb-1 text-secondary fw-bold">* HORA:</div>
    <input class="form-control rounded-0" type="time" id="horaCL" value="<?=$hora?>">

        <div class="mt-2 mb-1 text-secondary fw-bold">* EMBARQUE:</div>
    <select class="form-select rounded-0" id="embarqueCL" onchange="Embarque()">
          <option><?=$embarque?></option>
          <option>Pemex</option>
          <option>Delivery</option>
          <option>Pick Up</option> 
    </select>
 

 <div id="DivTransporte" <?=$displayV?>>
    <div class="mt-2 mb-1 text-secondary fw-bold">* NOMBRE DEL TRANSPORTE:</div>
    <select class="selectize pointer rounded-0" id="transporteCL">
          <option><?=$transporte?></option>
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
    <input class="form-control rounded-0" type="number" id="tanqueCL" value="<?=$tanque?>">


    <div class="mb-1 mt-2 text-secondary fw-bold">* PRODUCTO:</div>
    <select class="form-select rounded-0" id="productoCL">
	<option><?=$producto?></option>
 
	<?php

	$sql_lista2 = "SELECT 
	tb_estaciones.producto_uno,
	tb_estaciones.producto_dos,
	tb_estaciones.producto_tres
	   
	FROM op_cuenta_litros 
	INNER JOIN tb_estaciones ON op_cuenta_litros.id_estacion = tb_estaciones.id
	INNER JOIN op_cuenta_litros_detalle ON op_cuenta_litros.id_cuenta_litros = op_cuenta_litros_detalle.id_cuenta_litros

	WHERE op_cuenta_litros_detalle.id_detalle = '".$idDetalle."' ";
	
	$result_lista2 = mysqli_query($con, $sql_lista2);
	$numero_lista2 = mysqli_num_rows($result_lista2); 

	while($row_lista2 = mysqli_fetch_array($result_lista2, MYSQLI_ASSOC)){
	$productouno = $row_lista2['producto_uno'];
	$productodos = $row_lista2['producto_dos'];
	$productotres = $row_lista2['producto_tres'];

	if($productouno == $producto){
	$ocultarS = "d-none";
	}else{
	$ocultarS = "";
	}

	if($productodos == $producto){
	$ocultarP = "d-none";
	}else{
	$ocultarP = "";
	}


	if($productotres == "" || $productotres == $producto){
	$ocultarD = "d-none";
	}else{
	$ocultarD = "";
	}


	}

	?>

 
	<option class="<?=$ocultarS?>"><?=$productouno?></option>
	<option class="<?=$ocultarP?>"><?=$productodos?></option>
	<option class="<?=$ocultarD?>"><?=$productotres?></option>
	</select>


	  <div class="mb-1 mt-2 text-secondary fw-bold">* TAD:</div>
    <select class="form-select rounded-0" id="tadCL">
    <option><?=$tad?></option>
    <option>Atlacomulco</option>
    <option>Tizayuca</option>
    <option>Tuxpan</option>
    <option>Puebla</option>
    <option>Vopack</option>
		<option>Monterra</option>
    </select>

 
    <div class="mb-1 mt-2 text-secondary fw-bold">* UNIDAD:</div>
    <select class="selectize pointer rounded-0" id="unidadCL">
    <option><?=$unidad?></option>
   
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
 

    <div class="mb-1 mt-2 text-secondary fw-bold">* FACTURA:</div>
    <input class="form-control rounded-0" type="number" id="facturaCL" value="<?=$litros?>">

    <div class="mb-1 mt-2 text-secondary fw-bold">* TIRILLA DE DESCARGA NETO:</div>
    <input class="form-control rounded-0" type="number" id="descargaNetoCL" value="<?=$descarga_neto?>">

    <div class="mb-1 mt-2 text-secondary fw-bold">* TIRILLA DE DESCARGA BRUTO:</div>
    <input class="form-control rounded-0" type="number" id="descargaBrutoCL" value="<?=$descarga_bruto?>">

    <div class="mb-1 mt-2 text-secondary fw-bold">* CUENTA LITROS A 20° C:</div>
    <input class="form-control rounded-0" type="number" id="descargaGradosCL" value="<?=$litros_c?>">

      <div class="mb-1 mt-2 text-secondary fw-bold">* VENTA AL MOMENTO:</div>
    <input class="form-control rounded-0" type="number" id="ventaCL" value="<?=$venta?>">

    <div class="mb-1 mt-2 text-secondary fw-bold">* FOLIO DE MERMA:</div>
    <input class="form-control rounded-0" type="number" id="mermaCL" value="<?=$merma?>">

    <div class="mb-1 mt-2 text-secondary fw-bold">* IMAGEN:</div>
    <input class="form-control rounded-0" type="file" id="imagenCL">

    <div class="mb-1 mt-2 text-secondary">COMENTARIOS:</div>
    <textarea class="form-control rounded-0" id="comentariosCL"><?=$comentarioText?></textarea>

	</div>


    <div class="modal-footer">   
    <button type="button" class="btn btn-labeled2 btn-success" onclick="editarCL(<?=$idDetalle?>,<?=$id_cuenta_litros?>)">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
	
</div>