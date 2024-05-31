<?php
require 'app/vistas/contenido/header.php';
$GET_idReporte;
?>
<script type="text/javascript">

    $(document).ready(function ($) {
        $(".LoaderPage").fadeOut("slow");
        ListaPivoteo(<?= $GET_idReporte; ?>);
    });

    function Regresar() {
        window.history.back();
    }

    function ListaPivoteo(idReporte) {
        //$('#ListaPivoteo').load('../public/corte-diario/vistas/lista-pivoteo-detalle.php?idReporte=' + idReporte);
        $('#ListaPivoteo').load('../app/vistas/contenido/3-importacion/pivoteo/lista-pivoteo-detalle.php?idReporte=' + idReporte);
    }

    function Guardar(idReporte,idEstacion) {

        let Producto = $('#Producto').val();
        let Litros = $('#Litros').val();
        let Tanque = $('#Tanque').val();
        let TAD = $('#TAD').val();
        let Unidad = $('#Unidad').val();
        let Chofer = $('#Chofer').val();

        if (Producto != "") {
            $('#Producto').css('border', '');
            if (Litros != "") {
                $('#Litros').css('border', '');
                if (Tanque != "") {
                    $('#Tanque').css('border', '');
                    if (TAD != "") {
                        $('#TAD').css('border', '');
                        if (Unidad != "") {
                            $('#Unidad').css('border', '');
                            if (Chofer != "") {
                                $('#Chofer').css('border', '');


                                var parametros = {
                                    "idEstacion" :idEstacion,
                                    "idReporte": idReporte,
                                    "Producto": Producto,
                                    "Litros": Litros,
                                    "Tanque": Tanque,
                                    "TAD": TAD,
                                    "Unidad": Unidad,
                                    "Chofer": Chofer,
                                    "accion":"pivoteo-detalle"
                                };

                                $.ajax({
                                    data: parametros,
                                    //url: '../public/corte-diario/modelo/agregar-pivoteo-detalle.php',
                                    url: '../app/controlador/3-importacion/controladorPivoteo.php',
                                    type: 'post',
                                    beforeSend: function () {
                                    },
                                    complete: function () {

                                    },
                                    success: function (response) {
                                        if (response == 1) {
                                            ListaPivoteo(idReporte)

                                            $('#Producto').val('');
                                            $('#Litros').val('');
                                            $('#Tanque').val('');
                                            alertify.success('Pedido agregado exitosamente');

                                        } else {
                                            alertify.error('Error al agregar');
                                        }

                                    }
                                });


                            } else {
                                $('#Chofer').css('border', '2px solid #A52525');
                            }
                        } else {
                            $('#Unidad').css('border', '2px solid #A52525');
                        }
                    } else {
                        $('#TAD').css('border', '2px solid #A52525');
                    }
                } else {
                    $('#Tanque').css('border', '2px solid #A52525');
                }
            } else {
                $('#Litros').css('border', '2px solid #A52525');
            }
        } else {
            $('#Producto').css('border', '2px solid #A52525');
        }

    }

    function Finalizar(idReporte) {
        var parametros = {
            "idReporte": idReporte,
            "accion":"finalizar-detalle"
        };
        $.ajax({
            data: parametros,
            //url: '../public/corte-diario/modelo/finalizar-pivoteo-detalle.php',
            url: '../app/controlador/3-importacion/controladorPivoteo.php',
            type: 'post',
            beforeSend: function () {
            },
            complete: function () {
            },
            success: function (response) {
                if (response == 1) {
                    Regresar();
                } else {
                    alertify.error('Error al finalizar el pedido');
                }
            }
        });

    }

    function Eliminar(idReporte, id) {
        var parametros = {
            "id": id,
            "accion" : "eliminar-factura"
        };
        alertify.confirm('',
            function () {
                $.ajax({
                    data: parametros,
                    //url: '../public/corte-diario/modelo/eliminar-pivoteo-detalle.php',
                    url: '../app/controlador/3-importacion/controladorPivoteo.php',
                    type: 'post',
                    beforeSend: function () {
                    },
                    complete: function () {
                    },
                    success: function (response) {
                        if (response == 1) {
                            ListaPivoteo(idReporte)
                            alertify.success('Pedido eliminado exitosamente');
                        } else {
                            alertify.error('Error al eliminar el pedido');
                        }
                    }
                });
            },
            function () {
            }).setHeader('Mensaje').set({ transition: 'zoom', message: '¿Desea eliminar la información seleccionada?', labels: { ok: 'Aceptar', cancel: 'Cancelar' } }).show();
    }

    //--------------------------------------------------

    function ValidaLitros(e) {

        let Litros = e.value;

        if (Litros > 23000) {
            $('#Tanque').val('Tanque 2');
        } else {
            $('#Tanque').val('Tanque 1');
        }
    }
</script>
</head>
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
                                <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
                                    <ol class="breadcrumb breadcrumb-caret">
                                        <li class="breadcrumb-item"><a onclick="history.back()"
                                                class="text-uppercase text-primary pointer"><i
                                                    class="fa-solid fa-chevron-left"></i>
                                                lista pivoteo</a></li>
                                        <li aria-current="page" class="breadcrumb-item active text-uppercase">Editar
                                            Pivoteo
                                        </li>
                                    </ol>
                                </div>
                            </div>

                            <hr>


                            <div class="row">

                                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-3">

                                    <div class="border p-3">

                                        <div><b>Producto:</b></div>
                                        <select class="form-select mb-2" id="Producto">
                                            <option></option>
                                            <option>87 OCTANOS</option>
                                            <option>91 OCTANOS</option>
                                            <option>DIESEL</option>
                                        </select>

                                        <div><b>Litros:</b></div>
                                        <input type="number" class="form-control mb-2" id="Litros">

                                        <div><b>Tanque:</b></div>
                                        <div id="ResulTanque"></div>
                                        <select class="form-select mb-2" id="Tanque">
                                            <option></option>
                                            <option>Pipa</option>
                                            <option>Tanque 1</option>
                                            <option>Tanque 2</option>
                                        </select>

                                        <div><b>TAD:</b></div>
                                        <select class="form-select mb-2" id="TAD">
                                            <option></option>
                                            <option>Atlacomulco</option>
                                            <option>Tizayuca</option>
                                            <option>Tuxpan</option>
                                            <option>Puebla</option>
                                            <option>Vopack</option>
                                        </select>




                                        <div><b>Unidad:</b></div>
                                        <select class="form-select mb-2" id="Unidad">
                                            <option></option>

                                            <?php
                                            $sql_unidades = "SELECT no_unidad FROM tb_unidades_transporte WHERE estado = 0 ORDER BY no_unidad ASC";
                                            $result_unidades = mysqli_query($con, $sql_unidades);
                                            $numero_unidades = mysqli_num_rows($result_unidades);

                                            while ($row_unidades = mysqli_fetch_array($result_unidades, MYSQLI_ASSOC)) {
                                                $no_unidad = $row_unidades['no_unidad'];

                                                echo '<option>' . $no_unidad . '</option>';
                                            }

                                            ?>


                                        </select>

                                        <div><b>Chofer:</b></div>
                                        <select class="form-select mb-2" id="Chofer">
                                            <option></option>

                                            <?php
                                            $sql_chofer = "SELECT nombre_chofer FROM tb_pivoteo_chofer WHERE estado = 0 ORDER BY nombre_chofer ASC";
                                            $result_chofer = mysqli_query($con, $sql_chofer);
                                            $numero_chofer = mysqli_num_rows($result_chofer);

                                            while ($row_chofer = mysqli_fetch_array($result_chofer, MYSQLI_ASSOC)) {
                                                $nombre_chofer = $row_chofer['nombre_chofer'];

                                                echo '<option>' . $nombre_chofer . '</option>';
                                            }

                                            ?>


                                        </select>

                                        <hr>

                                        <div class="text-end">
                                            <button type="button" class="btn btn-primary "
                                                onclick="Guardar(<?= $GET_idReporte?>,<?=$Session_IDEstacion?>)">Guardar</button>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
                                    <div id="ListaPivoteo"></div>
                                </div>

                            </div>

                            <hr>
                            <div class="text-end">
                                <button type="button" class="btn btn-success"
                                    onclick="Finalizar(<?= $GET_idReporte; ?>)">Finalizar</button>
                            </div>



                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>




    <div class="modal" id="Modal">
        <div class="modal-dialog">
            <div class="modal-content" style="margin-top: 83px;">
                <div id="DivContenido"></div>
            </div>
        </div>
    </div>

    <!---------- FUNCIONES - NAVBAR ---------->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</body>

</html>