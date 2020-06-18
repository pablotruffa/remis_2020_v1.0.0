@extends('layout.main')
@section('title','Remis v.2020')
@push('styles')
<link href="{{ url('css/welcome.css') }}" rel="stylesheet">
@endpush
@section('main')
<div class="main-content">
<h1 class="underline mt-2">Bienvenidos a Remis v.2020</h1>
@if(Session::has('message'))
    <div class="alert alert-{{Session::get('message.class')}}">
                <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
    </div>
@endif

<h2>Primeros pasos</h2>
@if(Session::get('level') == 'Root' || Session::get('level') == 'Admin')
<section class="welcome">
<h3>Clientes</h2>
  <div>
  <ol>
    <li>Para tomar reservas es necesario registrar a los clientes primero. <a href="{{route('client.formNew')}}">Nuevo Cliente</a></li>
    <li>Luego de haber registrado al cliente podemos registrar una reserva a nombre del cliente. <a href="{{route('reservation.create')}}">Reservar</a></li>
  </ol>
</div>
<h3>La reserva</h2>
<div>
  <ol>
    <li>Cuando la reserva se encuentre en la fecha de viaje podrá ser iniciada <a href="{{route('reservations.index')}}">Panel</a></li>
    <li>Estando iniciada y en fecha, la misma podrá ser revertida, edita y/o finalizada.</li>
  </ol>
</div>
<h3>Choferes</h2>
<div>
  <ol>
    <li>Para que una reserva pueda iniciarse, deben haber choferes disponibles para tomar la reserva: <a href="{{route('drivers.index')}}">Choferes</a></li>
    <li>A su vez, los choferes deben estar presentes: <a href="{{route('presenteeism.index')}}">Presentismo</a></li>
    <li>Podras registrar choferes completando el formulario. <a href="{{route('driver.formNew')}}">Registrar chofer</a></li>
  </ol>
</div>
<h3>Vehículos</h2>
<div>
  <ol>
    <li>Toda reserva necesita un chofer y todo chofer necesita un vehículo. <a href="{{route('vehicles.index')}}">Vehículos</a></li>
    <li>Los vehículos pueden ser asignados a los choferes y viceversa.</li>
  </ol>
</div>
</section>
@else
  <section class="welcome">
    <h3>Perfil</h3>
    <div>
      <ol>
        <li>Revisá tu perfil y actualizá tu contenido.</li>
      </ol>
    </div>
    <h3>Viajes</h3>
    <div>
      <ol>
        <li>Podras revisar tus viajes realizados, los detalles, fechas, etc.</li>
        <li>Descargá un informe de tus viajes.</li>
      </ol>
    </div>
    <h3>Billetera</h3>
    <ol>
      <li>La billetera virtual lleva el registro de las ganancias y gastos de los vaijes que realizas.</li>
      <li>La misma te mostrará un resumen global y un resumen detallado.</li>
    </ol>
  </section>
@endif

</div>



@endsection