@extends('layout.main')
@section('title','Información de la reserva')

@push('styles')
    <link href="{{ url('css/reservationInfo.css') }}" rel="stylesheet">
@endpush

@section('main')
<div class="main-content">
        <div class="mt-2">
        <h1 class="underline">Información de la reserva</h1>
        </div>
@if(Session::has('message'))
    <div class="alert alert-{{Session::get('message.class')}}">
                <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
    </div>
@endif

@if(isset($reservation))
<div id="reservation-actions">
      @if( in_array($reservation->reservation_status, [1,3]))
      <div class="my-1">
          <a class="btn" href="{{ route('reservation.formEdit', ['id' => $reservation->id]) }}">Editar</a>
      </div>
      @endif
      @if( !in_array($reservation->reservation_status, [4,5]))
      <div class="my-1">
        <a class="btn" href="{{ route('reservation.formCancellation', ['id' => $reservation->id]) }}">Cancelar</a>
      </div>
      @endif
</div>
@endif
@if( isset($log) )
<section id="log">
              <table class="table">
                <thead class="thead-dark">
                    <tr><th colspan="2">Detalles de la reserva</th></tr>
                </thead>
                <tbody> 
                    <tr>
                        <td>#Confirmación</td><td>{{$log->confirmation_number}}</td>
                    </tr>
                    <tr>
                        <td>Estado</td><td>{{$log->status->status}}</td>
                    </tr>
                        @if($log->status->id == 4)
                        <tr>
                            <td>Razón</td><td>{{$log->cancellation[0]->reason}}</td>
                        </tr>
                        @if( $log->cancellation[0]->pivot->remark != null)
                        <tr>
                            <td>Observaciones:</td><td>{{$log->cancellation[0]->pivot->remark}}</td>
                        </tr>

                        @endif
                        @endif
                    <tr>
                        <td>Registro</td><td>{{$log->created_at}}hs</td>
                    </tr>
                    <tr>
                        <td>Cliente</td><td>{{$log->client[0]->first_name." ".$log->client[0]->last_name}}</td>
                    </tr>
                    <tr>
                        <td>Origen</td><td>{{$log->origin}}</td>
                    </tr>
                    <tr>
                        <td>Destino</td><td>{{$log->destiny}}</td>
                    </tr>
                    <tr>
                        <td>Fecha</td><td>{{$log->travel_date}}</td>
                    </tr>
                    <tr>
                        <td>Horario</td><td>{{$log->travel_time}}</td>
                    </tr>
                    <tr>
                        <td>Cantidad de vehículos</td><td>{{$log->vehicle_quantity}}</td>
                    </tr>
                    <tr>
                        <td>Precio de la reserva</td><td>{{$log->price}}</td>
                    </tr>
                </tbody> 
             </table>
              
              @if(!isset($log->cancellation))
                  @foreach($log->driver as $driver)
                  <table class="table">
                  <thead>
                  <tr><th colspan="2">Chofer</th></tr>
                  </thead>
                  <tbody>
                    <tr>
                        <td>Nombre</td><td>{{$driver->first_name ." ".$driver->last_name}}</td>
                    </tr>
                    <tr>
                        <td>#Licencia de conducir</td><td>{{$driver->car_license}}</td>
                    </tr>
                    <tr>
                        <td>Vehículo</td>
                        <td>{{$driver->vehicle->brand->brand}} / {{$driver->vehicle->model}} / {{$driver->vehicle->year}} / {{$driver->vehicle->patent}} / {{$driver->vehicle->color->color}}</td>
                    </tr>
                  </tbody> 
                  </table>
                  @endforeach
              
              @endif
          
</section>
@else

      <section id="confirmation-list">
          <div>
          <ul class="info-list">
              <li><span>Número de confirmación:</span><span> #{{ $reservation->confirmation_number }}</span></li>
              <li><span>Registrada el día:</span><span>{{ $created }}hs</span></li>
              <li><span>Última actualización:</span><span>{{$updated}}hs</span></li>
              <li><span>Cliente:</span><span>{{ $client }}</span></li>
              <li><span>Origen:</span><span>{{ $reservation->origin }}</span></li>
              <li><span>Destino:</span><span>{{ $reservation->destiny }}</span></li>
              <li><span>Fecha:</span><span>{{ $date}}</span></li>
              <li><span>Horario:</span><span>{{ $time}}hs</span></li>
              <li><span>Cantidad de vehículos:</span><span>{{ $reservation->vehicle_quantity }}</span></li>
              <li><span>Estado:</span><span>{{ $reservation->status->status }}</span></li>
              <li><span>Precio de la reserva:</span><span> ${{ $reservation->price }} ARS</span></li>
              <li><span>Porcentaje de comisión a base:</span><span> % {{ $reservation->commission_percentage }}</span></li>
            </ul>
            </div>
            @if(count($reservation->driver) > 0 )
            <div class="driver-info">
            @foreach($reservation->driver as $key => $driver)
            <p class="my-1">Chofer {{$key +1}}:</p>
            <ul class="info-list">
            <li><span>Nombre:</span><span><a href="{{ route('driver.info',['id' => $driver->id]) }}">{{$driver->first_name.' '.$driver->last_name}}</a></span></li>
            <li><span>Licencia de conducir:</span><span>#{{$driver->car_license}}</span></li>
            </ul>
            <p class="my-1">Vehículo</p>
                <ul class="info-list mb-2">
                  <li><span>Marca:</span><span> {{ $driver->vehicle->brand->brand }}</span></li>
                  <li><span>Model:</span><span> {{ $driver->vehicle->model }}</span></li>
                  <li><span>Color:</span><span>{{ $driver->vehicle->color->color }}</span></li>
                  <li><span>Patente:</span><span>{{ $driver->vehicle->patent }}</span></li>
                </ul>
            @endforeach
          </div>
          @endif
      </section>
</div>
@endif
@endsection