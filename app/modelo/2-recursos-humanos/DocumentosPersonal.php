<?php
require "../../bd/inc.conexion.php";
require_once '../../modelo/HerramientasDptoOperativo.php';

class DocumentosPersonal extends Exception
{
 
    private $classConexionBD;
    private $con;
    private $formato;
    private $herramientasDptoOperativo;


    public function __construct()
    {
    $this->classConexionBD = Database::getInstance();
    $this->con = $this->classConexionBD->getConnection();
    $this->herramientasDptoOperativo = new herramientasDptoOperativo($this->con);
    }

    /* ---------- CONSULTAS ----------*/
    function obtenerUltimaBajaPersonal()
    {
        
    $numid = 1; // Valor por defecto si no se encuentra ninguna solicitud
        
    $sql = "SELECT id FROM op_rh_personal_baja ORDER BY id DESC LIMIT 1";
    $consulta = $this->con->prepare($sql);
        
    if (!$consulta) {
    throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
    }
        
    if (!$consulta->execute()) {
    throw new Exception("Error al ejecutar la consulta: " . $consulta->error);
    }
        
    $consulta->store_result();
        
    if ($consulta->num_rows > 0) {
    $consulta->bind_result($id);
    $consulta->fetch();
    $numid = $id + 1;
    }
        
    $consulta->close();
    return $numid;
    }

 
    /* ---------- AGREGAR ----------*/
    public function agregarPinPersonal(int $idPersonal, int $PinAcceso): int
    {
    $result = 0;  // 0 = error, 1 = éxito, 2 = PIN ya existe

    // Consulta para verificar si el PIN ya existe
    $sql_val = "SELECT * FROM op_rh_personal_acceso WHERE pin = ?";
    $stmt_val = $this->con->prepare($sql_val);
    if (!$stmt_val) {
    throw new Exception("Error al preparar la consulta: " . $this->con->error);
    }
    
    $stmt_val->bind_param("i", $PinAcceso);
    if (!$stmt_val->execute()) {
    throw new Exception("Error al ejecutar la consulta: " . $stmt_val->error);
    }
    
    $result_val = $stmt_val->get_result();
    $numero_val = $result_val->num_rows;
    
    if ($numero_val == 0) {
    // Si el PIN no existe, procedemos a actualizarlo
    $sql_edit = "UPDATE op_rh_personal_acceso SET pin = ? WHERE id_personal = ?";
    $stmt_edit = $this->con->prepare($sql_edit);
    if (!$stmt_edit) {
    throw new Exception("Error al preparar la consulta de actualización: " . $this->con->error);
    }
    
    $stmt_edit->bind_param("ii", $PinAcceso, $idPersonal);
    if ($stmt_edit->execute()) {
    $result = 1; 
    } else {
    $result = 0; 
    }
    
    $stmt_edit->close();
    } else {
    $result = 2; // El PIN ya existe
    }
    
    $stmt_val->close();
    
    return $result;
    }


    public function agregarComentarioPersonal(int $idPersonal, int $idUsuario, string $Comentario): bool
    {
    $result = true;
    $sql_insert = "INSERT INTO op_rh_personal_comentarios (id_personal,id_usuario,comentario) VALUES (?,?,?)";
    $stmt = $this->con->prepare($sql_insert);
    if(!$stmt) :
    $result = false;
    throw new Exception("Error al preparar la consulta ". $stmt->error);
    endif;

    $stmt->bind_param("iis", $idPersonal,$idUsuario,$Comentario);
    if(!$stmt->execute()) :
    $result = false;
    throw new Exception("Error al ejecutar la consulta". $this->con->error);
    endif;

    $stmt->close();
    return $result;
    }

    public function agregarComentarioBajaPersonal(int $idBaja, int $idUsuario, string $Comentario): bool
    {
    $result = true;
    $sql_insert = "INSERT INTO op_rh_personal_baja_comentarios (id_baja,id_usuario,comentario) VALUES (?,?,?)";
    $stmt = $this->con->prepare($sql_insert);
    if(!$stmt) :
    $result = false;
    throw new Exception("Error al preparar la consulta ". $stmt->error);
    endif;

    $stmt->bind_param("iis", $idBaja,$idUsuario,$Comentario);
    if(!$stmt->execute()) :
    $result = false;
    throw new Exception("Error al ejecutar la consulta". $this->con->error);
    endif;

    $stmt->close();
    return $result;
    }


    public function agregarComentarioListaNegra(int $idListaNegra, int $idUsuario, string $Comentario): bool
    {
    $result = true;
    $sql_insert = "INSERT INTO op_rh_lista_negra_comentarios (id_lista_negra,id_usuario,comentario) VALUES (?,?,?)";
    $stmt = $this->con->prepare($sql_insert);
    if(!$stmt) :
    $result = false;
    throw new Exception("Error al preparar la consulta ". $stmt->error);
    endif;

    $stmt->bind_param("iis", $idListaNegra,$idUsuario,$Comentario);
    if(!$stmt->execute()) :
    $result = false;
    throw new Exception("Error al ejecutar la consulta". $this->con->error);
    endif;

    $stmt->close();
    return $result;
    }


    public function agregarArchivoPersonal(array $documento, int $indice, string $ruta1, string $ruta2, string $nombreLocalidad): string
    {

    $numeroAleatorio = rand(1, 1000000);
    $numeroAleatorio2 = rand(1000, 9999);
    
    if (!empty($documento[$indice]) && isset($documento[$indice]['name'])):
    $NoDoc1 = $documento[$indice]['name'];
    $infoArchivo = pathinfo($NoDoc1);
    $extension = $infoArchivo['extension'];

    $UpDoc1 = "../../../archivos/documentos-personal/".$ruta1."/".$numeroAleatorio."-".$ruta2."-".$nombreLocalidad."-".$numeroAleatorio2 . "." . $extension;
    $NomDoc1 = $numeroAleatorio."-".$ruta2."-".$nombreLocalidad."-".$numeroAleatorio2 . "." . $extension;
    move_uploaded_file($documento[$indice]['tmp_name'], $UpDoc1);

    else:
    $NomDoc1 = "";
    endif;

    return $NomDoc1;
    }


    public function agregarInformacionPersonal(array $infoPersonal, array $documentos): bool
    {
    $result = true;
    $sql_insert = "INSERT INTO op_rh_personal (id_estacion, fecha_ingreso, no_colaborador, nombre_completo, puesto, sd, requisicion, curriculum, ine, acta_nacimiento,
    c_domicilio, nss, c_estudios, c_recomendacion, curp, a_infonavit, rfc, c_antecedentes, contrato, estado) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt_insert = $this->con->prepare($sql_insert);
    if(!$stmt_insert) :
    $result = false;
    throw new Exception("Error al preparar la consulta ". $stmt_insert->error);
    endif;


    $datosLocalidad = $this->herramientasDptoOperativo->obtenerDatosLocalidades($infoPersonal[0]);
    $nombreEstacion = $datosLocalidad['localidad'];

    if ($documentos[0] != ''): 
    $indice = 0;
    $ruta1 = "requisicion";
    $ruta2 = "Requisicion";
    $requision = $this->agregarArchivoPersonal($documentos, $indice, $ruta1, $ruta2, $nombreEstacion);
    endif;

    if ($documentos[1] != ''):
    $indice = 1;
    $ruta1 = "curriculum";
    $ruta2 = "Curriculum";
    $curriculum = $this->agregarArchivoPersonal($documentos, $indice, $ruta1, $ruta2, $nombreEstacion);
    endif;
    
    if ($documentos[2] != ''):
    $indice = 2;
    $ruta1 = "ine";
    $ruta2 = "Identificacion";
    $ine = $this->agregarArchivoPersonal($documentos, $indice, $ruta1, $ruta2, $nombreEstacion);
    endif;
     
    if ($documentos[3] != ''):
    $indice = 3;
    $ruta1 = "acta_nacimiento";
    $ruta2 = "Acta de Nacimiento";
    $acta_nacimiento = $this->agregarArchivoPersonal($documentos, $indice, $ruta1, $ruta2, $nombreEstacion);
    endif;
    
    if ($documentos[4] != ''):
    $indice = 4;
    $ruta1 = "comprobante_domicilio";
    $ruta2 = "Comprobante de Domicilio";
    $comprobante_domicilio = $this->agregarArchivoPersonal($documentos, $indice, $ruta1, $ruta2, $nombreEstacion);
    endif;
    
    if ($documentos[5] != ''):
    $indice = 5;
    $ruta1 = "nss";
    $ruta2 = "Comprobante IMSS";
    $nss = $this->agregarArchivoPersonal($documentos, $indice, $ruta1, $ruta2, $nombreEstacion);
    endif;
    
    if ($documentos[6] != ''):
    $indice = 6;
    $ruta1 = "comprobante_estudios";
    $ruta2 = "Comprobante de Estudios";
    $consulta = "c_estudios";
    $comprobante_estudios = $this->agregarArchivoPersonal($documentos, $indice, $ruta1, $ruta2, $nombreEstacion);
    endif;
    
    if ($documentos[7] != ''):
    $indice = 7;
    $ruta1 = "cartas_recomendacion";
    $ruta2 = "Carta de Recomendacion";
    $cartas_recomendacion = $this->agregarArchivoPersonal($documentos, $indice, $ruta1, $ruta2, $nombreEstacion);
    endif;
    
    if ($documentos[8] != ''):
    $indice = 8;
    $ruta1 = "curp";
    $ruta2 = "CURP";
    $curp = $this->agregarArchivoPersonal($documentos, $indice, $ruta1, $ruta2, $nombreEstacion);
    endif;
    
    if ($documentos[9] != ''):
    $indice = 9;
    $ruta1 = "acta_infonavit";
    $ruta2 = "Aviso Infonavit";
    $acta_infonavit = $this->agregarArchivoPersonal($documentos, $indice, $ruta1, $ruta2, $nombreEstacion);
    endif;
    
    if ($documentos[10] != ''):
    $indice = 10;
    $ruta1 = "rfc";
    $ruta2 = "RFC";
    $rfc = $this->agregarArchivoPersonal($documentos, $indice, $ruta1, $ruta2, $nombreEstacion);
    endif;
    
    if ($documentos[11] != ''):
    $indice = 11;
    $ruta1 = "carta_antecedentes";
    $ruta2 = "Antecedentes Penales";
    $consulta = "c_antecedentes";
    $carta_antecedentes = $this->agregarArchivoPersonal($documentos, $indice, $ruta1, $ruta2, $nombreEstacion);
    endif;
    
    if ($documentos[12] != ''):
    $indice = 12;
    $ruta1 = "contrato";
    $ruta2 = "Contrato";
    $contrato = $this->agregarArchivoPersonal($documentos, $indice, $ruta1, $ruta2, $nombreEstacion);
    endif;
    
    $personalStatus = 1;

    $stmt_insert->bind_param("isissdsssssssssssssi", $infoPersonal[0],$infoPersonal[2],$infoPersonal[3],$infoPersonal[4],$infoPersonal[5],$infoPersonal[6],$requision,$curriculum,$ine,$acta_nacimiento,
    $comprobante_domicilio,$nss,$comprobante_estudios,$cartas_recomendacion,$curp,$acta_infonavit,$rfc,$carta_antecedentes,$contrato,$personalStatus);
    if(!$stmt_insert->execute()) :
    $result = false;
    throw new Exception("Error al ejecutar la consulta". $this->con->error);
    endif;

    $stmt_insert->close();

    return $result;
    }


    public function agregarArchivoBajaPersonal(int $idBaja, string $nameDocumento, array $documento, int $indice): bool
    {    
    $result = true;

    $UpDoc1 = "";
    $NomDoc1 = "";

    if (!empty($documento[$indice]) && isset($documento[$indice]['name'])):
    $NoDoc1 = $documento[$indice]['name'];
    $aleatorio1 = rand(1, 1000000);
    $aleatorio2 = rand(1000, 9999);
    $extencion = $this->herramientasDptoOperativo->obtenerExtensionArchivo($NoDoc1);
   
    $UpDoc1 = "../../../archivos/documentos-personal/solicitud-baja/".$aleatorio1."-".$nameDocumento."-".$aleatorio2.".".$extencion;
    $NomDoc1 = $aleatorio1."-".$nameDocumento."-".$aleatorio2.".".$extencion;

    move_uploaded_file($documento[$indice]['tmp_name'], $UpDoc1);

    $sql_insert = "INSERT INTO op_rh_personal_baja_archivos (id_baja, descripcion, archivo) VALUES (?,?,?)";
    $stmt = $this->con->prepare($sql_insert);
    if(!$stmt) :
    $result = false;
    throw new Exception("Error al preparar la consulta ". $stmt->error);
    endif;

    $stmt->bind_param("iss", $idBaja, $nameDocumento, $NomDoc1);
    if(!$stmt->execute()) :
    $result = false;
    throw new Exception("Error al ejecutar la consulta". $this->con->error);
    endif;
    
    $stmt->close();
    endif;

    return $result;
    }
 
    public function agregarArchivoListaNegra(int $idListaNegra, string $nameDocumento, array $documento, int $indice): bool
    {    
    $result = true;

    $UpDoc1 = "";
    $NomDoc1 = "";

    if (!empty($documento[$indice]) && isset($documento[$indice]['name'])):
    $NoDoc1 = $documento[$indice]['name'];
    $aleatorio1 = rand(1, 1000000);
    $aleatorio2 = rand(1000, 9999);
    $extencion = $this->herramientasDptoOperativo->obtenerExtensionArchivo($NoDoc1);
   
    $UpDoc1 = "../../../archivos/documentos-personal/solicitud-baja/".$aleatorio1."-".$nameDocumento."-".$aleatorio2.".".$extencion;
    $NomDoc1 = $aleatorio1."-".$nameDocumento."-".$aleatorio2.".".$extencion;

    move_uploaded_file($documento[$indice]['tmp_name'], $UpDoc1);

    $sql_insert = "INSERT INTO op_rh_personal_lista_negra_archivos (id_lista_negra, descripcion, archivo) VALUES (?,?,?)";
    $stmt = $this->con->prepare($sql_insert);
    if(!$stmt) :
    $result = false;
    throw new Exception("Error al preparar la consulta ". $stmt->error);
    endif;

    $stmt->bind_param("iss", $idListaNegra, $nameDocumento, $NomDoc1);
    if(!$stmt->execute()) :
    $result = false;
    throw new Exception("Error al ejecutar la consulta". $this->con->error);
    endif;
    
    $stmt->close();
    endif;

    return $result;
    }


    public function agregarListaNegraPersonal(int $idPersonal, string $fecha, string $motivo, string $detalle): bool
    {
    $result = true;

    $sql_insert = "INSERT INTO op_rh_personal_lista_negra (id_personal,fecha,motivo,detalle) VALUES (?, ?, ?, ?)";
    $stmt_insert = $this->con->prepare($sql_insert);
    if(!$stmt_insert):
    $result = false;
    throw new Exception("Error al preparar la consulta ".$stmt_insert->error);
    endif; 

    $stmt_insert->bind_param("isss", $idPersonal, $fecha, $motivo, $detalle);
    if (!$stmt_insert->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt_insert->error);
    endif;   
    $stmt_insert->close();

    return $result;
    }


    public function agregarBajaPersonal(array $infoBaja, array $documentos): bool
    {
    $result = true;

    $sql_insert = "INSERT INTO op_rh_personal_baja (id, id_personal, fecha_baja, motivo, detalle, proceso, estado_proceso)
    VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $this->con->prepare($sql_insert);
    if(!$stmt_insert):
    $result = false;
    throw new Exception("Error al preparar la consulta ".$stmt_insert->error);
    endif; 

    $ultimaBajaPersonal = $this->obtenerUltimaBajaPersonal();
    $procesoBaja = "";
    $statusBaja = 0;

    $stmt_insert->bind_param("iissssi", $ultimaBajaPersonal, $infoBaja[0], $infoBaja[1], $infoBaja[2], $infoBaja[3], $procesoBaja, $statusBaja);
    if (!$stmt_insert->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt_insert->error);
    endif;   
    $stmt_insert->close();


    if ($documentos[0] != ''):
    $indice = 0;
    $descripcion = "Acta de hechos";
    $this->agregarArchivoBajaPersonal($ultimaBajaPersonal, $descripcion, $documentos, $indice);
    endif;

    if ($documentos[1] != ''):
    $indice = 1;
    $descripcion = "Carta de Renuncia";
    $this->agregarArchivoBajaPersonal($ultimaBajaPersonal, $descripcion, $documentos, $indice);
    endif;

    if ($documentos[2] != ''):
    $indice = 2;
    $descripcion = "Finiquito";
    $this->agregarArchivoBajaPersonal($ultimaBajaPersonal, $descripcion, $documentos, $indice);
    endif;


    $sql_update = "UPDATE op_rh_personal SET estado = 0 WHERE id = ?";
    $stmt_update = $this->con->prepare($sql_update);
    if(!$stmt_update):
    $result = false;
    throw new Exception("Error al preparar la consulta ".$stmt_update->error);
    endif; 

    $stmt_update->bind_param("i", $infoBaja[0]);
    if (!$stmt_update->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt_update->error);
    endif;   
    $stmt_update->close();


    if($infoBaja[2] == 'Mala practica'){
    $this->agregarListaNegraPersonal($infoBaja[0],$infoBaja[1],$infoBaja[2],$infoBaja[3]);
    }


    return $result;
    }

    /* ---------- EDITAR ----------*/
    function editarArchivosPersonal(int $idUsuario, array $documento, int $indice, string $ruta1, string $ruta2, string $nombrePersonal, string $consulta): bool
    {    
    $result = true; 

    $numeroAleatorio = rand(1, 1000000);
    $numeroAleatorio2 = rand(1000, 9999);

    $UpDoc1 = "";
    $NomDoc1 = "";

    if (!empty($documento[$indice]) && isset($documento[$indice]['name'])):

    $NoDoc1 = $documento[$indice]['name'];
    $infoArchivo = pathinfo($NoDoc1);
    $extension = $infoArchivo['extension'];

    $UpDoc1 = "../../../archivos/documentos-personal/".$ruta1."/".$numeroAleatorio."-".$ruta2."-".$nombrePersonal."-".$numeroAleatorio2 . "." . $extension;
    $NomDoc1 = $numeroAleatorio."-".$ruta2."-".$nombrePersonal."-".$numeroAleatorio2 . "." . $extension;
    move_uploaded_file($documento[$indice]['tmp_name'], $UpDoc1);

    $sql_edit = "UPDATE op_rh_personal SET $consulta = ? WHERE id = ?";
    $stmt_sql_edit = $this->con->prepare($sql_edit);
    if (!$stmt_sql_edit):
    $result = false;
    throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
    endif;

    $stmt_sql_edit->bind_param("si", $NomDoc1, $idUsuario);
    if (!$stmt_sql_edit->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt_sql_edit->error);
    endif;
    $stmt_sql_edit->close();
    endif;

    return $result;
    }

    public function editarInformacionPersonal(array $infoPersonal, array $documentos): bool
    {    
    $result = true;

    $sql_edit = "UPDATE op_rh_personal SET 
    no_colaborador = ?, fecha_ingreso = ?, nombre_completo = ?, puesto = ?, sd = ? WHERE id = ?";
    $stmt_sql_edit = $this->con->prepare($sql_edit);
    if (!$stmt_sql_edit):
    $result = false;
    throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
    endif;

    $stmt_sql_edit->bind_param("isssdi", $infoPersonal[3], $infoPersonal[2], $infoPersonal[4], $infoPersonal[5], $infoPersonal[6], $infoPersonal[1]);
    if (!$stmt_sql_edit->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt_sql_edit->error);
    endif;
    $stmt_sql_edit->close();

    $datosPersonal = $this->herramientasDptoOperativo->obtenerDatosPersonal($infoPersonal[1]);
    $nombrePersonal = $datosPersonal['nombre_personal'];

    if ($documentos[0] != ''): 
    $indice = 0;
    $ruta1 = "requisicion";
    $ruta2 = "Requisicion";
    $consulta = "requisicion";
    $this->editarArchivosPersonal($infoPersonal[1], $documentos, $indice, $ruta1, $ruta2, $nombrePersonal, $consulta);
    endif;

    if ($documentos[1] != ''):
    $indice = 1;
    $ruta1 = "curriculum";
    $ruta2 = "Curriculum";
    $consulta = "curriculum";
    $this->editarArchivosPersonal($infoPersonal[1], $documentos, $indice, $ruta1, $ruta2, $nombrePersonal, $consulta);
    endif;

    if ($documentos[2] != ''):
    $indice = 2;
    $ruta1 = "ine";
    $ruta2 = "Identificacion";
    $consulta = "ine";
    $this->editarArchivosPersonal($infoPersonal[1], $documentos, $indice, $ruta1, $ruta2, $nombrePersonal, $consulta);
    endif;
 
    if ($documentos[3] != ''):
    $indice = 3;
    $ruta1 = "acta_nacimiento";
    $ruta2 = "Acta de Nacimiento";
    $consulta = "acta_nacimiento";
    $this->editarArchivosPersonal($infoPersonal[1], $documentos, $indice, $ruta1, $ruta2, $nombrePersonal, $consulta);
    endif;

    if ($documentos[4] != ''):
    $indice = 4;
    $ruta1 = "comprobante_domicilio";
    $ruta2 = "Comprobante de Domicilio";
    $consulta = "c_domicilio";
    $this->editarArchivosPersonal($infoPersonal[1], $documentos, $indice, $ruta1, $ruta2, $nombrePersonal, $consulta);
    endif;

    if ($documentos[5] != ''):
    $indice = 5;
    $ruta1 = "nss";
    $ruta2 = "Comprobante IMSS";
    $consulta = "nss";
    $this->editarArchivosPersonal($infoPersonal[1], $documentos, $indice, $ruta1, $ruta2, $nombrePersonal, $consulta);
    endif;

    if ($documentos[6] != ''):
    $indice = 6;
    $ruta1 = "comprobante_estudios";
    $ruta2 = "Comprobante de Estudios";
    $consulta = "c_estudios";
    $this->editarArchivosPersonal($infoPersonal[1], $documentos, $indice, $ruta1, $ruta2, $nombrePersonal, $consulta);
    endif;

    if ($documentos[7] != ''):
    $indice = 7;
    $ruta1 = "cartas_recomendacion";
    $ruta2 = "Carta de Recomendacion";
    $consulta = "c_recomendacion";
    $this->editarArchivosPersonal($infoPersonal[1], $documentos, $indice, $ruta1, $ruta2, $nombrePersonal, $consulta);
    endif;

    if ($documentos[8] != ''):
    $indice = 8;
    $ruta1 = "curp";
    $ruta2 = "CURP";
    $consulta = "curp";
    $this->editarArchivosPersonal($infoPersonal[1], $documentos, $indice, $ruta1, $ruta2, $nombrePersonal, $consulta);
    endif;

    if ($documentos[9] != ''):
    $indice = 9;
    $ruta1 = "acta_infonavit";
    $ruta2 = "Aviso Infonavit";
    $consulta = "a_infonavit";
    $this->editarArchivosPersonal($infoPersonal[1], $documentos, $indice, $ruta1, $ruta2, $nombrePersonal, $consulta);
    endif;

    if ($documentos[10] != ''):
    $indice = 10;
    $ruta1 = "rfc";
    $ruta2 = "RFC";
    $consulta = "rfc";
    $this->editarArchivosPersonal($infoPersonal[1], $documentos, $indice, $ruta1, $ruta2, $nombrePersonal, $consulta);
    endif;

    if ($documentos[11] != ''):
    $indice = 11;
    $ruta1 = "carta_antecedentes";
    $ruta2 = "Antecedentes Penales";
    $consulta = "c_antecedentes";
    $this->editarArchivosPersonal($infoPersonal[1], $documentos, $indice, $ruta1, $ruta2, $nombrePersonal, $consulta);
    endif;

    if ($documentos[12] != ''):
    $indice = 12;
    $ruta1 = "contrato";
    $ruta2 = "Contrato";
    $consulta = "contrato";
    $this->editarArchivosPersonal($infoPersonal[1], $documentos, $indice, $ruta1, $ruta2, $nombrePersonal, $consulta);
    endif;

    return $result;
    }

    public function editarProcesoBaja(int $idBaja, string $Proceso, int $Status, string $Solucion): bool
    {    
    $result = true;

    $sql_edit = "UPDATE op_rh_personal_baja SET solucion = ?,
    proceso = ?, estado_proceso = ? WHERE id = ?";
    $stmt_sql_edit = $this->con->prepare($sql_edit);
    if (!$stmt_sql_edit):
    $result = false;
    throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
    endif;

    $stmt_sql_edit->bind_param("ssii", $Solucion, $Proceso, $Status, $idBaja);
    if (!$stmt_sql_edit->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt_sql_edit->error);
    endif;
    $stmt_sql_edit->close();

    return $result;
    }


    /* ---------- ELIMINAR ----------*/
    public function eliminarArchivoBajaPersonal(int $idArchivo): bool
    {
    $result = true;
    $sql_delete = "DELETE FROM op_rh_personal_baja_archivos WHERE id = ?";
    $stmt_delete = $this->con->prepare($sql_delete);
    if (!$stmt_delete):
    $result = false;
    throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
    endif;
        
    $stmt_delete->bind_param("i", $idArchivo);
        
    if (!$stmt_delete->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt_delete->error);
    endif;

    $stmt_delete->close();
    return $result;
    }

    public function eliminarArchivoListaNegra(int $idArchivo): bool
    {
    $result = true;
    $sql_delete = "DELETE FROM op_rh_personal_lista_negra_archivos WHERE id = ?";
    $stmt_delete = $this->con->prepare($sql_delete);
    if (!$stmt_delete):
    $result = false;
    throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
    endif;
        
    $stmt_delete->bind_param("i", $idArchivo);
        
    if (!$stmt_delete->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt_delete->error);
    endif;

    $stmt_delete->close();
    return $result;
    }

    public function eliminarListaNegraPersonal(int $idListaNegra): bool
    {
    $result = true;
    $sql_delete = "DELETE FROM op_rh_personal_lista_negra WHERE id = ?";
    $stmt_delete = $this->con->prepare($sql_delete);
    if (!$stmt_delete):
    $result = false;
    throw new Exception("Error al preparar la consulta SQL: " . $this->con->error);
    endif;
        
    $stmt_delete->bind_param("i", $idListaNegra);
        
    if (!$stmt_delete->execute()):
    $result = false;
    throw new Exception("Error al ejecutar la consulta SQL: " . $stmt_delete->error);
    endif;

    $stmt_delete->close();
    return $result;
    }


}  