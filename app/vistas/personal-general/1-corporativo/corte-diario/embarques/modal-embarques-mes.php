<?php
require('../../../../../help.php');

$IdReporte = $_GET['IdReporte'];
 
?>

 <div class="modal-header">
 <h5 class="modal-title">Agregar embarque</h5>
 <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
 </div>
 
  <div class="modal-body">

<div class="border p-3">
    <div style="font-size: 0.8em"><b>ANEXO IV: EXPEDIENTE DE TRANPORTE PARA LA RECLAMACION DE PRODUCTO</b></div>
    <hr>
    <div class="mt-2" style="font-size: 0.8em"><b>Estación de servicio debe recabar:</b></div>
    <div class="mt-2" style="font-size: 0.8em">De manera enunciativa mas no limitativa, el expediente de transporte de cada entrega deberá contar con al menos los siguientes documentos:</div>

    <div class="mt-2" style="font-size: 0.8em">
    1.  Hoja 1 “Acta de Balance (Estación)”<br>
    2.  Factura final de producto.<br>
    3.  Nota de Embarque de Axfaltec.<br>
    4.  Check List. “LISTA DE VERIFICACIÓN DE LA DESCARGA”<br>
    5.  Tirillas de inventarios (Veeder Root) inicial, final y de aumento.<br>
    6.  Reporte de ventas (de ser el caso de acuerdo al punto 10 de checklist)<br>
    7.  Firmas autógrafas de ambas partes.<br>
    </div>
</div>

    <hr>  
        
        <div class="mb-1 text-secondary">Agregar fecha</div>
        <input type="date" class="form-control" id="Fecha" value="<?=$fecha_del_dia;?>">

        <div class="mt-2 mb-1 text-secondary">Embarque</div>
        <select class="form-select" id="Embarque" onchange="Embarque()">
          <option></option>
          <option>Pemex</option>
          <option>Delivery</option>
          <option>Pick Up</option> 
        </select>
  
         <div class="mt-2 mb-1 text-secondary">Producto</div>
        <select class="form-select" id="Producto">
          <option></option>
          <option>G SUPER</option>
          <option>G PREMIUM</option>
          <option>G DIESEL</option>
        </select>

        <div class="mt-2 mb-1 text-secondary">Agregar documento</div>
        <input class="form-control" type="file" id="Documento">

        <div class="mt-2 mb-1 text-secondary">No. Documento CV</div>
          <input type="text" class="form-control" id="NoDocumento">

          <div class="mt-2 mb-1 text-secondary">Litros Factura</div>
          <input type="number" class="form-control" id="ImporteF" step="any">

          <div class="mt-2 mb-1 text-secondary">Precio por litro</div>
          <input type="number" class="form-control" id="PrecioLitro" step="any">

          <div class="mt-2 mb-1 text-secondary">TAD</div>
          <select class="form-select" id="Tad">
            <option></option>
            <option>906 Tizayuca</option>
            <option>904 Tuxpan</option>
            <option>Pemex</option>
            <option>903 Atlacomulco</option>
            <option>901 Vopack</option>
            <option>908 Monterra</option>
            <option>907 Puebla</option>
          </select>

        <hr> 
 

        <!---------- FACTURAS XML Y PDF ---------->
        <div class="border p-3 mb-2" id="FacturasUP" style="display: none;">
        <div class="text-secondary"><b>Factura</b></div>
        <hr>
        
        <div class=" mb-1 text-secondary">PDF:</div>
        <input class="form-control" type="file" id="PDF">

        <div class="mt-2 mb-1 text-secondary">XML:</div>
        <input class="form-control" type="file" id="XML">
        </div>


        <!---------- COMPROBANTE DE PAGO ---------->
        <div class="border p-3 mb-2" id="ComprobantePagoUp" style="display: none;">
        <div class="text-secondary"><b>Comprobante de pago</b></div>
        <hr>
        <input class="form-control" type="file" id="CoPa">
        </div>

        <!---------- NOTA DE CREDITO ---------->
        <div class="border p-3 mb-2" id="NotaCreditoUp" style="display: none;">
        <div class="text-secondary"><b>Nota de credito</b></div>
        <hr>
        <div class="mb-1 text-secondary">PDF:</div>
        <input class="form-control" type="file" id="NCPDF">

        <div class="mb-1 mt-2 text-secondary">XML:</div>
        <input class="form-control" type="file" id="NCXML">
        </div>


        <!---------- COMPLEMENTO XML Y PDF ---------->
        <div id="ComplementoUp" style="display: none;">
        <div class="border p-3 mb-2">
        <div class="text-secondary"><b>Complemento de pago</b></div>
        <hr>
        
        <div class=" mb-1 text-secondary">PDF:</div>
        <input class="form-control" type="file" id="ComPDF">

        <div class="mt-2 mb-1 text-secondary">XML:</div>
        <input class="form-control" type="file" id="ComXML">
        </div>
        <hr>
        </div>


        <div class="mt-2 mb-1 text-secondary">Chofer</div>
          <input type="text" class="form-control" id="Chofer">

          <div class="mt-2 mb-1 text-secondary">Unidad</div>
          <input type="text" class="form-control" id="Unidad">
       

        <div id="DivMerma" style="display: none;">

           <hr> 
          <div class="mt-2 mb-1 text-secondary">Merma</div>
          <input type="number" class="form-control" id="Merma" step="any">

          <div class="mt-2 mb-1 text-secondary">Nombre del transporte</div>
          <select class="form-select" id="NombreTransporte">
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

      </div>

      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-labeled2 btn-success float-end m-2" onclick="Guardar(<?=$IdReporte;?>)">
          <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar
        </button>
        
      </div>