<?php

// conexion 
$servername = "localhost";  
$username = "Miguel";   
$password = "admin";
$database = "hotelmiranda"; 

$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// query 
$sql = "SELECT * FROM rooms"; 
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    echo "<ol>";

    while ($room = $result->fetch_assoc()) {
        echo "<li>";
        
        echo "<strong>Habitación " . htmlspecialchars($room['room_number']) . "</strong><br>";
        echo "Tipo: " . htmlspecialchars($room['room_type']) . "<br>";
        echo "Descripción: " . htmlspecialchars($room['description']) . "<br>";
        echo "Precio por noche: $" . htmlspecialchars($room['price']) . "<br>";

      
        if (!empty($room['offer_price'])) {
            echo "Descuento: " . htmlspecialchars($room['discount']) . "%<br>";
        }

        echo "Estado: " . htmlspecialchars($room['status']) . "<br>";

        
        if (!empty($room['room_photo'])) {
            echo '<img src="' . htmlspecialchars($room['room_photo']) . '" alt="Foto de la habitación" width="200"><br>';
        }

        echo "</li>";
    }

    echo "</ol>";
} else {
    echo "<p>No hay habitaciones disponibles.</p>";
}


$conn->close();

?>
