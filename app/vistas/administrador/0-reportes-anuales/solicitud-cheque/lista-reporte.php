<?php
require '../../../../help.php';

if (isset($_GET["Year"])):
  ?>

  <div class="row">
    <div class="col-12">
      <div class="alert alert-primary text-start" role="alert">
        Reportes del año <?= $_GET["Year"] ?></div>
    </div>
  </div>
  <?php
  $sql_lista = "SELECT SUM(monto) AS total_monto FROM op_solicitud_cheque WHERE id_year = '" . $_GET["Year"] . "' AND id_estacion = 1 AND status != 0";
  $result_lista = mysqli_query($con, $sql_lista);
  
  if ($result_lista) {

      $row_lista = mysqli_fetch_assoc($result_lista);
      
      $total_monto = $row_lista['total_monto'];
  }
  $corteDiario = 100;
  ?>
  <div class="row ">

    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">

      <div class="table-responsive">
        <table class="custom-table" style="font-size: 12.5px;" width="100%">
          <thead class="tables-bg">
            <th class="align-middle text-center p-1" colspan="2">
              SOLICITUD CHEQUE RESUMEN
            </th>
          </thead>
          <tbody class="bg-white">
            <tr>
              <th class="align-middle text-center">
                Monto total Anual
              </th>
              <th>
                <?=$total_monto?>
              </th>
            </tr>
            <tr class="no-hover">
              <th class="align-middle text-center p-2 bg-primary text-white" onclick="Editar(' . $idReporte . ')">
                <i class="fa-solid fa-pencil"></i> PDF
              </th>

              <th class="align-middle text-center p-2 bg-success text-white" onclick="Eliminar(' . $idReporte . ')">
                <i class="fa-regular fa-trash-can"></i> Excel
              </th>
            </tr>

          </tbody>
        </table>
      </div>

    </div>
    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">

      <div class="table-responsive">
        <table class="custom-table" style="font-size: 12.5px;" width="100%">
          <thead class="tables-bg">
            <th class="align-middle text-center p-1" colspan="2">
              CORTE DIARIO RESUMEN
            </th>
          </thead>
          <tbody class="bg-white">
            <tr>
              <th class="align-middle text-center">
                Monto total Anual
              </th>
              <th>
                <?=$corteDiario?>
              </th>
            </tr>
            <tr class="no-hover">
              <th class="align-middle text-center p-2 bg-primary text-white" onclick="Editar(' . $idReporte . ')">
                <i class="fa-solid fa-pencil"></i> PDF
              </th>

              <th class="align-middle text-center p-2 bg-success text-white" onclick="Eliminar(' . $idReporte . ')">
                <i class="fa-regular fa-trash-can"></i> Excel
              </th>
            </tr>

          </tbody>
        </table>
      </div>

    </div>
  </div>
  <?php
else: ?>

  <header class="bg-light py-5">
    <div class="container px-5">
      <div class="row gx-5 align-items-center justify-content-center">

        <div class="col-xl-5 col-xxl-6 d-xl-block text-center">
          <img class="my-2" style="width: 100%" src="<?= RUTA_IMG_ICONOS ?>no-busqueda.png" width="50%">
        </div>

        <div class="col-lg-8 col-xl-7 col-xxl-6">
          <div class="my-2 text-center">
            <h1 class="display-3 fw-bolder text-dark">No se encontró la información <br> del año <?= date('Y') ?></h1>
          </div>
        </div>

      </div>
    </div>
  </header>

<?php endif; ?>