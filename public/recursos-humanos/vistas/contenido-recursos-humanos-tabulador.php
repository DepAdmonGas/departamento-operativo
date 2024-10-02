<?php
require('../../../app/help.php');

$sql_lista = "SELECT * FROM op_tabulador";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>


<div class="row">
<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Recursos humanos
</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Tabulador de Vacaciones</li>
</ol>
</div>
 
<div class="row"> 
<div class="col-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Tabulador de Vacaciones</h3> </div>
</div>

<hr>
</div>
</div> 

<div class="table-responsive">
<table id="tabla_tabulador" class="custom-table" style="font-size: 12.5px;" width="100%">

<thead class="tables-bg">
<tr>
<th class="text-center align-middle tableStyle font-weight-bold">Años laborales</th>
<th class="text-center align-middle tableStyle font-weight-bold">Días de vacaciones</th>
</tr>
</thead> 

<tbody class="bg-white">
<?php
if ($numero_lista > 0) {

while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){

echo '<tr>';
echo '<th class="align-middle text-center fw-normal">Año '.$row_lista['year'].'</th>';
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

