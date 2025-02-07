<?php


require 'BladeOne.php';  
use eftec\bladeone\BladeOne;

if (!file_exists('BladeOne.php')) {
    die("El archivo BladeOne.php no se encuentra.");
}



$views = __DIR__ . '/views';  
$cache = __DIR__ . '/cache';  
$blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);


$servername = "localhost";
$username = "Miguel";
$password = "admin";
$database = "hotelmiranda";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);

$rooms = [];
if ($result->num_rows > 0) {
    while ($room = $result->fetch_assoc()) {
        $rooms[] = $room;
    }
}

$conn->close();

// con esto realmente le paso los datos a las views con la variable  $rooms y lo reenderiza
//echo $blade->run("rooms", ["rooms" => $rooms]);
echo $blade->run("rooms",compact("rooms")); // pasa los parametro mas rapidamente.

?>
