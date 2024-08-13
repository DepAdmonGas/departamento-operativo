<?php
require ('../../../app/help.php');
?>


<div class="table-responsive">
  <table class="custom-table"style="font-size: .8em;" width="100%">
    <thead class="tables-bg">
      <th class="text-center align-middle">ID</th>
      <th class="align-middle">CONCEPTO</th>
      <th class="text-center align-middle">PZAS CAJAS</th>
      <th class="text-center align-middle">PRECIO UNITARIO</th>
    </thead>
    <tbody class="bg-white">
      <?php

      $sql_listaaceite = "SELECT * FROM op_aceites ORDER BY id_aceite ASC";
      $result_listaaceite = mysqli_query($con, $sql_listaaceite);
      while ($row_listaaceite = mysqli_fetch_array($result_listaaceite, MYSQLI_ASSOC)) {

        $idAceite = $row_listaaceite['id'];
        $noAceite = $row_listaaceite['id_aceite'];
        $concepto = $row_listaaceite['concepto'];
        $precio = $row_listaaceite['precio'];
        $piezas = $row_listaaceite['piezas'];
        ?>
        <tr>
          <th class="align-middle p-1" width="80px">
            <input id="noAceite-<?= $idAceite; ?>" type="number" min="0"
              style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: center;"
              onkeyup="EditNoAceite(this,<?= $idAceite; ?>)" value="<?= $noAceite; ?>" placeholder="ID">
          </th>
          <td class="align-middle p-1">
            <input id="concepto-<?= $idAceite; ?>" type="text" min="0"
              style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: left;"
              onkeyup="EditConcepto(this,<?= $idAceite; ?>)" value="<?= $concepto; ?>" placeholder="CONCEPTO">
          </td>
          <td class="align-middle p-1" width="80px">
            <input id="noAceite-<?= $idAceite; ?>" type="number" min="0"
              style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: center;"
              onkeyup="EditPiezas(this,<?= $idAceite; ?>)" value="<?= $piezas; ?>" placeholder="PIEZAS">
          </td>
          <td class="align-middle p-1" width="150px">
            <input id="precio-<?= $idAceite; ?>" type="text" min="0"
              style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: right;"
              onkeyup="EditPrecio(this,<?= $idAceite; ?>)" value="<?= number_format($precio, 2); ?>"
              placeholder="PRECIO UNITARIO">
          </td>
        </tr>

        <?php
      }

      ?>
    </tbody>
  </table>
</div>

<div id="targer1"></div>