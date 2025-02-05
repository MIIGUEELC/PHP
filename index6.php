<?php


$servername = "localhost";  
$username = "Miguel";   
$password = "admin";
$database = "hotelmiranda"; 


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtengo el id de la url
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;


if ($id > 0) {
    
    $sql = "SELECT room_number, bed_type, price, photo FROM rooms WHERE room_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró la habitación
    if ($result->num_rows > 0) {
        $room = $result->fetch_assoc();

        
        echo "<h2>Detalles de la Habitación</h2>";
        echo "<p><strong>Nombre:</strong> " . htmlspecialchars($room['bed_type']) . "</p>";
        echo "<p><strong>Número:</strong> " . htmlspecialchars($room['room_number']) . "</p>";
        echo "<p><strong>Precio por noche:</strong> $" . htmlspecialchars($room['price']) . "</p>";

       
        if (!empty($room['photo'])) {
            echo '<p><strong>Foto:</strong> <img src="' . htmlspecialchars($room['photo']) . '" alt="Foto de la habitación" width="200"></p>';
        } else {
            echo "<p><strong>Foto:</strong> No disponible</p>";
        }

        // Mostrar descuento si existe
        if (!empty($room['discount'])) {
            echo "<p><strong>Descuento:</strong> " . htmlspecialchars($room['discount']) . "%</p>";
        } else {
            echo "<p><strong>Descuento:</strong> No disponible</p>";
        }
    } else {
        echo "<p>No se encontró ninguna habitación con el ID proporcionado.</p>";
    }

    // Cerrar consulta
    $stmt->close();
} else {
    echo "<p>ID de habitación no válido.</p>";
}

// Cerrar conexión
$conn->close();

?>
