<?php
require 'app/vistas/contenido/header.php';
?>
<script type="text/javascript" src="<?php echo RUTA_CORTEDIARIO_JS ?>clientes-lista-function.js"></script>
<script type="text/javascript">

  $(document).ready(function ($) {
    $(".LoaderPage").fadeOut("slow");

    ListaClientes(<?= $Session_IDEstacion; ?>);
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
        ListaClientes(<?= $Session_IDEstacion; ?>);

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
        ListaClientes(<?= $Session_IDEstacion; ?>);

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
                    class="fa-solid fa-chevron-left"></i>Clientes</a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase">Lista Clientes</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-10">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                Lista Clientes
              </h3>
            </div>
            <div class="col-2">
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
            <option value="">Selecciona</option>
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
        <button type="button" class="btn btn-labeled2 btn-success" onclick="Guardar(<?=$Session_IDEstacion?>)">
        <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
          
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="ModalEditar" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" style="margin-top: 83px;">
        <div id="ModalEditarCliente"></div>
      </div>
    </div>
  </div>
</body>

</html>