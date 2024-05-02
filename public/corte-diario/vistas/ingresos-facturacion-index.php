<?php
require 'app/vistas/contenido/header.php';
?>
<script type="text/javascript">
  function IngresosFacturacion(year) {
    window.location.href = "ingresos-facturacion/" + year;
  }
</script>

<body>
  <div class="LoaderPage"></div>
  <!---------- DIV - CONTENIDO ---------->
  <div id="content">
    <!---------- NAV BAR - PRINCIPAL (TOP) ---------->
    <?php include_once "public/navbar/navbar-perfil.php"; ?>
    <!---------- CONTENIDO PAGINA WEB---------->
    <div class="contendAG">
      <div class="row">

        <div class="col-12 mb-3">
          <div class="cardAG">
            <div class="border-0 p-3">

              <div class="row">
                <div class="col-12">

                  <img class="float-start pointer" src="<?= RUTA_IMG_ICONOS; ?>regresar.png" onclick="history.back()">

                  <div class="row">
                    <div class="col-12">
                      <h5>Ingresos VS Facturación</h5>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <?php
              ValidaYearReporte($Session_IDEstacion, $fecha_year, $con);
              function ValidaYearReporte($Session_IDEstacion, $fecha_year, $con)
              {

                $sql_reporte = "SELECT id_estacion, year FROM op_corte_year WHERE id_estacion = '" . $Session_IDEstacion . "' AND year = '" . $fecha_year . "' ";
                $result_reporte = mysqli_query($con, $sql_reporte);
                $numero_reporte = mysqli_num_rows($result_reporte);

                if ($numero_reporte == 0) {
                  $sql_insert = "INSERT INTO op_corte_year (
    id_estacion,
    year
    )
    VALUES 
    (
    '" . $Session_IDEstacion . "',
    '" . $fecha_year . "'
    )";
                  mysqli_query($con, $sql_insert);
                }
              }

              $sql_listayear = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '" . $Session_IDEstacion . "' ORDER BY year desc";
              $result_listayear = mysqli_query($con, $sql_listayear);

              echo '<div class="row">';
              while ($row_listayear = mysqli_fetch_array($result_listayear, MYSQLI_ASSOC)) {
                $id = $row_listayear['id'];
                $year = $row_listayear['year'];

                echo '  <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 mb-1 mt-2 ">
  <div class="card card-menuB rounded shadow-sm pointer" onclick="IngresosFacturacion(' . $year . ')">
                    
  <div class="d-flex flex-row align-items-center">
  <div class="icon "> 
  <i class="fa-solid fa-calendar color-CB"></i>
  </div>
 
  <div class="m-details ms-2"> 
  <span>Año:</span> 
  <br>
  <h6>' . $year . '</h6> 
  </div>
  </div>

  </div>
  </div>';

              }
              echo '</div>';


              ?>

            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</body>

</html>