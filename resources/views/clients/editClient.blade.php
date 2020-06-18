@extends('layout.main')
@section('title','Editando cliente')

@push('styles')
<link href="{{ url('css/clients.css') }}" rel="stylesheet">
@endpush

@section('main')
<div class="main-content">
<h1 class="underline mt-2">Editar cliente.</h1>
<section>
<p>Editando al cliente <strong>{{ $client->first_name." ". $client->last_name }}</strong></p>
<form action="{{ route('client.edit',['id' => $client->id] )}}" method="post" enctype="multipart/form-data">
@csrf
@method('PUT')
  <div class="form-group">
    <label for="first_name">Nombre</label>
    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') ?? $client->first_name}}">
            @if($errors->has('first_name'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('first_name') }}</p></div>
            @endif
  </div>
  <div class="form-group">
    <label for="last_name">Apellido</label>
    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') ?? $client->last_name }}">
            @if($errors->has('last_name'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('last_name') }}</p></div>
            @endif
            
  </div>
  <div class="form-group">
    <label for="email">E-mail</label>
    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') ?? $client->email }}">
            @if($errors->has('email'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('email') }}</p></div>
            @endif
  </div>
  <div class="form-group">
    <label for="identification">DNI / PASAPORTE</label>
    <input type="text" class="form-control" id="identification" name="identification_card_number" value="{{ old('identification_card_number') ?? $client->identification_card_number }}">
            @if($errors->has('identification_card_number'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('identification_card_number') }}</p></div>
            @endif
  </div>
  <div class="form-group">
    <label for="birthday">Fecha de nacimiento</label>
    <input type="date" class="form-control" id="birthday" name="date_of_birth" value="{{ old('date_of_birth') ?? $client->date_of_birth }}">
            @if($errors->has('date_of_birth'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('date_of_birth') }}</p></div>
            @endif
  </div>
  <div class="form-group">
    <label for="picture">Imagen de perfil</label>
    <input type="file" class="form-control" id="picture" name="picture">
            @if($errors->has('picture'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('picture') }}</p></div>
            @endif
  </div>
  @if($client->picture)
  
    <div>
    <p>Imagen de perfil actual</p>
    <picture><img width="250" src="{{ url('client_profile_pictures/'.$client->picture)}}" alt="{{$client->first_name .' '.$client->last_name}}"></picture>
    </div>
  @endif
  <button type="submit" class="btn btn-primary mt-5">Editar cliente</button>
</form>
</section>

</div>
@endsection