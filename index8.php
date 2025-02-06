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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = uniqid();
    $room_number = $_POST['room_number'];
    $bed_type = $_POST['bed_type'];
    $name = $_POST['name'];
    $facilities = $_POST['facilities'];
    $price = $_POST['price'];
    $status = $_POST['status'];
    $photo = $_POST['photo'];

    $sql = "INSERT INTO rooms (id, room_number, bed_type, name, facilities, price, status, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisssdss", $id, $room_number, $bed_type, $name, $facilities, $price, $status, $photo);
    $stmt->execute();
    $stmt->close();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Crear Habitación</title>
</head>
<body>
    <h2>Crear Nueva Habitación</h2>
    <form method="POST">
        Número de Habitación: <input type="number" name="room_number" required><br>
        Tipo de Cama:
        <select name="bed_type" required>
            <option value="Suite">Suite</option>
            <option value="Double Bed">Double Bed</option>
            <option value="Double Superior">Double Superior</option>
            <option value="Single Bed">Single Bed</option>
        </select><br>
        Descripción: <input type="text" name="name" required><br>
        Facilidades: <textarea name="facilities" required></textarea><br>
        Precio por Noche: <input type="number" step="0.01" name="price" required><br>
        Estado:
        <select name="status" required>
            <option value="Available">Available</option>
            <option value="Booked">Booked</option>
        </select><br>
        URL de la Foto: <input type="text" name="photo"><br>
        <input type="submit" value="Guardar Habitación">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = "SELECT * FROM rooms WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "<h3>Habitación Creada:</h3><ol>";
            while ($room = $result->fetch_assoc()) {
                echo "<li>";
                echo "<strong>Habitación " . htmlspecialchars($room['room_number']) . "</strong><br>";
                echo "Tipo: " . htmlspecialchars($room['bed_type']) . "<br>";
                echo "Descripción: " . htmlspecialchars($room['name']) . "<br>";
                echo "Facilidades: " . htmlspecialchars($room['facilities']) . "<br>";
                echo "Precio por noche: $" . htmlspecialchars($room['price']) . "<br>";
                echo "Estado: " . htmlspecialchars($room['status']) . "<br>";
                if (!empty($room['photo'])) {
                    echo '<img src="' . htmlspecialchars($room['photo']) . '" alt="Foto de la habitación" width="200"><br>';
                }
                echo "</li>";
            }
            echo "</ol>";
        }
        $stmt->close();
    }
    $conn->close();
    ?>
</body>
</html>
