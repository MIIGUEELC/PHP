<?php


$jsonData = file_get_contents('roomsData.json');

$rooms = json_decode($jsonData, true);


if ($rooms && is_array($rooms)) {
    echo "<ol>";

  
    foreach ($rooms as $room) {
        echo "<li>";
        
        
        echo "<strong>Habitación " . htmlspecialchars($room['room_number']) . "</strong><br>";
        echo "Tipo: " . htmlspecialchars($room['room_type']) . "<br>";
        echo "Descripción: " . htmlspecialchars($room['description']) . "<br>";
        echo "Precio por noche: $" . htmlspecialchars($room['price']) . "<br>";

       
        if ($room['offer_price']) {
            echo "Descuento: " . htmlspecialchars($room['discount']) . "%<br>";
        }

        echo "Estado: " . htmlspecialchars($room['status']) . "<br>";

     
        echo "<strong>Amenidades:</strong><ul>";
        foreach ($room['amenities'] as $amenity) {
            echo "<li>" . htmlspecialchars($amenity['name']) . ": " . htmlspecialchars($amenity['description']) . "</li>";
        }
        echo "</ul>";

        echo "</li>";
    }

    echo "</ol>";
} else {
    echo "<p>Error al cargar los datos de las habitaciones.</p>";
}

?>
