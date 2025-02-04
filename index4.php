<?php

// Obtengo el id desde el buscador
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;


$jsonData = file_get_contents('roomsData.json');
$rooms = json_decode($jsonData, true);


if ($rooms && is_array($rooms)) {
    // Busco la habitacion
    $roomFound = null;
    foreach ($rooms as $room) {
        if ($room['room_number'] == $id) {
            $roomFound = $room;
            break;
        }
    }

    
    if ($roomFound) {
        echo "<h2>Detalles de la Habitación</h2>";
        echo "<p><strong>Nombre:</strong> " . htmlspecialchars($roomFound['room_type']) . "</p>";
        echo "<p><strong>Número:</strong> " . htmlspecialchars($roomFound['room_number']) . "</p>";
        echo "<p><strong>Precio por noche:</strong> $" . htmlspecialchars($roomFound['price']) . "</p>";
        echo '<p><strong>Foto:</strong> <img src="' . htmlspecialchars($roomFound['room_photo'][0]) . '" alt="Foto de la habitación" width="200"></p>';


        if (!empty($roomFound['discount'])) {
            echo "<p><strong>Descuento:</strong> " . htmlspecialchars($roomFound['discount']) . "%</p>";
        } else {
            echo "<p><strong>Descuento:</strong> No disponible</p>";
        }
    } else {
        echo "<p>No se encontró ninguna habitación con el ID proporcionado.</p>";
    }
} else {
    echo "<p>Error al cargar los datos de las habitaciones.</p>";
}

?>
