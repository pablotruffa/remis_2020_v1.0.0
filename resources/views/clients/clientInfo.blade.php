@extends('layout.main')
@section('title','Información del cliente')
@push('styles')
<link href="{{ url('css/clients.css') }}" rel="stylesheet">
@endpush
@section('main')
<div class="main-content">
<h1 class="underline mt-2">Información del cliente</h1>
@if(Session::has('message'))
      <div class="alert alert-{{Session::get('message.class')}}">
                  <p class="{{Session::get('message.class')}}"><span class="title">{{Session::get('message.title')}}</span>{{Session::get('message.content')}}</p>
                  <a href="#" id="closeBtn">Close<i class="gg-close-r {{Session::get('message.class')}}"></i></a>
      </div>
@endif
<section>
    <div>
        @if($client->picture != null || $client->picture != '' )
        <img id="client-profile" src="{{ url('client_profile_pictures/' . $client->picture) }}" alt="{{ $client->first_name .' '. $client->last_name }}">
        @else
        <p id="image" class="form-control-plaintext">No dispone imagen de perfil.</p>
        @endif
    </div>
    <ul id="client-data">
        <li><span>Nombre:</span><span>{{$client->first_name}}</span></li>
        <li><span>Apellido:</span><span>{{$client->last_name}}</span></li>
        <li><span>Email</span><span>{{$client->email}}</span></li>
        <li><span>DNI / Pasaporte</span><span>{{$client->identification_card_number}}</span></li>
        <li><span>Fecha de nacimiento:</span><span>{{$dt->day.'/'.$dt->month.'/'.$dt->year }}</span></li>
    </ul>    

    @if($client->deleted_at != null)
    <div>
    <form action="{{route('client.restore',['id' => $client->id])}}" method="post">
        @csrf
        @method('PATCH')
        <button class="btn" id="patch-client">Restablecer</button>
        </form>
    </div>
    @else
    <div>
    <div><a class="btn" id="edit-client" href="{{ route('client.formEdit',['id' => $client->id]) }}">Editar</a></div>
        <form action="{{route('client.delete',['id' => $client->id])}}" method="post">
        @csrf
        @method('DELETE')
        <button class="btn" id="delete-client">Eliminar</button>
        </form>
    </div>
    @endif
</section>
</div>
@endsection