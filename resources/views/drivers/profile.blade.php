@extends('layout.main')
@section('title','Perfil')
@push('styles')
<link href="{{ url('css/drivers.css') }}" rel="stylesheet">
@endpush
@section('main')
<div class="main-content">
<h1 class="underline mt-2">Perfil</h1>
@if(Session::has('message'))
      <div class="alert alert-{{Session::get('message.class')}}">
                  <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                  <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
      </div>
@endif
<section>
    @if($driver->picture != null || $driver->picture != '' )
    <img id="driver-profile" class="img-thumbnail" width="300" src="{{ url('driver_profile_pictures/' . $driver->picture) }}" alt="{{ $driver->first_name .' '. $driver->last_name }}">
    @else
    <img width="100" src="{{ url('assets/logo.jpg') }}" alt="logo">
    @endif

    <ul id="driver-data">
        <li><span>Nombre:</span><span>{{$driver->first_name.' '.$driver->last_name}}</span></li>
        <li><span>E-mail:</span><span>{{$driver->email}}</span></li>
        <li><span>Contraseña: <a href="{{route('profile.password')}}">Cambiar</a></span><span>**********</span></li>
        <li><span>DNI / Pasaporte:</span><span>{{$driver->identification_card_number}}</span></li>
        <li><span>Fecha de nacimiento:</span><span>{{$dt->day.'/'.$dt->month.'/'.$dt->year}}</span></li>
        <li><span>Registrado en sistema desde:</span><span>{{$driver->created_at}}</span></li>
    </ul>   
</section>
</div>
@endsection