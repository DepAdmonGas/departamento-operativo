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
        <div class="col-12 mb-3">
          <div class="cardAG">
            <div class="border-0 p-3">
              <div class="row">
                <div class="col-12">
                  <img class="float-start pointer" src="<?= RUTA_IMG_ICONOS; ?>regresar.png" onclick="history.back()">

                  <div class="row">
                    <div class="col-11">
                      <h5>Lista Clientes </h5>
                    </div>

                    <div class="col-1">
                      <img class="pointer float-end" src="<?= RUTA_IMG_ICONOS; ?>agregar.png" onclick="Agregar()">
                    </div>

                  </div>

                </div>
              </div>

              <hr>


              <div id="ListaClientes"></div>

            </div>
          </div>
        </div>

      </div>
    </div>

  </div>


  <div class="modal fade" id="Modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" style="margin-top: 83px;">
        <div class="modal-header">
          <h5 class="modal-title">Crear Cliente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
          <button type="button" class="btn btn-primary" onclick="Guardar(<?= $Session_IDEstacion; ?>)">Guardar</button>
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