<?php
class RecursosHumanosGeneral extends Exception
{

    private $con;
    private $herramientasDptoOperativo;
    public function __construct($con)
    {
        $this->con = $con;
        $this->herramientasDptoOperativo = new herramientasDptoOperativo($this->con);
    }

    //---------- AGREGAR ACCESO PERSONAL ----------
    function AgregarAcceso($idPersonal)
    {
        $result = "";
        $sql_val = "SELECT * FROM op_rh_personal_acceso WHERE id_personal = '" . $idPersonal . "' ";
        $result_val = mysqli_query($this->con, $sql_val);
        $numero_val = mysqli_num_rows($result_val);
        if ($numero_val == 0) {

            $sql_agregar_horario = "INSERT INTO op_rh_personal_acceso
(id_personal, huella, pin) VALUES ('" . $idPersonal . "', '', 0)";

            if (mysqli_query($this->con, $sql_agregar_horario)) {
                $result = true;
            } else {
                $result = false;
            }

        }
        return $result;
    }


    //---------- ICONO DOCUMENTOS DEL PERSONAL ----------
    function generarDetalleIcono($rutaArchivo, $nombreArchivo, $tooltip)
    {

        if ($nombreArchivo != "") {
            $extensionArchivo = $this->herramientasDptoOperativo->obtenerExtensionArchivo($nombreArchivo);
            if (in_array($extensionArchivo, ["pdf", "jpg", "png", "txt", "xml", "jpeg", "PDF", "JPG", "PNG", "TXT", "XML", "JPEG"])) {
                if ($tooltip == "Identificación Oficial" || $tooltip == "Constancia de Situación Fiscal (CSF)") {
                    if (file_exists($nombreArchivo)) {
                        $fechaHoy = date("Y-m-d");
                        $fechaCreacion = filectime($nombreArchivo);
                        $nuevaFecha = strtotime('+1 year', $fechaCreacion);
                        $fechaFormateada = date('Y-m-d', $nuevaFecha);

                        if ($fechaFormateada <= $fechaHoy) {
                            $detalle = '<a href="' . $rutaArchivo . $nombreArchivo . '" download> <img class="pointer" src="' . RUTA_IMG_ICONOS . 'actualizar-tb.png" data-toggle="tooltip" data-placement="top" title="' . $tooltip . '"></a>';
                        } else {
                            $detalle = '<a href="' . $rutaArchivo . $nombreArchivo . '" download> <img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png" data-toggle="tooltip" data-placement="top" title="' . $tooltip . '"></a>';
                        }

                    } else {
                        $detalle = '<a href="' . $rutaArchivo . $nombreArchivo . '" download> <img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png" data-toggle="tooltip" data-placement="top" title="' . $tooltip . '"></a>';
                    }

                } else {
                    $detalle = '<a href="' . $rutaArchivo . $nombreArchivo . '" download> <img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png" data-toggle="tooltip" data-placement="top" title="' . $tooltip . '"></a>';
                }

            } else {
                $detalle = $nombreArchivo;
            }

        } else {
            $detalle = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';
        }

        return $detalle;
    }


    //---------- PERSONAL CON ESTADO DE BAJA ----------
    function PersonalBaja($idPersonal)
    {
        $sql_baja = "SELECT * FROM op_rh_personal_baja WHERE id_personal = '" . $idPersonal . "' ";
        $result_lista_baja = mysqli_query($this->con, $sql_baja);
        $numero_lista_baja = mysqli_num_rows($result_lista_baja);

        if ($numero_lista_baja != 0) {

            while ($row_lista_baja = mysqli_fetch_array($result_lista_baja, MYSQLI_ASSOC)) {
                $id_baja = $row_lista_baja['id'];
                $fecha_baja = $this->herramientasDptoOperativo->formatoFecha($row_lista_baja['fecha_baja']);
                $estado_proceso = $row_lista_baja['estado_proceso'];

            }

        } else {

            $id_baja = "";
            $fecha_baja = "S/I";
            $estado_proceso = 0;

        }

        $array = array(
            'num_listaBaja' => $numero_lista_baja,
            'id_baja' => $id_baja,
            'fecha_baja' => $fecha_baja,
            'estado_proceso' => $estado_proceso
        );

        return $array;
    }



    /**
     * 
     * 
     * 
     * ORGANIGRAMA
     * 
     */
    public function mostrarEstacion(int $idEstacion) :string {
        $nombre = "";
        $registro = "";
        $calle = "";
        $exterior = "";
        $colonia = "";
        $cp = "";
        $estado = "";
        $municipio ="";
        $telefono = "";
        $stmt = "SELECT nombre, registro_patronal,calle,numero_exterior,colonia,codigo_postal,
        estado,municipio,numero_telefono FROM tb_organigrama_estaciones WHERE id = ?";
        $result = $this->con->prepare($stmt);
        $result->bind_param("i",$idEstacion);
        $result->execute();
        $result->bind_result($nombre,$registro,$calle,$exterior,$colonia,$cp,$estado,$municipio,$telefono);
        $result->fetch();
        $result->close();
        $estacion = '
        <div class="table-responsive">
        <table class="custom-table mt-2" style="font-size: .8em;" width="100%">
        <thead class="tables-bg">
            <th><b>Nombre de la empresa</b></th>
            <th><b>'.$nombre.'</b></th>
        </thead>
        <tbody class="bg-white">

        <tr>
        <th>Registro Patronal</th>
        <td>'.$registro.'</td>
        </tr>

        <tr>
        <th>Calle</th>
        <td>'.$calle.'</td>
        </tr>

        <tr>
        <th>Numero Ext.</th>
        <td>'.$exterior.'</td>
        </tr>

        <tr>
        <th>Numero Int. </th>
        <td> S/N </td>
        </tr>

        <tr>
        <th>Colonia</th>
        <td>'.$colonia.'</td>
        </tr>

        <tr>
        <th>Codigo Postal</th>
        <td>'.$cp.'</td>
        </tr>

        <tr>
        <th>Estado</th>
        <td>'.$estado.'</td>
        </tr>

        <tr>
        <th>Municipio</th>
        <td>'.$municipio.'</td>
        </tr>

        <tr>
        <th>Numero de telefono</th>
        <td>'.$telefono.'</td>
        </tr>


        </tbody>
        </table>
        </div>';
        return $estacion;
    }
}