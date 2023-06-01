<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Aulas";

// Función para establecer la conexión a la base de datos
function conectarBaseDatos()
{
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    return $conn;
}

// Función para obtener todos los registros de la tabla "aula"
function obtenerAulas()
{
    $conn = conectarBaseDatos();
    $sql = "SELECT * FROM aula";
    $result = $conn->query($sql);
    $aulas = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $aulas[] = $row;
        }
    }

    $conn->close();
    return $aulas;
}

// Función para crear un nuevo registro en la tabla "aula"
function crearAula($aula)
{
    $conn = conectarBaseDatos();
    $id_aula = $aula['id_aula'];
    $piso = $aula['piso'];
    $modulo = $aula['modulo'];
    $estado = $aula['estado'];
    $tipo = $aula['tipo'];

    $sql = "INSERT INTO aula (id_aula, piso, modulo, estado, tipo) VALUES ('$id_aula', '$piso', '$modulo', '$estado', '$tipo')";

    if ($conn->query($sql) === TRUE) {
        $response = ["message" => "Aula creada exitosamente"];
    } else {
        $response = ["error" => "Error al crear el aula: " . $conn->error];
    }

    $conn->close();
    return $response;
}

// Función para actualizar un registro en la tabla "aula"
function actualizarAula($id_aula, $aula)
{
    $conn = conectarBaseDatos();
    $piso = $aula['piso'];
    $modulo = $aula['modulo'];
    $estado = $aula['estado'];
    $tipo = $aula['tipo'];

    $sql = "UPDATE aula SET piso='$piso', modulo='$modulo', estado='$estado', tipo='$tipo' WHERE id_aula='$id_aula'";

    if ($conn->query($sql) === TRUE) {
        $response = ["message" => "Aula actualizada exitosamente"];
    } else {
        $response = ["error" => "Error al actualizar el aula: " . $conn->error];
    }

    $conn->close();
    return $response;
}


function eliminarAula($id_aula)
{
    $conn = conectarBaseDatos();

    $sql = "DELETE FROM aula WHERE id_aula='$id_aula'";

    if ($conn->query($sql) === TRUE) {
        $response = ["message" => "Aula eliminada exitosamente"];
    } else {
        $response = ["error" => "Error al eliminar el aula: " . $conn->error];
    }

    $conn->close();
    return $response;
}


$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Obtener todos los registros de aula
        $aulas = obtenerAulas();
        echo json_encode($aulas);
        break;

    case 'POST':
        // Crear un nuevo registro en aula
        $data = json_decode(file_get_contents('php://input'), true);
        $response = crearAula($data);
        echo json_encode($response);
        break;

    case 'PUT':
        // Actualizar un registro en aula
        $id_aula = $_GET['id_aula'];
        $data = json_decode(file_get_contents('php://input'), true);
        $response = actualizarAula($id_aula, $data);
        echo json_encode($response);
        break;

    case 'DELETE':
        // Eliminar un registro de aula
        $id_aula = $_GET['id_aula'];
        $response = eliminarAula($id_aula);
        echo json_encode($response);
        break;

    default:
        // Método no permitido
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>