<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Aulas";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Función para obtener todos los registros de la tabla "aula"
function obtenerAulas($conn)
{
    $sql = "SELECT * FROM aula";
    $result = $conn->query($sql);
    $aulas = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $aulas[] = $row;
        }
    }

    return $aulas;
}

// Mostrar los registros de la tabla "aula" en una tabla HTML
function mostrarAulas($aulas)
{
    echo "<table>
            <tr>
                <th>ID Aula</th>
                <th>Piso</th>
                <th>Módulo</th>
                <th>Estado</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>";

    foreach ($aulas as $aula) {
        echo "<tr>";
        echo "<td>" . $aula['id_aula'] . "</td>";
        echo "<td>" . $aula['piso'] . "</td>";
        echo "<td>" . $aula['modulo'] . "</td>";
        echo "<td>" . $aula['estado'] . "</td>";
        echo "<td>" . $aula['tipo'] . "</td>";
        echo "<td><a href='actualizar.php?id=" . $aula['id_aula'] . "'>Actualizar</a></td>";
        echo "</tr>";
    }

    echo "</table>";
}

// Obtener y mostrar los registros de la tabla "aula"
$aulas = obtenerAulas($conn);
mostrarAulas($aulas);

// Cerrar la conexión a la base de datos
$conn->close();
?>