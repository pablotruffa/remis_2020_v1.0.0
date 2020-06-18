@extends('layout.main')
@section('title','Nuevo chofer')
@push('styles')
<link href="{{ url('css/drivers.css') }}" rel="stylesheet">
@endpush
@section('main')
<div class="main-content">
<h1 class="underline mt-2">Agregar un nuevo chofer.</h1>
<section>
<form action="{{ route('driver.create')}}" method="post" enctype="multipart/form-data">
@csrf
  <div class="form-group">
    <label for="first_name">Nombre</label>
    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}">
            @if($errors->has('first_name'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('first_name') }}</p></div>
            @endif
  </div>
  <div class="form-group">
    <label for="last_name">Apellido</label>
    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}">
            @if($errors->has('last_name'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('last_name') }}</p></div>
            @endif
  </div>
  <div class="form-group">
    <label for="email">E-mail</label>
    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
            @if($errors->has('email'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('email') }}</p></div>
            @endif
  </div>
  <div class="form-group">
    <label for="identification">DNI / PASAPORTE</label>
    <input type="text" class="form-control" id="identification" name="identification_card_number" value="{{ old('identification_card_number') }}">
            @if($errors->has('identification_card_number'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('identification_card_number') }}</p></div>
            @endif
  </div>
  <div class="form-group">
    <label for="car_license">Número de licencia de conducir</label>
    <input type="text" class="form-control" id="car_license" name="car_license" value="{{ old('car_license') }}">
            @if($errors->has('car_license'))
                <div class="alert alert-danger"><p class="danger">{{ $errors->first('car_license') }}</p></div>
            @endif
  </div>
  <div class="form-group">
    <label for="birthday">Fecha de nacimiento</label>
    <input type="date" class="form-control" id="birthday" name="date_of_birth" value="{{ old('date_of_birth') }}">
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
  <button type="submit" class="btn btn-primary">Agregar chofer</button>
</form>
</section>

</div>
@endsection