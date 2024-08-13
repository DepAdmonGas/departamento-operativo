<?php
require 'app/vistas/contenido/header.php';
?>

<!---------- LIBRERIAS DEL DATATABLE ---------->
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">

<script type="text/javascript" src="<?php echo RUTA_CORTEDIARIO_JS ?>clientes-lista-function.js"></script>
<script type="text/javascript">

  $(document).ready(function ($) {
    $(".LoaderPage").fadeOut("slow");
    ListaClientes(<?=$Session_IDEstacion?>,"<?=RUTA_JS2?>");
  });
  function EditarCliente(idCliente) {

    var Cuenta = $('#EditCuenta').val();
    var Cliente = $('#EditCliente').val();
    var Tipo = $('#EditTipo').val();
    var RFC = $('#EditRFC').val();

    CartaCredito = document.getElementById("EditCartaCredito");
    CartaCredito_file = CartaCredito.files[0];
    CartaCredito_filePath = CartaCredito.value;

    ActaConstitutiva = document.getElementById("EditActaConstitutiva");
    ActaConstitutiva_file = ActaConstitutiva.files[0];
    ActaConstitutiva_filePath = ActaConstitutiva.value;

    ComprobanteDom = document.getElementById("EditComprobanteDom");
    ComprobanteDom_file = ComprobanteDom.files[0];
    ComprobanteDom_filePath = ComprobanteDom.value;

    Identificacion = document.getElementById("EditIdentificacion");
    Identificacion_file = Identificacion.files[0];
    Identificacion_filePath = Identificacion.value;

    var data = new FormData();

    //var url = '../../../public/corte-diario/modelo/editar-cliente.php';
    var url = '../../../app/controlador/1-corporativo/controladorCorteDiario.php';
    data.append('accion', 'editar-cliente-credito');
    data.append('idCliente', idCliente);
    data.append('Cuenta', Cuenta);
    data.append('Cliente', Cliente);
    data.append('Tipo', Tipo);
    data.append('RFC', RFC);
    data.append('CartaCredito_file', CartaCredito_file);
    data.append('ActaConstitutiva_file', ActaConstitutiva_file);
    data.append('ComprobanteDom_file', ComprobanteDom_file);
    data.append('Identificacion_file', Identificacion_file);


    $.ajax({
      url: url,
      type: 'POST',
      contentType: false,
      data: data,
      processData: false,
      cache: false
    }).done(function (response) {
      if (response == 1) {
        $('#ModalEditar').modal('hide');
        ListaClientes(<?=$Session_IDEstacion?>,"<?=RUTA_JS2?>");

        $('#EditCuenta').val('');
        $('#EditCliente').val('');
        $('#EditTipo').val('');
        $('#EditRFC').val('');
        alertify.success('Cliente editado exitosamente');

      } else {
        alertify.error('Error al editar cliente')
      }

    });

  }
  function EditarClienteDebito(idCliente) {

    var Cuenta = $('#EditCuenta').val();
    var Cliente = $('#EditCliente').val();
    var Tipo = $('#EditTipo').val();


    var data = new FormData();
    //var url = '../../../public/corte-diario/modelo/editar-cliente-debito.php';
    var url = '../../../app/controlador/1-corporativo/controladorCorteDiario.php';
    data.append('accion', 'editar-cliente-debito');
    data.append('idCliente', idCliente);
    data.append('Cuenta', Cuenta);
    data.append('Cliente', Cliente);
    data.append('Tipo', Tipo);

    $.ajax({
      url: url,
      type: 'POST',
      contentType: false,
      data: data,
      processData: false,
      cache: false
    }).done(function (response) {
      if (response == 1) {
        $('#ModalEditar').modal('hide');
        ListaClientes(<?=$Session_IDEstacion?>,"<?=RUTA_JS2?>");

        $('#EditCuenta').val('');
        $('#EditCliente').val('');
        $('#EditTipo').val('');
        alertify.success('Cliente editado exitosamente');


      } else {
        alertify.error('Error al editar cliente')
      }

    });

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
        <div class="col-12">

          <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
            <ol class="breadcrumb breadcrumb-caret">
              <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
                    class="fa-solid fa-chevron-left"></i> Clientes, <?=$ClassHerramientasDptoOperativo->nombreMes($GET_mes)?> <?=$GET_year?></a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase">Lista de Clientes</li>
            </ol>
          </div>
          <div class="row">
          <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12">
          <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                Lista de Clientes
              </h3>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12">
              <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="Agregar()">
                <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
            </div>
          </div>
        </div>
    </div>
    <hr>
    <div id="ListaClientes"></div>
  </div>
  </div>


  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Crear Cliente</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <label class="text-secondary">* Cuenta</label>
          <textarea class="form-control rounded-0" id="Cuenta"></textarea>

          <label class="text-secondary mt-2">* Cliente</label>
          <textarea class="form-control rounded-0" id="Cliente"></textarea>

          <label class="text-secondary mt-2">* Tipo</label>
          <select class="form-select rounded-0" id="Tipo" onchange="SelCredito(this)">
            <option value="">Selecciona una opción...</option>
            <option value="Crédito">Crédito</option>
            <option value="Débito">Débito</option>
          </select>

          <div id="SelCredito" style="display: none;">
            <hr>

            <label class="text-secondary">Carta de crédito</label>
            <input type="file" class="form-control" id="CartaCredito">

            <label class="text-secondary mt-2">Acta constitutiva</label>
            <div><input type="file" class="form-control" id="ActaConstitutiva"></div>

            <label class="text-secondary mt-2">RFC</label>
            <input type="text" class="form-control rounded-0" id="RFC">

            <label class="text-secondary mt-2">Comprobante de domicilio</label>
            <div><input type="file" class="form-control" id="ComprobanteDom"></div>

            <label class="text-secondary mt-2">Identificación</label>
            <div><input type="file" class="form-control" id="Identificacion"></div>
          </div>

        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-labeled2 btn-success" onclick="Guardar(<?=$Session_IDEstacion?>,'<?=RUTA_JS2?>')">
        <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
          
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="ModalEditar" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div id="ModalEditarCliente"></div>
      </div>
    </div>
  </div>



<!---------- FUNCIONES - NAVBAR ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

<!---------- LIBRERIAS DEL DATATABLE ---------->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>

</body>
</html>