<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/table.css">
    <title>Resumen</title>
</head>
<body>

<div class="main-content">
<h1 class="underline mt-2">Resumen de viajes</h1>
<p>Usuario: {{$user->email}}</p>

<p>Resultados entre {{date('d-m-y',strtotime($from))}} / {{date('d-m-y',strtotime($to))}}</p>
<div class="table-responsive">
    <table class="table" >
      <thead>
        <tr>
          <th># Reserva</th>
          <th>Fecha</th>
          <th>Origen</th>
          <th>Destino</th>
          <th>Precio</th>
          <th>Vehículos</th>
          <th>Comisión a Base</th>
          <th>Subtotal</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
    <?php $partial = 0;?>
    @foreach($balance->getReservations() as $reservation)
    <tr>
        <td>{{$reservation->confirmation_number}}</td>
        <td>{{$reservation->travel_date}}</td>
        <td>{{$reservation->origin}}</td>
        <td>{{$reservation->destiny}}</td>
        <td>{{$reservation->price}}</td>
        <td>{{$reservation->vehicle_quantity}}</td>
        <td>% {{$reservation->commission_percentage}}</td>
        <td>{{$reservation->getDriverIncome()}}</td>
        <?php $total = $partial + $reservation->getDriverIncome() ;?>
        <td>{{$total}}</td>
        <?php $partial = $total;?>
        
    </tr>
    @endforeach
    </table>
</div>
</div>
</body>
</html>
