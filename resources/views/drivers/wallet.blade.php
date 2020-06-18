@extends('layout.main')
@section('title','Billetera')
@push('styles')
<link href="{{ url('css/drivers.css') }}" rel="stylesheet">
@endpush
@section('main')
<div class="main-content">
<h1 class="underline mt-2">Mi Billetera</h1>

    <h2 class="mt-1">Resumen</h2>
    <ul class="driver-data">
        <li><span>Ingresos</span><span>${{$balance->getIncome()}}</span></li>
        <li><span>Descuentos</span><span>${{$balance->getExpenses()}}</span></li>
        <li><span>Total</span><span>${{$balance->getIncome() - $balance->getExpenses()}}</span></li>
    </ul>
    
    <h2 class="mt-1">Registros</h2>
    @if(count($balance->getReservations()) != 0)
    
    <div class="table-responsive">
    <table class="table">
        <thead class="thead-dark">
            <tr>
            <th scope="col">Fecha</th>
            <th scope="col">Ingresos</th>
            <th scope="col">Descuentos</th>
            <th scope="col">Subtotal</th>
            <th scope="col">Total</th>
        </thead>
        <tbody>
        <?php $partial = 0;?>
        @foreach($balance->getReservations() as $reservation)
        <tr>
            <td>{{$reservation->updated_at}}</td>
            <td>{{$reservation->price / $reservation->vehicle_quantity}}</td>
            <td>% {{$reservation->commission_percentage}}</td>
            <td>{{$reservation->getDriverIncome()}}</td>
            <?php $total = $partial + $reservation->getDriverIncome() ;?>
            <td>{{$total}}</td>
            <?php $partial = $total;?>
            
        </tr>
        @endforeach
        </tbody>
        </table>
        </div>
        @else
        <p>No se encuentran registros de viajes.</p>
        @endif
</div>

@endsection
