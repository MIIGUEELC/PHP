<?php

$jsonData = file_get_contents('roomsdata.json');

$rooms = json_decode($jsonData, true);

echo "<pre>";
echo htmlspecialchars($jsonData); 
echo "</pre>";
?>
