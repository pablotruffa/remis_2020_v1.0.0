@extends('layout.main')
@section('title','Auditorias')
@push('styles')
<link href="{{ url('css/audit.css') }}" rel="stylesheet">
@endpush
@section('main')
<div class="main-content">
<h1 class="underline my-2">Auditoría</h1>
@if(Session::has('message'))
    <div class="alert alert-{{Session::get('message.class')}}">
                <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
    </div>
@endif
<div class="mb-5">
<form action="{{route('audit.date')}}" method="get">

    <div class="form-group col-md-6">
      <label for="from">Desde</label>
      <input type="date" class="form-control" id="from" name="from" value="{{ date('Y-m-d', time()) }}" max="{{ date('Y-m-d', time()) }}">
    </div>
    <div class="form-group col-md-6">
      <label for="to">Hasta</label>
      <input type="date" class="form-control" id="to" name="to" value="{{ date('Y-m-d', time()) }}" max="{{ date('Y-m-d', time()) }}">
    </div>

<div><button class="btn btn-remis-dark btn-block">Buscar</button></div>
</form>
</div>

<section id="audit">
        
    <p>Resultados {{date('d-m-Y',strtotime($dates['from'])).' - '.date('d-m-Y',strtotime($dates['to']))}}</p>
    <h2  class="mt-1">Reservas</h2>
        <ul class="data-list">
        @foreach($audit->getStatus() as $status => $value)
            <li><span>{{$status}}</span><span>{{$value}}</span></li>
        @endforeach
        </ul>
  
    <h2  class="mt-1">Ingresos</h2>
        <ul class="data-list">
            <li><span>Esperado</span><span>${{ $audit->getExpectedIncome() }} ARS</span></li>
            <li><span>Alcanzado</span><span>${{ $audit->getGlobalIncome() }} ARS</span></li>
            <li><span>Para la Remisería</span><span>${{ $audit->getHouseIncome() }} ARS</span></li>
            <li><span>Para los Choferes</span><span>${{ $audit->getDriversIncome() }} ARS</span></li>
        </ul>

        @if( count($audit->getCompletedReservations()) > 0 )
        
        <h2 class="mt-1">Reservas concretadas</h2>
        <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                <th># Reserva</th>
                <th>Fecha</th>
                <th>Precio</th>
                <th>% Comisión</th>
                <th>Ingreso Remisería</th>
                <th>Ingreso Choferes</th>
                <th>Subtotal</th>
                <th>Total</th>
                </tr>   
            </thead>
            <tbody>
                <?php $partial = 0;?>
                @foreach( $audit->getCompletedReservations() as $reservation )
                <tr>
                    <td>{{ $reservation->confirmation_number }}</td>
                    <td>{{ date('d-m-Y',strtotime($reservation->travel_date)) }}</td>
                    <td>{{ $reservation->price }}</td>
                    <td>{{ $reservation->commission_percentage }}</td>
                    <td>{{ $reservation->getHouseIncome() }}</td>
                    <td>{{ $reservation->getDriversIncome() }}</td>
                    <td>{{ $reservation->price }}</td>
                    <?php $total = $partial + $reservation->price;?>
                    <td>{{ $total }}</td>
                    <?php $partial = $total;?>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        @endif
</section>
</div>

    
    
    

@endsection
