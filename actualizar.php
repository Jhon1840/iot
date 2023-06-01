<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "admin";
$dbname = "Aulas";

// Conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se envió el formulario de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_aula = $_POST['id_aula'];
    $piso = $_POST['piso'];
    $modulo = $_POST['modulo'];
    $estado = $_POST['estado'];
    $tipo = $_POST['tipo'];

    // Actualizar el registro en la tabla "aula"
    $sql = "UPDATE aula SET piso='$piso', modulo='$modulo', estado='$estado', tipo='$tipo' WHERE id_aula='$id_aula'";

    if ($conn->query($sql) === TRUE) {
        echo "Registro actualizado correctamente.";
    } else {
        echo "Error al actualizar el registro: " . $conn->error;
    }
}

// Obtener el ID del registro a actualizar
$id_aula = $_GET['id'];

// Obtener los datos del registro de la tabla "aula"
$sql = "SELECT * FROM aula WHERE id_aula='$id_aula'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $aula = $result->fetch_assoc();
    ?>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="id_aula" value="<?php echo $aula['id_aula']; ?>">
        <label for="piso">Piso:</label>
        <input type="text" name="piso" value="<?php echo $aula['piso']; ?>"><br>
        <label for="modulo">Módulo:</label>
        <input type="text" name="modulo" value="<?php echo $aula['modulo']; ?>"><br>
        <label for="estado">Estado:</label>
        <input type="text" name="estado" value="<?php echo $aula['estado']; ?>"><br>
        <label for="tipo">Tipo:</label>
        <input type="text" name="tipo" value="<?php echo $aula['tipo']; ?>"><br>
        <input type="submit" value="Actualizar">
    </form>
    <?php
} else {
    echo "No se encontró el registro.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>