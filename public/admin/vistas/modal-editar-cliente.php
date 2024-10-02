<?php
require('../../../app/help.php');

$idCliente = $_GET['idCliente'];

$sql_reporte = "SELECT * FROM op_cliente WHERE id = '".$idCliente."' ";
   $result_reporte = mysqli_query($con, $sql_reporte);
   $numero_reporte = mysqli_num_rows($result_reporte);
    while($row_reporte = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)){
    	$cuenta = $row_reporte['cuenta'];
    	$cliente = $row_reporte['cliente'];
    	$tipo = $row_reporte['tipo'];
      $rfc = $row_reporte['rfc'];

     
     if($row_reporte['doc_cc'] != ""){
      $CC = '<a class="ms-2" target="_blank" href="../../../../archivos/'.$row_reporte['doc_cc'].'"><img class="float-end pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a>';
     }else{
      $CC = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" class="float-end">';
     }

     if($row_reporte['doc_ac'] != ""){
      $AC = '<a class="ms-2" target="_blank" href="../../../../archivos/'.$row_reporte['doc_ac'].'"><img class="float-end pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a>';
     }else{
      $AC = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" class="float-end">';
     }

     if($row_reporte['doc_cd'] != ""){
      $CD = '<a class="ms-2" target="_blank" href="../../../../archivos/'.$row_reporte['doc_cd'].'"><img class="float-end pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a>';
     }else{
      $CD = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" class="float-end">';
     }

     if($row_reporte['doc_io'] != ""){
      $IO = '<a class="ms-2" target="_blank" href="../../../../archivos/'.$row_reporte['doc_io'].'"><img class="float-end pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a>';
     }else{
      $IO = '<img src="'.RUTA_IMG_ICONOS.'eliminar.png" class="float-end">';
     }
    }
?> 

      <div class="modal-header">
        <h5 class="modal-title" >Editar Cliente</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">  

        <label class="text-secondary mb-1">* Cuenta</label>
        <textarea class="form-control rounded-0" id="EditCuenta"><?=$cuenta;?></textarea>

        <label class="text-secondary mt-2 mb-1">* Cliente</label>
        <textarea class="form-control rounded-0" id="EditCliente"><?=$cliente;?></textarea>

        <label class="text-secondary mt-2 mb-1">* Tipo</label>
        <select class="form-select rounded-0" id="EditTipo">
          <option value="<?=$tipo;?>"><?=$tipo;?></option>
          <option value="Crédito">Crédito</option>
          <option value="Débito">Débito</option>
        </select>

        <?php if($tipo == "Crédito"){
        ?>
        <label class="text-secondary mt-2 mb-1">RFC</label>
        <input type="text" class="form-control rounded-0" value="<?=$rfc;?>" id="EditRFC">


        <div class="row">


    <div class="col-12 mt-3 mb-2">
   

    <div class="border p-3 mb-3">
        
      <label class="mt-2 mb-1">
      <b>Carta de crédito</b>
      </label>

      <?=$CC;?>
  
     <hr>
     <input type="file" class="form-control" id="EditCartaCredito">

    </div>



    <div class="border p-3 mb-3">
        
      <label class="mt-2 mb-1">
      <b>Acta constitutiva</b>
      </label>

     <?=$AC;?>
  
     <hr>
     <input type="file" class="form-control" id="EditActaConstitutiva">

    </div>


    <div class="border p-3 mb-3">
        
      <label class="mt-2 mb-1">
      <b>Comprobante de domicilio</b>
      </label>

     <?=$CD;?>
  
     <hr>
     <input type="file" class="form-control" id="EditComprobanteDom">

    </div>



    <div class="border p-3 mb-3">
        
      <label class="mt-2 mb-1">
      <b>Identificación</b>
      </label>

     <?=$IO;?>
  
     <hr>
     <input type="file" class="form-control" id="EditIdentificacion">

    </div>

    </div> 

    </div>

        <?php
        } ?>
    
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-labeled2 btn-success" onclick="EditarCliente(<?=$idCliente?>)">
      <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
      </div>