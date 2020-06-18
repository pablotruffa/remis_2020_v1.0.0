
@extends('layout.main')
@section('title','Editar vehículo')

@push('styles')
<link href="{{ url('css/vehicles.css') }}" rel="stylesheet">
@endpush

@section('main')
<div class="main-content">
<h1 class="underline my-2">Editando vehículo.</h1>
<section>
<form action="{{ route('vehicle.edit', ['id' => $vehicle->id] )}}" method="post" enctype="multipart/form-data">
@csrf
@method('PUT')
  <div class="form-group">
    <label for="brand">Marca</label>
    <label for="brand"></label>
    <select class="form-control" id="brand" name="id_brand">
      @foreach($brands as $brand)
      <option value="{{ $brand->id }}" 
            {{ $vehicle->brand->id == $brand->id ? 'selected' : '' }} 
            {{ old('id_brand') == $brand->id ? 'selected' : '' }} >{{ $brand->brand }}
      </option>
      @endforeach
    </select>
        @if($errors->has('id_brand'))
            <div class="alert alert-danger"><p class="danger">{{ $errors->first('id_brand') }}</p></div>
        @endif
  </div>
  <div class="form-group">
    <label for="model">Modelo</label>
    <input type="text" class="form-control" id="model" name="model" 
    value="{{ old('model') ?? $vehicle->model }}">
  </div>
        @if($errors->has('model'))
            <div class="alert alert-danger"><p class="danger">{{ $errors->first('model') }}</p></div>
        @endif
  <div class="form-group">
    <label for="patent">Patente</label>
    <input type="text" class="form-control" id="patent" name="patent" 
    value="{{ old('patent') ?? $vehicle->patent}}">
  </div>
        @if($errors->has('patent'))
            <div class="alert alert-danger"><p class="danger">{{ $errors->first('patent') }}</p></div>
        @endif
  <div class="form-group">
    <label for="year">Año</label>
    <input type="number" class="form-control" id="year" name="year" 
    value="{{ old('year') ?? $vehicle->year }}">
  </div>
        @if($errors->has('year'))
            <div class="alert alert-danger"><p class="danger">{{ $errors->first('year') }}</p></div>
        @endif
  <div class="form-group">
    <label for="color">Color</label>
    <select class="form-control" id="color" name="id_color">
      @foreach($colors as $color)
      <option value="{{ $color->id }}" 
            {{ $vehicle->color->id == $color->id ? 'selected' : '' }} 
            {{ old('id_color') == $color->id ? 'selected' : '' }} >{{ $color->color }}
      </option>
      @endforeach
    </select>
        @if($errors->has('id_color'))
            <div class="alert alert-danger"><p class="danger">{{ $errors->first('id_color') }}</p></div>
        @endif
  </div>
  <div class="form-group">
    <label for="picture">Imagen de perfil</label>
    <input type="file" class="form-control" id="picture" name="picture">
  </div>
        @if($errors->has('picture'))
            <div class="alert alert-danger"><p class="danger">{{ $errors->first('picture') }}</p></div>
        @endif
  
  @if($vehicle->picture)
  
    <div>
    <p>Imagen del vehículo</p>
    <picture><img width="250" src="{{ url('vehicle_pictures/'.$vehicle->picture)}}" alt="Foto del vehículo"></picture>
    </div>
  @endif
  <button class="btn btn-remis-dark btn-block" type="submit" class="btn btn-primary">Editar vehículo</button>
</form>
</section>
</div>

@endsection