<?php

// Conexión a la base de datos
$servername = "localhost";  
$username = "Miguel";   
$password = "admin";
$database = "hotelmiranda"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Variable de búsqueda
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Consulta condicional según la búsqueda
if (!empty($search)) {
    $sql = "SELECT * FROM rooms WHERE name LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchParam = "%" . $search . "%";
    $stmt->bind_param("s", $searchParam);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM rooms";
    $result = $conn->query($sql);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Habitaciones</title>
</head>
<body>

    <h1>Listado de Habitaciones</h1>

    <form>
        <input type="text" name="search" placeholder="Buscar habitación..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Buscar</button>
    </form>

    <?php
    if ($result->num_rows > 0) {
        echo "<ol>";

        while ($room = $result->fetch_assoc()) {
            echo "<li>";
            echo "<strong>Habitación " . htmlspecialchars($room['room_number']) . "</strong><br>";
            echo "Tipo: " . htmlspecialchars($room['bed_type']) . "<br>";
            echo "Descripción: " . htmlspecialchars($room['name']) . "<br>";
            echo "Precio por noche: $" . htmlspecialchars($room['price']) . "<br>";
            echo "Estado: " . htmlspecialchars($room['status']) . "<br>";

            if (!empty($room['photo'])) {
                echo '<img src="' . htmlspecialchars($room['photo']) . '" alt="Foto de la habitación" width="200"><br>';
            }

            echo "</li>";
        }

        echo "</ol>";
    } else {
        echo "<p>No se encontraron habitaciones.</p>";
    }

    // Cerrar conexión
    if (!empty($stmt)) {
        $stmt->close();
    }
    $conn->close();
    ?>

</body>
</html>
