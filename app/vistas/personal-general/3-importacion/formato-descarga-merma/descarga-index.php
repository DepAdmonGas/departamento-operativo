<?php
require 'app/vistas/contenido/header.php';
?>
<!---------- LIBRERIAS DEL DATATABLE ---------->
<link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css" rel="stylesheet">
<script type="text/javascript">
    
    $(document).ready(function ($) {
        $(".LoaderPage").fadeOut("slow");
        ListaMerma();
    });

    function ListaMerma() {
        let targets;
        targets = [3];

        $('#Contenido').load('app/vistas/contenido/3-importacion/formato-descarga-merma/contenido-merma.php', function () {
            $('#tabla_merma').DataTable({
                "language": {
                    "url": "<?= RUTA_JS2 ?>/es-ES.json"
                },
                "order": [[0, "desc"]],
                "lengthMenu": [15,30,50,100],
                "columnDefs": [
                    { "orderable": false, "targets": targets },
                    { "searchable": false, "targets": targets }
                ]
            });
        });

    }
    function CrearDescarga() {
        window.location.href = "descarga-tuxpan-nuevo";
    }
    function Detalle(id) {
        window.location.href = "descarga-tuxpan-detalle/" + id;
    }

    function PDF(id) {
        window.location.href = "administracion/descarga-tuxpan-pdf/" + id;
    }

</script>
<!--Se ocupa cuando se registra un nuevo permiso y se actualice los datos de la vista-->
<script>
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                // Si la página está en la caché del navegador, recargarla
                window.location.reload();
            }
        });
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
                    <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
                        <ol class="breadcrumb breadcrumb-caret">
                            <li class="breadcrumb-item"><a onclick="history.back()"
                                    class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i>
                                    Importacion</a></li>
                            <li aria-current="page" class="breadcrumb-item active text-uppercase">Formato descarga merma
                            </li>
                        </ol>
                    </div>

                    <div class="row">
                        <div class="col-9">
                            <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                                Formato descarga merma</h3>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-labeled2 btn-primary float-end"
                                onclick="CrearDescarga()">
                                <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
                        </div>

                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="col-12" id="Contenido"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---------- FUNCIONES - NAVBAR ---------->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

    <!---------- LIBRERIAS DEL DATATABLE ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>
</body>

</html>