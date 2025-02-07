<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Habitaciones</title>
</head>
<body>
    <h2>Habitaciones Disponibles</h2>

    @if(count($rooms) > 0)
        <ol>
            @foreach($rooms as $room)
                <li>
                <strong>Habitación {{ $room['room_number'] }}</strong><br>
                    Tipo: {{ $room['bed_type'] }}<br>
                    Descripción: {{ $room['name'] }}<br>
                    Precio por noche: ${{ $room['price'] }}<br>
                    Estado: {{ $room['status'] }}<br>
                    @if (!empty($room['photo']))
                        <br><img src="{{ $room['photo'] }}" alt="Foto de la habitación" width="200"><br>
                    @endif
                </li>
            @endforeach
        </ol>
    @else
        <p>No hay habitaciones disponibles.</p>
    @endif

</body>
</html>
