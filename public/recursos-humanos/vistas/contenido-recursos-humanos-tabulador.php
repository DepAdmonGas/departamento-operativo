<?php
require('../../../app/help.php');

$sql_lista = "SELECT * FROM op_tabulador";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>
<script type="text/javascript">
$(document).ready(function($){
$('[data-toggle="tooltip"]').tooltip();
});
</script>


<div class="border-0 p-3">

<div class="row">
<div class="col-10">
  <h5>Tabulador vacaciones</h5>
</div>
</div>
<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered table-hover mb-0">
<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">Años laborales</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Días de vacaciones</th>
  </tr>
</thead> 
<tbody>
<?php
if ($numero_lista > 0) {

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

echo '<tr>';
echo '<td class="align-middle text-center">Año '.$row_lista['year'].'</td>';
echo '<td class="align-middle text-center">'.$row_lista['dias'].' días</td>';
echo '</tr>';

}
}else{
echo "<tr><td colspan='2' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>

</tbody>
</table>
</div>

</div>