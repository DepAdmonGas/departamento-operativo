<?php
require '../../../../../help.php';
$id = $_GET['id'];
$IdReporte = $_GET['idReporte'];
$idestacion = $_GET['idestacion'];
$year = $_GET['year'];
$mes = $_GET['mes'];

$sql_lista = "SELECT * FROM op_embarques WHERE id = '" . $id . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {

  $fecha = $row_lista['fecha'];
  $embarque = $row_lista['embarque'];
  $documento = $row_lista['documento'];
  $documentocv = $row_lista['documentocv'];
  $importef = $row_lista['importef'];
  $merma = $row_lista['merma'];
  $nomtransporte = $row_lista['nom_transporte'];

  if ($embarque == "Pemex") {
    $display = 'display: none;';
    $display_m = 'display: none;';

  } else if ($embarque == "Delivery") {
    $display = 'display: none;';
    $display_m = 'display: block;';

  } else if ($embarque == "Pick Up") {
    $display = 'display: block;';
    $display_m = 'display: block;';

  } else {
    $display = 'display: none;';
    $display_m = 'display: none;';

  }

  $producto = $row_lista['producto'];
  $chofer = $row_lista['chofer'];
  $unidad = $row_lista['unidad'];
  $PrecioLitro = $row_lista['precio_litro'];
  $TAD = $row_lista['tad'];

  if ($row_lista['pdf'] != "") {
    $PDF = '<a href="' . RUTA_ARCHIVOS . '' . $row_lista['pdf'] . '" download><img src="' . RUTA_IMG_ICONOS . 'descargar.png' . '"></a>';
  } else {
    $PDF = 'S/I';
  }

  if ($row_lista['xml'] != "") {
    $XML = '<a href="' . RUTA_ARCHIVOS . '' . $row_lista['xml'] . '" download><img src="' . RUTA_IMG_ICONOS . 'descargar.png' . '"></a>';
  } else {
    $XML = 'S/I';
  }

  if ($row_lista['comprobante_p'] != "") {
    $CoPa = '<a href="' . RUTA_ARCHIVOS . '' . $row_lista['comprobante_p'] . '" download><img src="' . RUTA_IMG_ICONOS . 'descargar.png' . '"></a>';
  } else {
    $CoPa = 'S/I';
  }

  if ($row_lista['nc_pdf'] != "") {
    $NCPDF = '<a href="' . RUTA_ARCHIVOS . '' . $row_lista['nc_pdf'] . '" download><img src="' . RUTA_IMG_ICONOS . 'descargar.png' . '"></a>';
  } else {
    $NCPDF = 'S/I';
  }

  if ($row_lista['nc_xml'] != "") {
    $NCXML = '<a href="' . RUTA_ARCHIVOS . '' . $row_lista['nc_xml'] . '" download><img src="' . RUTA_IMG_ICONOS . 'descargar.png' . '"></a>';
  } else {
    $NCXML = 'S/I';
  }

  if ($row_lista['comPDF'] != "") {
    $ComPDF = '<a class="pointer" href="' . RUTA_ARCHIVOS . '' . $row_lista['comPDF'] . '" download><img src="' . RUTA_IMG_ICONOS . 'descargar.png' . '"></a>';
  } else {
    $ComPDF = 'S/I';
  }

  if ($row_lista['comXML'] != "") {
    $ComXML = '<a class="pointer" href="' . RUTA_ARCHIVOS . '' . $row_lista['comXML'] . '" download><img src="' . RUTA_IMG_ICONOS . 'descargar.png' . '"></a>';
  } else {
    $ComXML = 'S/I';
  }


}


?>
<script type="text/javascript">
  $('.selectize').selectize({
    sortField: 'text'
  });
</script>
<script>
  document.querySelector('.clickable-img').addEventListener('click', function () {
    document.getElementById('PDF').click();
  });

  document.querySelector('.clickable-img2').addEventListener('click', function () {
    document.getElementById('XML').click();
  });

  document.querySelector('.clickable-img3').addEventListener('click', function () {
    document.getElementById('CoPa').click();
  });

  document.querySelector('.clickable-img4').addEventListener('click', function () {
    document.getElementById('NCPDF').click();
  });

  document.querySelector('.clickable-img5').addEventListener('click', function () {
    document.getElementById('NCXML').click();
  });

  document.querySelector('.clickable-img6').addEventListener('click', function () {
    document.getElementById('ComPDF').click();
  });

  document.querySelector('.clickable-img7').addEventListener('click', function () {
    document.getElementById('ComXML').click();
  });
</script>

<div class="modal-header">
  <h5 class="modal-title">Editar embarque</h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

  <div class="table-responsive">
    <table class="custom-table" style="font-size: 0.8em" width="100%">
      <thead class="tables-bg">
        <tr>
          <th class="align-middle text-start">ANEXO IV: EXPEDIENTE DE TRANPORTE PARA LA RECLAMACION DE PRODUCTO <br>La
            estación de servicio debe recabar:</th>
        </tr>
      </thead>
      <tbody>
        <tr class="no-hover">
          <th class="align-middle text-start bg-light">
            <ul>
              <li class="mt-2 mb-1">1. Hoja 1 “Acta de Balance (Estación)”</li>
              <li class="mb-1">2. Factura final de producto.</li>
              <li class="mb-1">3. Nota de Embarque de Axfaltec.</li>
              <li class="mb-1">4. Check List. “LISTA DE VERIFICACIÓN DE LA DESCARGA”</li>
              <li class="mb-1">5. Tirillas de inventarios (Veeder Root) inicial, final y de aumento.</li>
              <li class="mb-1">6. Reporte de ventas (de ser el caso de acuerdo al punto 10 de checklist)</li>
              <li>7. Firmas autógrafas de ambas partes.</li>
            </ul>
          </th>
        </tr>
      </tbody>
    </table>
  </div>

  <hr>

  <div class="row">

    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2">
      <div class="mb-1 text-secondary">Fecha</div>
      <input type="date" class="form-control" id="Fecha" value="<?= $fecha; ?>">
    </div>

    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2">
      <div class="mb-1 text-secondary">Embarque</div>
      <select class="form-select" id="Embarque" onchange="Embarque()">
        <?php
        if ($embarque == "") {
          ?>
          <option></option>
          <option>Pemex</option>
          <option>Delivery</option>
          <option>Pick Up</option>
          <?php
        } else {
          ?>

          <option><?= $embarque ?></option>
          <?php
          if ($embarque == "Pemex") {
            echo '<option>Delivery</option>
              <option>Pick Up</option>';

          } else if ($embarque == "Delivery") {
            echo '<option>Pemex</option>
              <option>Pick Up</option>';
          } else if ($embarque == "Pick Up") {
            echo '<option>Pemex</option>
            <option>Delivery</option>';
          }

        }
        ?>
      </select>
    </div>

    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2">
      <div class="mb-1 text-secondary">Producto</div>
      <select class="form-select" id="Producto">
        <option><?= $producto; ?></option>
        <?php
        if ($producto == "G SUPER") {
          echo '<option>G PREMIUM</option>
            <option>G DIESEL</option>';
        } else if ($producto == "G PREMIUM") {
          echo '<option>G SUPER</option>
            <option>G DIESEL</option>';
        } else if ($producto == "G DIESEL") {
          echo '<option>G SUPER</option>
            <option>G PREMIUM</option>';
        } else if ($producto == "") {
          echo '<option>G SUPER</option>
          <option>G PREMIUM</option>
          <option>G DIESEL</option>';
        }
        ?>
      </select>
    </div>

    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
      <div class="mb-1 text-secondary">Agregar documento</div>
      <input class="form-control" type="file" id="Documento">
    </div>

    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
      <div class="mb-1 text-secondary">No. Documento CV</div>
      <input type="text" class="form-control" id="NoDocumento" value="<?= $documentocv; ?>">
    </div>

    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2">
      <div class="mb-1 text-secondary">Litros Factura</div>
      <input type="number" class="form-control" id="ImporteF" step="any" value="<?= $importef; ?>">
    </div>

    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2">
      <div class="mb-1 text-secondary">Precio por litro</div>
      <input type="number" class="form-control" id="PrecioLitro" step="any" value="<?= $PrecioLitro; ?>">
    </div>

    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-2">
      <div class="mb-1 text-secondary">TAD</div>
      <select class="form-select" id="Tad">
        <option><?= $TAD ?></option>
        <option>906 Tizayuca</option>
        <option>904 Tuxpan</option>
        <option>Pemex</option>
        <option>903 Atlacomulco</option>
        <option>901 Vopack</option>
        <option>908 Monterra</option>
        <option>907 Puebla</option>
      </select>
    </div>

  </div>

  <hr>

  <div id="TablaCocumentos" style="<?= $display ?>">
    <div class="table-responsive">
      <table class="custom-table" style="font-size: 12.5px;" width="100%">
        <thead class="tables-bg">
          <tr>
            <th class="align-middle text-center">Descripcion</th>
            <th class="align-middle text-center" colspan="2"><img src="<?= RUTA_IMG_ICONOS; ?>pdf.png"></th>
            <th class="align-middle text-center" colspan="2"><img src="<?= RUTA_IMG_ICONOS; ?>xml.png"></th>
          </tr>
        </thead>
        <tbody>

          <tr class="no-hover">
            <th class="align-middle text-center bg-light">Factura</th>
            <!----- PFD ----->
            <th class="align-middle text-center bg-light" width="60">
              <img src="<?= RUTA_IMG_ICONOS; ?>editar-tb.png" class="clickable-img">
              <input class="form-control" type="file" id="PDF" style="display: none;">
            </th>
            <th class="align-middle text-center bg-light" width="60">
              <?= $PDF ?>
            </th>

            <!----- XML ----->
            <th class="align-middle text-center bg-light" width="60">
              <img src="<?= RUTA_IMG_ICONOS; ?>editar-tb.png" class="clickable-img2">
              <input class="form-control" type="file" id="XML" style="display: none;">
            </th>
            <th class="align-middle text-center bg-light" width="60">
              <?= $XML ?>
            </th>
          </tr>

          <tr class="no-hover">
            <th class="align-middle text-center bg-light">Comprobante de pago</th>
            <!----- PFD ----->
            <th class="align-middle text-center bg-light">
              <img src="<?= RUTA_IMG_ICONOS; ?>editar-tb.png" class="clickable-img3">
              <input class="form-control" type="file" id="CoPa" style="display: none;">
            </th>
            <th class="align-middle text-center bg-light">
              <?= $CoPa ?>
            </th>

            <!----- XML ----->
            <th class="align-middle text-center bg-light" colspan="2">N/A</th>
          </tr>

          <tr class="no-hover">
            <th class="align-middle text-center bg-light">Nota de credito</th>
            <!----- PFD ----->
            <th class="align-middle text-center bg-light">
              <img src="<?= RUTA_IMG_ICONOS; ?>editar-tb.png" class="clickable-img4">
              <input class="form-control" type="file" id="NCPDF" style="display: none;">
            </th>
            <th class="align-middle text-center bg-light">
              <?= $NCPDF ?>
            </th>

            <!----- XML ----->
            <th class="align-middle text-center bg-light">
              <img src="<?= RUTA_IMG_ICONOS; ?>editar-tb.png" class="clickable-img5">
              <input class="form-control" type="file" id="NCXML" style="display: none;">
            </th>
            <th class="align-middle text-center bg-light">
              <?= $NCXML ?>
            </th>
          </tr>

          <tr class="no-hover">
            <th class="align-middle text-center bg-light">Complemento de pago</th>
            <!----- PFD ----->
            <th class="align-middle text-center bg-light">
              <img src="<?= RUTA_IMG_ICONOS; ?>editar-tb.png" class="clickable-img6">
              <input class="form-control" type="file" id="ComPDF" style="display: none;">
            </th>
            <th class="align-middle text-center bg-light">
              <?= $ComPDF ?>
            </th>

            <!----- XML ----->
            <th class="align-middle text-center bg-light">
              <img src="<?= RUTA_IMG_ICONOS; ?>editar-tb.png" class="clickable-img7">
              <input class="form-control" type="file" id="ComXML" style="display: none;">
            </th>
            <th class="align-middle text-center bg-light">
              <?= $ComXML ?>
            </th>
          </tr>

        </tbody>
      </table>
    </div>

    <hr>
  </div>

  <div class="row">
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
      <div class="mb-1 text-secondary">Chofer</div>
      <!--<input type="text" class="form-control" id="Chofer" value="<?= $chofer; ?>">-->
      <select class="selectize pointer" placeholder="Transporte" id="Chofer">
        <option><?=$chofer?></option>
        <?php
          $sql_unidades = "SELECT nombre_chofer FROM tb_pivoteo_chofer WHERE estado = 0 ORDER BY id ASC";
          $result_unidades = mysqli_query($con, $sql_unidades);

          while ($row_unidades = mysqli_fetch_array($result_unidades, MYSQLI_ASSOC)) {
            $chofer = $row_unidades['nombre_chofer'];
            echo '<option>' . $chofer . '</option>';
          }
        ?>
      </select>
      
    </div>

    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
      <div class="mb-1 text-secondary">Unidad</div>
      <!--<input type="text" class="form-control" id="Unidad" value="<?= $unidad; ?>">--> 
      <select class="selectize pointer" placeholder="Transporte" id="Unidad">
        <option><?=$unidad?></option>
        <?php
          $sql_unidades = "SELECT no_unidad FROM tb_unidades_transporte WHERE estado = 0 ORDER BY id ASC";
          $result_unidades = mysqli_query($con, $sql_unidades);

          while ($row_unidades = mysqli_fetch_array($result_unidades, MYSQLI_ASSOC)) {
            $unidad = $row_unidades['no_unidad'];
            echo '<option>' . $unidad . '</option>';
          }
        ?>
      </select>
    </div>


    <div id="DivMerma" style="<?= $display_m; ?>">
      <hr>
      <div class="row">

        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
          <div class="mb-1 text-secondary">Merma</div>
          <input type="number" class="form-control" id="Merma" step="any" value="<?= $merma; ?>">
        </div>

        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-2">
          <div class="mb-1 text-secondary">Nombre del transporte</div>
          <select class="form-select" id="NombreTransporte">
            <option>
              <?= $nomtransporte; ?>
            </option>
            <?php
            $sql_unidades = "SELECT nombre_transporte FROM tb_lista_transportes WHERE estado = 0 ORDER BY nombre_transporte ASC";
            $result_unidades = mysqli_query($con, $sql_unidades);
            $numero_unidades = mysqli_num_rows($result_unidades);

            while ($row_unidades = mysqli_fetch_array($result_unidades, MYSQLI_ASSOC)) {
              $nombre_transporte = $row_unidades['nombre_transporte'];
              echo '<option>' . $nombre_transporte . '</option>';
            }

            ?>

          </select>
        </div>
      </div>

    </div>
  </div>

</div>

<div class="modal-footer">
  <button type="button" class="btn btn-labeled2 btn-success float-end"
    onclick="EditarE(<?= $IdReporte; ?>,<?= $id; ?>,<?= $idestacion; ?>,<?= $year; ?>,<?= $mes; ?>)">
    <span class="btn-label2"><i class="fa fa-check"></i></span>Editar</button>
</div>